<?php

//namespace SilkyDrum\WooCommerce;

// dd('Service used');

class LoyaltyProgramService
{
    public function __construct()
    {
        // Apply loyalty discount during cart calculations
        add_action('woocommerce_cart_calculate_fees', [$this, 'apply_loyalty_discount']);

        // Update loyalty level after order is completed
        add_action('woocommerce_order_status_completed', [$this, 'update_loyalty_level'], 10, 1);

        // Add loyalty info to emails
        add_filter('woocommerce_email_order_meta', [$this, 'add_loyalty_info_to_email'], 10, 3);
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
        $discount = $this->calculate_discount($loyalty_level, $cart);

        if ($discount > 0) {
            $cart->add_fee(__('Loyalty Program Discount', 'lp-textdomain'), -$discount);
        }
    }

    public function update_loyalty_level($order_id)
    {
        $order = wc_get_order($order_id);
        $user_id = $order->get_user_id();

        if ($user_id) {
            $new_level = $this->determine_loyalty_level($user_id);
            update_user_meta($user_id, '_loyalty_level', $new_level);
        }
    }

    public function add_loyalty_info_to_email($order, $sent_to_admin, $plain_text)
    {
        $user_id = $order->get_user_id();
        if ($user_id) {
            $level = get_user_meta($user_id, '_loyalty_level', true);
            echo '<p>' . sprintf(__('Your current loyalty level: %s', 'lp-textdomain'), $level) . '</p>';
        }
    }

    private function get_loyalty_level($user_id)
    {
        $level = get_user_meta($user_id, '_loyalty_level', true);
        return $level ? (int)$level : 0;
    }

    private function calculate_discount($level, $cart)
    {
        $discount = 0;
        $discount_structure = $this->get_discount_structure();

        foreach ($cart->get_cart() as $cart_item) {
            $product = $cart_item['data'];
            $quantity = $cart_item['quantity'];

            if (isset($discount_structure[$level])) {
                $discounts = $discount_structure[$level];

                // Match products by SKU or logic
                if ($product->get_sku() === 'CAPPUCCINO_200G' && isset($discounts['espresso']['200g'])) {
                    $discount += $discounts['espresso']['200g'] * $quantity;
                } elseif ($product->get_sku() === 'CAPPUCCINO_1KG' && isset($discounts['espresso']['1kg'])) {
                    $discount += $discounts['espresso']['1kg'] * $quantity;
                }
            }
        }

        return $discount;
    }

    public function determine_loyalty_level($user_id)
    {
        // Check for manual Level 3 assignment
        $is_manual_level_3 = get_user_meta($user_id, '_loyalty_level_3', true);
        if ($is_manual_level_3 === '1') {
            return 3;
        }

        $orders = wc_get_orders(['customer_id' => $user_id, 'status' => 'completed']);
        $order_count = count($orders);

        if ($order_count === 0) {
            return 0; // No orders
        }

        // Calculate months since first order
        $first_order_date = strtotime((string)end($orders)->get_date_created());
        $months_since_first_order = (time() - $first_order_date) / (30 * 24 * 60 * 60);

        // Define loyalty levels
        $loyalty_levels = [
            3 => ['orders' => 3, 'months' => 0],
            2 => ['orders' => 2, 'months' => 0],
            1 => ['orders' => 1, 'months' => 0],
        ];

        foreach ($loyalty_levels as $level => $requirements) {
            if ($order_count >= $requirements['orders'] && $months_since_first_order >= $requirements['months']) {
                return $level;
            }
        }

        return 0;
    }

    public function get_loyalty_data($user_id)
    {
        // $loyalty_level = $this->get_loyalty_level($user_id);
        $loyalty_level = $this->determine_loyalty_level($user_id);
        $next_level = $loyalty_level + 1;
        $discounts = $this->get_discount_structure();

        $progress = [
            'months_left' => 0,  // Example for now
            'orders_needed' => 1,
        ];

        return [
            'loyalty_level' => $loyalty_level,
            'discounts' => $discounts[$loyalty_level] ?? [],
            'next_level' => $next_level,
            'progress' => $progress,
        ];
    }

    private function get_discount_structure()
    {
        return [
            1 => [
                'espresso' => ['200g' => 6, '1kg' => 30],
                'filter' => ['200g' => 20, '1kg' => 100],
            ],
            2 => [
                'espresso' => ['200g' => 10, '1kg' => 40],
                'filter' => ['200g' => 30, '1kg' => 150],
            ],
        ];
    }
}


// $lp_service = new LoyaltyProgramService();

// $user_id = get_current_user_id();

// dd($lp_service->get_loyalty_data( $user_id ) );





