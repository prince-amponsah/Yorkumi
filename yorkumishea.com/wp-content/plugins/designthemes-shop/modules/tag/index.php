<?php

/**
 * Listings - Tag
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Listing_Tag' ) ) {

    class Dt_Shop_Listing_Tag {

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
                    include_once DTSHOP_PLUGIN_PATH . 'modules/tag/customizer/index.php';

            }

        /*
        After Products Loop
        */
            function savon_woo_after_products_loop() {

                $tag_page_bottom_hook = dt_customizer_settings( 'dt-woo-tag-page-bottom-hook' );
                $tag_page_bottom_hook = (isset($tag_page_bottom_hook) && !empty($tag_page_bottom_hook)) ? $tag_page_bottom_hook : false;

                if($tag_page_bottom_hook) {
                    echo do_shortcode($tag_page_bottom_hook);
                }

            }

    }

}


if( !function_exists('dt_shop_listing_tag') ) {
	function dt_shop_listing_tag() {
		return Dt_Shop_Listing_Tag::instance();
	}
}

dt_shop_listing_tag();