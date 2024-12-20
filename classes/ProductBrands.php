<?php


class ProductBrands
{

    public function __construct()
    {
        // add_action('show_user_profile', [$this, 'add_loyalty_level_field'], 5);
        add_action('woocommerce_after_shop_loop_item_title', [$this, 'display_brand_on_shop_page'], 15);
        add_action('init', [$this, 'custom_woocommerce_brand_taxonomy']);
        add_action('woocommerce_single_product_summary', [$this, 'display_brand_on_single_product_page'], 20);
        add_action('wp_head', [$this, 'custom_brand_styles']);

    }


    function custom_woocommerce_brand_taxonomy()
    {
        $labels = array(
            'name' => _x('Brands', 'taxonomy general name', 'textdomain'),
            'singular_name' => _x('Brand', 'taxonomy singular name', 'textdomain'),
            'search_items' => __('Search Brands', 'textdomain'),
            'all_items' => __('All Brands', 'textdomain'),
            'parent_item' => __('Parent Brand', 'textdomain'),
            'parent_item_colon' => __('Parent Brand:', 'textdomain'),
            'edit_item' => __('Edit Brand', 'textdomain'),
            'update_item' => __('Update Brand', 'textdomain'),
            'add_new_item' => __('Add New Brand', 'textdomain'),
            'new_item_name' => __('New Brand Name', 'textdomain'),
            'menu_name' => __('Brands', 'textdomain'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'brand'),
        );

        register_taxonomy('brand', 'product', $args);
    }


    // Display Brand on Single Product Page
    function display_brand_on_single_product_page()
    {
        global $product;

        $terms = get_the_terms($product->get_id(), 'brand');
        if ($terms && !is_wp_error($terms)) {
            $brand_names = wp_list_pluck($terms, 'name');
            echo '<p class="product-brand"><strong>' . __('Brand:', 'textdomain') . '</strong> ' . implode(', ', $brand_names) . '</p>';
        }
    }


    // Display Brand Below Price on Shop Page
    function display_brand_on_shop_page()
    {
        global $product;

        $terms = get_the_terms($product->get_id(), 'brand');
        if ($terms && !is_wp_error($terms)) {
            $brand_names = wp_list_pluck($terms, 'name');
            echo '<p class="product-brand-shop"><strong>' . __('Brand:', 'textdomain') . '</strong> ' . implode(', ', $brand_names) . '</p>';
        }
    }


    // Add Styling for Brands (Optional)
    function custom_brand_styles()
    {
        ?>
        <style>
            .product-brand,
            .product-brand-shop {
                font-size: 14px;
                color: #555;
            }

            .product-brand strong,
            .product-brand-shop strong {
                font-weight: bold;
            }
        </style>
        <?php
    }

}

