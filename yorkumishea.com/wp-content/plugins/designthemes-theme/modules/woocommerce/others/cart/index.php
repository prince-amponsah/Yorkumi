<?php

/**
 * WooCommerce - Cart Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Others_Cart' ) ) {

    class Dt_Shop_Others_Cart {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();


            // CSS
                add_filter( 'savon_woo_css', array( $this, 'woo_css'), 10, 1 );

            // JS
                add_filter( 'savon_woo_js', array( $this, 'woo_js'), 10, 1 );

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/others/cart/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/others/cart/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                if( function_exists( 'dt_theme' ) ) {
                    // Customizer
                        include_once $this->module_dir_path(). 'customizer/index.php';

                }

                // Includes
                    include_once $this->module_dir_path(). 'includes/index.php';

            }


        /*
        Load Listings
        */
            function woo_load_listing( $product_style_template, $product_style_custom_template ) {

                wc_set_loop_prop('non_archive_listing', 1);

                $type_options = array ();

                if( $product_style_template == 'predefined' ) {
                    $type_class_instance = 'dt_woo_listing_type_'.$product_style_custom_template; // Type Class Instance
                } else if( $product_style_template == 'custom' ) {
                    $type_class_instance = 'dt_woo_listing_type_custom'; // Type Class Instance
                }

                if ( function_exists( $type_class_instance ) ) {

                    if( $product_style_template == 'custom' ) {
                        $type_class_instance()->custom_template = $product_style_custom_template;
                    }

                    $type_options = $type_class_instance()->set_type_options();

                    if( is_array ( $type_options ) && !empty ( $type_options ) ) {
                        foreach ( $type_options as $type_option_key => $type_option ) {

                            $type_option_key = str_replace( 'product-', '', $type_option_key);
                            $type_option_key = str_replace( '-', '_', $type_option_key);
                            $option_class_instance = 'dt_woo_listing_option_'.$type_option_key;  // Option Class Instance

                            if ( function_exists( $option_class_instance ) ) {

                                $option_class_instance()->option_default_value = $type_option;
                                $option_class_instance()->render_frontend();
                                $option_class_instance()->woo_listings_loop_prop();

                            }

                        }
                    }

                    $type_class_instance()->render_frontend();
                    $type_class_instance()->for_non_archive_listing();

                }

            }


        /*
        CSS
        */
            function woo_css( $css ) {

                $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                if( file_exists ( $css_file_path ) ) {

                    ob_start();
                    include( $css_file_path );
                    $css .= "\n\n".ob_get_clean();

                }

                return $css;

            }

        /*
        JS
        */
            function woo_js( $js ) {

                $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                if( file_exists ( $js_file_path ) ) {

                    ob_start();
                    include( $js_file_path );
                    $js .= "\n\n".ob_get_clean();

                }

                return $js;

            }

    }

}

if( !function_exists('dtshop_others_cart') ) {
	function dtshop_others_cart() {
        $reflection = new ReflectionClass('Dt_Shop_Others_Cart');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Shop_Others_Cart::instance();