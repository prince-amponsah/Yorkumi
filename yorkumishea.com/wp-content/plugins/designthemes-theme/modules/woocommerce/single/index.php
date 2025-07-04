<?php

/**
 * WooCommerce - Single Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Single' ) ) {

    class Dt_Theme_Single {

        private static $_instance = null;

        private $settings;

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
        Load Modules
        */
        function load_modules() {

            // Customizer
                include_once DT_THEME_DIR_PATH . 'modules/woocommerce/single/customizer/index.php';

            // Metabox
                include_once DT_THEME_DIR_PATH . 'modules/woocommerce/single/metabox/index.php';

        }

    }

}

if( !function_exists('dt_theme_single') ) {
	function dt_theme_single() {
		return Dt_Theme_Single::instance();
	}
}

dt_theme_single();