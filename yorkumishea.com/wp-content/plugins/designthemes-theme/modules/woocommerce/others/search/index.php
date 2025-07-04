<?php

/**
 * WooCommerce - Search Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Others_Search' ) ) {

    class Dt_Shop_Others_Search {

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

            // Page Template
                add_filter ( 'theme_page_templates', array ( $this, 'module_add_new_page_template' ) );

            // Include Template
                add_filter ( 'template_include', array ( $this, 'modules_template_include' ) );

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/others/search/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/others/search/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                if( function_exists( 'dt_theme' ) ) {
                    include_once $this->module_dir_path(). 'elementor/index.php';
                }

            }

        /**
         * Page Template
         */
            function module_add_new_page_template( $templates ) {

                $templates = array_merge (
                    $templates,
                    array (
                        'tpl-product-search-listing.php' => esc_html__('Product Search Listing Template', 'designthemes-theme')
                    )
                );

                return $templates;

            }

        /**
         * Include Template
         */
            function modules_template_include( $template ) {

                if( is_singular('page') ) {

                    global $post;
                    $id = $post->ID;
                    $file = get_post_meta( $post->ID, '_wp_page_template', true );

                    if( 'tpl-product-search-listing.php' == $file ) {
                        if( ! file_exists( get_stylesheet_directory() . '/tpl-product-search-listing.php' ) ) {
                            $template = $this->module_dir_path() . 'templates/tpl-product-search-listing.php';
                        }
                    }

                }

                return $template;

            }

    }

}

if( !function_exists('dtshop_others_search') ) {
	function dtshop_others_search() {
        $reflection = new ReflectionClass('Dt_Shop_Others_Search');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Shop_Others_Search::instance();