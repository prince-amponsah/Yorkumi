<?php

/**
 * WooCommerce - Custom Product Type Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Others_Custom_Product_Type' ) ) {

    class Dt_Shop_Others_Custom_Product_Type {

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
                    return SAVON_MODULE_DIR . '/woocommerce/others/custom-product-type/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/others/custom-product-type/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                if( function_exists( 'dt_theme' ) ) {

                    // Metabox
                }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

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

if( !function_exists('dtshop_others_custom_product_type') ) {
	function dtshop_others_custom_product_type() {
        $reflection = new ReflectionClass('Dt_Shop_Others_Custom_Product_Type');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Shop_Others_Custom_Product_Type::instance();