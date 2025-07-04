<?php

/**
 * Listings - Shop
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Listing_Shop' ) ) {

    class Dt_Shop_Listing_Shop {

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

            /* After Shop Loop */
                add_action( 'savon_woo_after_products_loop', array( $this, 'savon_woo_after_products_loop' ), 10 );

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once DTSHOP_PLUGIN_PATH . 'modules/shop/customizer/index.php';

            }

        /*
        After Shop Loop
        */
            function savon_woo_after_products_loop() {

                $shop_page_bottom_hook = dt_customizer_settings( 'dt-woo-shop-page-bottom-hook' );
                $shop_page_bottom_hook = (isset($shop_page_bottom_hook) && !empty($shop_page_bottom_hook)) ? $shop_page_bottom_hook : false;

                if($shop_page_bottom_hook) {
                    echo do_shortcode($shop_page_bottom_hook);
                }

            }

    }

}


if( !function_exists('dt_shop_listing_shop') ) {
	function dt_shop_listing_shop() {
		return Dt_Shop_Listing_Shop::instance();
	}
}

dt_shop_listing_shop();