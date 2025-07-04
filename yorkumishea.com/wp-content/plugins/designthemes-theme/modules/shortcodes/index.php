<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesShortcodes' ) ) {
    class DesignThemesShortcodes {

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
            include_once DT_THEME_DIR_PATH.'modules/shortcodes/elementor/index.php';
        }
    }
}

DesignThemesShortcodes::instance();