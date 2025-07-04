<?php

/**
 * Listings - Category
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Listing_Category' ) ) {

    class Dt_Shop_Listing_Category {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

            /* After Products Loop */
                add_action( 'savon_woo_after_products_loop', array( $this, 'savon_woo_after_products_loop' ), 10 );

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once DTSHOP_PLUGIN_PATH . 'modules/category/customizer/index.php';

            }

        /*
        After Products Loop
        */
            function savon_woo_after_products_loop() {

                $category_page_bottom_hook = dt_customizer_settings( 'dt-woo-category-page-bottom-hook' );
                $category_page_bottom_hook = (isset($category_page_bottom_hook) && !empty($category_page_bottom_hook)) ? $category_page_bottom_hook : false;

                if($category_page_bottom_hook) {
                    echo do_shortcode($category_page_bottom_hook);
                }

            }

    }

}


if( !function_exists('dt_shop_listing_category') ) {
	function dt_shop_listing_category() {
		return Dt_Shop_Listing_Category::instance();
	}
}

dt_shop_listing_category();