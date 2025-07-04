<?php

/**
 * WooCommerce - Single Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Single_core' ) ) {

    class Dt_Woo_Single_core {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Load Custom Modules
                $this->load_custom_modules();

            // Enqueue CSS
                add_action( 'savon_after_woo_css', array ( $this, 'after_woo_css' ), 10 );

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/single/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/single/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Load Default Values
        */
            function woo_default_settings() {

                $this->settings = array (

                    'product_default_template'              => 'woo-default',
                    'product_sale_countdown_timer'          => '',
                    'product_enable_size_guide'             => '',
                    'product_enable_breadcrumb'             => 1,
                    'product_addtocart_sticky'              => '',
                    'product_show_360_viewer'               => 0,
                    'product_enable_ajax_addtocart'         => 1,

                    'product_additional_info'               => 0,
                    'product_ai_delivery_period'            => '',
                    'product_ai_visitors_min_value'         => '',
                    'product_ai_visitors_max_value'         => '',

                    'product_buy_now'                       => 0,

                    'product_upsell_display'                => 1,
                    'product_upsell_title'                  => '',
                    'product_upsell_column'                 => 4,
                    'product_upsell_limit'                  => 2,
                    'product_upsell_style_template'         => 'predefined',
                    'product_upsell_style_custom_template'  => 'default',

                    'product_related_display'               => 1,
                    'product_related_title'                 => '',
                    'product_related_column'                => 4,
                    'product_related_limit'                 => 2,
                    'product_related_style_template'        => 'predefined',
                    'product_related_style_custom_template' => 'default',

                    'product_show_sharer_facebook'          => 1,
                    'product_show_sharer_delicious'         => '',
                    'product_show_sharer_digg'              => '',
                    'product_show_sharer_stumbleupon'       => '',
                    'product_show_sharer_twitter'           => 1,
                    'product_show_sharer_googleplus'        => 1,
                    'product_show_sharer_linkedin'          => 1,
                    'product_show_sharer_pinterest'         => 1

                );

                $this->settings = apply_filters( 'savon_woo_single_page_settings', $this->settings );

                return $this->settings;

            }

        /*
        Load Modules
        */
            function load_modules() {

                include_once SAVON_MODULE_DIR. '/woocommerce/single/includes/template.php';
                include_once SAVON_MODULE_DIR. '/woocommerce/single/includes/labels.php';

            }

        /*
        Load Custom Modules
        */
            function load_custom_modules() {

                $custom_modules = array (
                    'custom-template'         => 'single/modules/custom-template/index',
                    'upsell-and-related'      => 'single/modules/upsell-and-related/index',
                    'social-share-and-follow' => 'single/modules/social-share-and-follow/index',
                    'additional-tabs'         => 'single/modules/additional-tabs/index',
                    'ajax-cart'               => 'single/modules/ajax-cart/index',
                    'sticky-cart'             => 'single/modules/sticky-cart/index',
                    'count-down-timer'        => 'single/modules/count-down-timer/index',
                    '360-viewer'              => 'single/modules/360-viewer/index',
                    'additional-info'         => 'single/modules/additional-info/index',
                    'buy-now'                 => 'single/modules/buy-now/index'
                );

                if( is_array( $custom_modules ) && !empty( $custom_modules ) ) {
                    foreach( $custom_modules as $custom_module ) {

                        if( $file_path = savon_woo_locate_file( $custom_module ) ) {
                            include_once $file_path;
                        }

                    }
                }

            }

        /*
        Enqueue CSS
        */
            function after_woo_css() {

                if( is_product() ) {
                    wp_enqueue_style('savon-woo-single-common', $this->module_dir_url() . 'assets/css/common.css');
                }

            }

    }

}


if( !function_exists('dt_woo_single_core') ) {
	function dt_woo_single_core() {
        $reflection = new ReflectionClass('Dt_Woo_Single_core');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Woo_Single_core::instance();