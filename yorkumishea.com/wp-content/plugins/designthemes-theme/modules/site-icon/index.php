<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSiteIcon' ) ) {
    class DesignThemesSiteIcon {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/site-icon/customizer/index.php';
        }
    }
}

DesignThemesSiteIcon::instance();