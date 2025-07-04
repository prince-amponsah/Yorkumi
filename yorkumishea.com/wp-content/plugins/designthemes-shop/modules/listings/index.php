<?php

/**
 * Listing
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Listing' ) ) {

    class Dt_Shop_Listing {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Update Options Location Path Array */
                add_filter( 'savon_woo_option_locations', array( $this, 'option_locations_update'), 10, 1 );

            /* Update Types Location Path Array */
                add_filter( 'savon_woo_type_locations', array( $this, 'type_locations_update'), 10, 1 );

        }

        /*
        Options Location Path Update
        */
            function option_locations_update( $paths ) {

                array_push( $paths, DTSHOP_PLUGIN_MODULE_PATH. 'listings/options/*/index.php' );

                return $paths;

            }

        /*
        Types Location Path Update
        */
            function type_locations_update( $paths ) {

                array_push( $paths, DTSHOP_PLUGIN_MODULE_PATH. 'listings/types/*/index.php' );

                return $paths;

            }

    }

}

if( !function_exists('dt_shop_listing') ) {
	function dt_shop_listing() {
		return Dt_Shop_Listing::instance();
	}
}

dt_shop_listing();