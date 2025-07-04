<?php

/**
 * Listings - Tag
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Listing_Tag' ) ) {

    class Dt_Theme_Listing_Tag {

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
                    include_once DT_THEME_DIR_PATH.'modules/woocommerce/tag/customizer/index.php';

            }

        /*
        Loop Shop Per Page
        */
            function woo_loop_shop_per_page( $count ) {

                if( is_product_tag() ) {
                    $count = dt_customizer_settings('dt-woo-tag-page-product-per-page' );
                }

                return $count;

            }

    }

}


if( !function_exists('dt_theme_listing_tag') ) {
	function dt_theme_listing_tag() {
		return Dt_Theme_Listing_Tag::instance();
	}
}

dt_theme_listing_tag();