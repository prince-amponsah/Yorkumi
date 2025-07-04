<?php

/**
 * Customizer - Product Single Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single' ) ) {

    class Dt_Shop_Customizer_Single {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Sections
                $this->load_sections();

        }

        /*
        Load Sections
        */

            function load_sections() {

                foreach( glob( DTSHOP_PLUGIN_MODULE_PATH. 'single/customizer/sections/*.php' ) as $module ) {
                    include_once $module;
                }

            }


    }

}


if( !function_exists('dt_shop_customizer_single') ) {
	function dt_shop_customizer_single() {
		return Dt_Shop_Customizer_Single::instance();
	}
}

dt_shop_customizer_single();