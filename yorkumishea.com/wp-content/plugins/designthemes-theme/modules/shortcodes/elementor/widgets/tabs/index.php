<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesTabsWidget' ) ) {
    class DesignThemesTabsWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );
        }

        function register_widgets( $widgets_manager ) {
            require DT_THEME_DIR_PATH. 'modules/shortcodes/elementor/widgets/tabs/class-widget-tabs.php';
            $widgets_manager->register( new \Elementor_Tabs() );
        }

        function register_widget_styles() {
            wp_register_style( 'dt-tabs',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/tabs/style.css', array(), DT_THEME_VERSION );
        }

        function register_widget_scripts() {
            wp_register_script( 'dt-flowplayer-tabs',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/assets/js/jquery.tabs.min.js', array(), DT_THEME_VERSION, true );
            wp_register_script( 'dt-tabs',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/tabs/script.js', array(), DT_THEME_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'dt-tabs' );

            wp_enqueue_script( 'dt-flowplayer-tabs' );
            wp_enqueue_script( 'dt-tabs' );
        }
    }
}

DesignThemesTabsWidget::instance();