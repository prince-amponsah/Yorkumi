<?php

/**
 * WooCommerce - Single - Module - Upsell & Related
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Single_Module_Upsell_Related' ) ) {

    class Dt_Shop_Single_Module_Upsell_Related {

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

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/single/modules/upsell-and-related/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/single/modules/upsell-and-related/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'dt_theme' ) ) {

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                        // Metabox
                            include_once $this->module_dir_path() . 'metabox/index.php';

                    }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

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

    }

}

if( !function_exists('dt_shop_single_module_upsell_related') ) {
	function dt_shop_single_module_upsell_related() {
		return Dt_Shop_Single_Module_Upsell_Related::instance();
	}
}

dt_shop_single_module_upsell_related();