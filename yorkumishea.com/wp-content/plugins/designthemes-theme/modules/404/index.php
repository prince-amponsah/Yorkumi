<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemes404' ) ) {
    class DesignThemes404 {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/404/customizer/index.php';
            include_once DT_THEME_DIR_PATH.'modules/404/template-loader.php';
        }

        function frontend() {
            add_action( 'savon_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );            
        }

        function enqueue_css_assets() {
            if( is_404() ) {
                wp_enqueue_style( 'savon-dtplugin-notfound', DT_THEME_DIR_URL . 'modules/404/assets/css/404.css', false, DT_THEME_VERSION, 'all');            
            }
        }
    }
}

DesignThemes404::instance();