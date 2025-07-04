<?php

/**
 * Listings - Shop
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Listing_Shop' ) ) {

    class Dt_Theme_Listing_Shop {

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

            /* Loop Shop Per Page */
                add_filter( 'loop_shop_per_page', array ( $this, 'woo_loop_shop_per_page' ) );

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once DT_THEME_DIR_PATH.'modules/woocommerce/shop/customizer/index.php';

            }

        /*
        Loop Shop Per Page
        */
            function woo_loop_shop_per_page( $count ) {

                if( is_shop() ) {
                    $count = dt_customizer_settings('dt-woo-shop-page-product-per-page' );
                }

                return $count;

            }

    }

}


if( !function_exists('dt_theme_listing_shop') ) {
	function dt_theme_listing_shop() {
		return Dt_Theme_Listing_Shop::instance();
	}
}

dt_theme_listing_shop();