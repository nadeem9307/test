<?php

/*
  Plugin Name: Woo Gift
  Plugin URI: no
  description: This plugin create a setting under woocommerce setting section.
  Version: 1.2
  Author: Mr. Mohd Nadeem
  Author URI: no
  License: developer
 */
/**
 * Create the section beneath the products tab
 * */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Check if WooCommerce is activated
 */
if (!function_exists('is_woocommerce_activated')) {

    function is_woocommerce_activated() {
        if (class_exists('woocommerce')) {
            return true;
        } else {
         add_action('admin_notices', 'woogift_admin_notice__error');
            
        }
    }

}
if (!class_exists('WC_Settings_WooGift')) :

    function woogift_add_settings() {

        /**
         * Settings class
         *
         * @since 1.0.0
         */
        class WC_Settings_WooGift extends WC_Settings_Page {

            /**
             * Setup settings class
             *
             * @since  1.0
             */
            public function __construct() {

                $this->id = 'woogift';
                $this->label = __('Woo Gift', 'webcom_text');

                add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_page'), 20);
                add_action('woocommerce_settings_' . $this->id, array($this, 'output'));
                add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'));
                add_action('woocommerce_sections_' . $this->id, array($this, 'output_sections'));
            }

            /**
             * Get settings array
             *
             * @since 1.0.0
             * @param string $current_section Optional. Defaults to empty string.
             * @return array Array of settings
             */
            public function get_settings($current_section = '') {

                /**
                 *
                 * @since 1.0.0
                 * @param array $settings Array of the plugin settings
                 * 
                 */
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_type',
                            'field' => 'slug',
                            'terms' => 'simple',
                        ),
                    ),
                );
                $products = get_posts($args);
                $option = array();
                foreach ($products as $product) {
                    $price = get_post_meta($product->ID, '_sale_price', true);
                    if ($price == '49') {
                        $option[$product->ID] = $product->post_title;
                    }
                }
                $settings = apply_filters('woogift_section1_settings', array(
                    array(
                        'name' => __('Chose Product for add as a Gift ', 'webcom_text'),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'woogift_important_options',
                    ),
                    array(
                        'type' => 'select',
                        'id' => 'woogift_product_id',
                        'name' => __('Select a product for add as gift', 'webcom_text'),
                        'options' => $option,
                        'class' => 'wc-enhanced-select',
                        'desc_tip' => __('Be honest!', 'webcom_text'),
                    ),
                    array(
                        'type' => 'sectionend',
                        'id' => 'woogift_important_options'
                    ),
                ));
                /**
                 * Filter WooGift Settings
                 *
                 * @since 1.0.0
                 * @param array $settings Array of the plugin settings
                 */
                return apply_filters('woocommerce_get_settings_' . $this->id, $settings, $current_section);
            }

            /**
             * Output the settings
             *
             * @since 1.0
             */
            public function output() {

                global $current_section;

                $settings = $this->get_settings($current_section);

                WC_Admin_Settings::output_fields($settings);
            }

            /**
             * Save settings
             *
             * @since 1.0
             */
            public function save() {

                global $current_section;

                $settings = $this->get_settings($current_section);
                WC_Admin_Settings::save_fields($settings);
            }

        }

        return new WC_Settings_WooGift();
    }

    add_filter('woocommerce_get_settings_pages', 'woogift_add_settings', 15);
endif;
/*
 * Add items to cart on loading checkout page.
 */
add_action('template_redirect', 'woogift_add_product_to_cart');

function woogift_add_product_to_cart() {
    if (!is_admin()) {
        global $woocommerce;
        $product_id = get_option('woogift_product_id'); // get gift product id
        $found = false;
        $cart_total = 100; //replace with your cart total needed to add above item
        if ($woocommerce->cart->total > $cart_total) {
            //check if product already in cart
            if (sizeof($woocommerce->cart->get_cart()) > 0) {
                foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
                    $_product = $values['data'];
                    if ($_product->get_id() == $product_id)
                        $found = true;
                }
                // if product not found, add it
                if (!$found)
                    $woocommerce->cart->add_to_cart($product_id);
            } else {
                // if no products in cart, add it
                $woocommerce->cart->add_to_cart(85);
            }
        }
    }
}
/**
 * Display an error message notice in the admin if WP Job Manager is not active
 */
function woogift_admin_notice__error() {

    $class = 'notice notice-error';
    $message = __('An error has occurred. Woocommerce must be installed in order to use this plugin', 'webcom-text');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}
