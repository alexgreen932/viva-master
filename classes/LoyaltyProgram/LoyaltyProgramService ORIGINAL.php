<?php

//namespace SilkyDrum\WooCommerce;

class LoyaltyProgramService extends LoyaltyProgramDiscounts
{
	public function __construct()
	{
		add_action('init', [$this, 'initialize_hooks']);
	}

	public function initialize_hooks()
	{
		add_action('woocommerce_cart_calculate_fees', [$this, 'apply_loyalty_discount']);
		add_action('woocommerce_order_status_completed', [$this, 'update_loyalty_level'], 10, 1);
		add_filter('woocommerce_product_get_price', [$this, 'change_price'], 10, 2);
		add_filter('woocommerce_product_get_sale_price', [$this, 'change_price'], 10, 2);
		add_filter('woocommerce_get_price_html', [$this, 'change_price_html'], 10, 2);
		add_filter('woocommerce_variation_prices_price', [$this, 'apply_discount_to_variation'], 10, 3);
		add_filter('woocommerce_variation_prices_sale_price', [$this, 'apply_discount_to_variation'], 10, 3);
		add_filter('woocommerce_variable_price_html', [$this, 'modify_variable_price_html'], 10, 2);

		//----
		add_filter('woocommerce_get_variation_prices_hash', [$this, 'update_variation_prices_hash'], 10, 3);
	}

	public function apply_loyalty_discount($cart)
	{
		if (is_admin() && !defined('DOING_AJAX')) {
			return;
		}

		$user_id = get_current_user_id();
		if (!$user_id) {
			return;
		}

		$loyalty_level = $this->get_loyalty_level($user_id);

		foreach ($cart->get_cart() as $cart_item) {
			$product = $cart_item['data'];
			if ($this->is_discounted_category($product)) {
				$price = $product->get_price();
				$discounted_price = $this->get_discounted_price($price, $product, $loyalty_level);

				if ($discounted_price < $price) {
					$discount_amount = $price - $discounted_price;
					$cart->add_fee(__('Loyalty Discount', 'lp-textdomain'), -$discount_amount * $cart_item['quantity']);
				}
			}
		}
	}

	private function is_discounted_category($product)
	{
		$categories = $this->prod_categories($product->get_id());
		return !empty(array_intersect(self::DISCOUNT_CATEGORIES, $categories));
	}

	private function prod_categories($product_id = null)
	{
		if (!$product_id) {
			global $post;
			$product_id = $post->ID ?? 0;
		}

		$categories = get_the_terms($product_id, 'product_cat');
		if (!$categories || is_wp_error($categories)) {
			return [];
		}

		return wp_list_pluck($categories, 'slug');
	}

	private function get_discount_category($product)
	{
		$categories = $this->prod_categories($product->get_id());
		return !empty(array_intersect(self::DISCOUNT_CATEGORIES, $categories))
			? reset($categories)
			: null;
	}

	public function get_discounted_price($price, $product, $loyalty_level)
	{
		if (!is_numeric($price) || $price <= 0) {
			$price = (float) $product->get_regular_price();
		}

		$product_id = $product instanceof WC_Product_Variation
			? $product->get_parent_id()
			: $product->get_id();

		$categories = $this->prod_categories($product_id);

		$intersected_categories = array_intersect(self::DISCOUNT_CATEGORIES, $categories);
		$discount_category = reset($intersected_categories); // Fixed line

		if (!$discount_category) {
			return $price;
		}

		$product_attribute = $product->get_attribute(self::ATTRIBUTE);

		$discount = 0;
		if (strpos($product_attribute, self::VAR_1) !== false) {
			$discount = (float) get_option("_lp_discount_{$discount_category}_" . self::VAR_1 . "_level_$loyalty_level", 0);
		} elseif (strpos($product_attribute, self::VAR_2) !== false) {
			$discount = (float) get_option("_lp_discount_{$discount_category}_" . self::VAR_2 . "_level_$loyalty_level", 0);
		}

		return max(0, $price - $discount);
	}


	public function apply_discount_to_variation($price, $product, $variation_id)
	{
		$user_id = get_current_user_id();
		$loyalty_level = $this->get_loyalty_level($user_id);

		if (!empty($variation_id)) {
			$variation = wc_get_product($variation_id);
			if ($variation instanceof WC_Product_Variation) {
				$variation_price = $variation->get_regular_price();
				return $this->get_discounted_price($variation_price, $variation, $loyalty_level);
			}
		}

		if (!$product || !$product->is_type('variable')) {
			return $price;
		}

		$variation_ids = $product->get_children();

		foreach ($variation_ids as $id) {
			$variation = wc_get_product($id);
			if ($variation instanceof WC_Product_Variation) {
				$variation_price = $variation->get_regular_price();
				$discounted_price = $this->get_discounted_price($variation_price, $variation, $loyalty_level);

				if ($discounted_price < $variation_price) {
					$variation->set_regular_price($discounted_price);
					$variation->set_sale_price($discounted_price);
					$variation->save();
				}
			}
		}

		return $price;
	}

	public function update_variation_prices_hash($price_hash, $product, $display)
	{
		$user_id = get_current_user_id();
		$loyalty_level = $this->get_loyalty_level($user_id);
		$price_hash['loyalty_level'] = $loyalty_level;
		return $price_hash;
	}

	private function get_loyalty_level($user_id)
	{
		return (int) get_user_meta($user_id, '_loyalty_level', true) ?: 0;
	}

	public function change_price($price, $product)
	{
		if ($product->is_type('variable')) {
			return $this->get_variation_price($product);
		}

		$user_id = get_current_user_id();
		$loyalty_level = $this->get_loyalty_level($user_id);

		return $this->get_discounted_price($price, $product, $loyalty_level);
	}

	public function change_price_html($price_html, $product)
	{
		$discounted_price = $this->get_variation_price($product);
		return is_numeric($discounted_price) ? wc_price($discounted_price) : $price_html;
	}

	public function get_variation_price($product)
	{
		if (!$product->is_type('variable')) {
			return $product->get_price();
		}

		$variations = $product->get_children();
		foreach ($variations as $variation_id) {
			$variation = wc_get_product($variation_id);

			$attribute = $variation->get_attribute(self::ATTRIBUTE);
			$user_id = get_current_user_id();
			$level = $this->get_loyalty_level($user_id) ?: 1;

			foreach (self::DISCOUNT_CATEGORIES as $category) {
				if (in_array($category, $this->prod_categories($product->get_id()))) {

					$discount = 0;

					if ($attribute == self::VAR_1) {
						$discount = get_option("_lp_discount_{$category}_" . self::VAR_1 . "_level_$level", 0);
					} elseif ($attribute == self::VAR_2) {
						$discount = get_option("_lp_discount_{$category}_" . self::VAR_2 . "_level_$level", 0);
					}


					//debugging
					// dd('discount categories: ', false);
					// dd(self::DISCOUNT_CATEGORIES, false);
					// //output Array
					// // (
					// //     [0] => novinki
					// //     [1] => espresso
					// // )
					// dd('prod categories: ', false);
					// dd($this->prod_categories($product->get_id()), false);
					// //output Array
					// // (
					// //     [0] => filtr
					// //     [1] => espresso
					// // )
					// dd('prod attr:' . $attribute, false);//1kg
					// dd('price: ' . $variation->get_price(), false);//output 1000
					// dd('discount: ' . $discount, false);//output 30

					return $variation->get_price() - $discount;
				}
			}
		}

		return $product->get_price();
	}

	function modify_variable_price_html($price_html, $product)
	{
		// Ensure the product is a variable product
		if ($product->is_type('variable')) {
			$variations = $product->get_children();
			foreach ($variations as $variation_id) {
				$variation = wc_get_product($variation_id);

				$attribute = $variation->get_attribute(self::ATTRIBUTE);
				$user_id = get_current_user_id();
				$level = $this->get_loyalty_level($user_id) ?: 1;

				foreach (self::DISCOUNT_CATEGORIES as $category) {
					if (in_array($category, $this->prod_categories($product->get_id()))) {


						$discount = 0;

						if ($attribute == self::VAR_1) {
							$discount = get_option("_lp_discount_{$category}_" . self::VAR_1 . "_level_$level", 0);
						} elseif ($attribute == self::VAR_2) {
							$discount = get_option("_lp_discount_{$category}_" . self::VAR_2 . "_level_$level", 0);
						}

						$price_html = $variation->get_price() - $discount;
						return $price_html;
					}
				}
				return $price_html;
			}

		}

		return $price_html;
	}

}



new LoyaltyProgramService();
