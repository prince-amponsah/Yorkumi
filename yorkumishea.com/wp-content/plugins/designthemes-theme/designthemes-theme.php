<?php
/**
 * Plugin Name:	DesignThemes Theme
 * Description: Plugin that adds core functionality for the DesignThemes WordPress themes.
 * Version: 1.6
 * Author: the DesignThemes team
 * Author URI: http://themeforest.net/user/designthemes
 * Text Domain: designthemes-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesTheme' ) ) {
    class DesignThemesTheme {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            /**
             * Before Hook
             */
            do_action( 'dt_before_theme_plugin_load' );

                add_action( 'plugins_loaded', array( $this, 'i18n' ) );
                add_action( 'plugins_loaded', array( $this, 'check_requirements' ) );

                $this->define_constants();
                $this->load_modules();
                $this->frontend();   			

            /**
             * After Hook
             */
            do_action( 'dt_after_theme_plugin_load' );
        }

        function i18n() {
            load_plugin_textdomain( 'designthemes-theme', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function check_requirements() {            
            if( !defined('DT_FW_VERSION') ) {
                add_action( 'admin_notices', array( $this, 'missing_core_framework' ) );
                return;
            }
        }

        function missing_core_framework() {

    		if ( function_exists( 'deactivate_plugins' ) ) {
                deactivate_plugins( plugin_basename( __FILE__ ) );
            }

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }

            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor */
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'designthemes-theme' ),
                '<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-theme' ) . '</strong>',
                '<strong>' . esc_html__( 'DesignThemes Framework Plugin', 'designthemes-theme' ) . '</strong>'			
            );
    
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );            
    
        }

        function define_constants() {
            define( 'DT_THEME_VERSION', '1.0' );
            define( 'DT_THEME_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'DT_THEME_DIR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
            define( 'DT_CUSTOMISER_VAL', 'dt-customiser-option');
        }

        function load_modules() {

            include_once DT_THEME_DIR_PATH . '/functions.php';

            /**
             * Before Hook
             */
            do_action( 'dt_before_theme_load_modules' );

            foreach( glob( DT_THEME_DIR_PATH. 'modules/*/index.php'  ) as $module ) {
                include_once $module;
            }

            /**
             * After Hook
             */
            do_action( 'dt_after_theme_load_modules' );

        }

        function frontend() {
            add_filter( 'body_class', array( $this, 'add_body_classes' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        }

        function enqueue_assets() {

            /**
             * Add Common css & javascript
             */

            wp_enqueue_style( 'savon-dtplugin-common', DT_THEME_DIR_URL . 'assets/css/common.css', false, DT_THEME_VERSION, 'all');            
            wp_enqueue_style( 'savon-dtplugin-elementor', DT_THEME_DIR_URL . 'assets/css/dt-elementor.css', false, DT_THEME_VERSION, 'all');            
            wp_enqueue_style( 'savon-dtplugin-widget', DT_THEME_DIR_URL . 'assets/css/dt-widget.css', false, DT_THEME_VERSION, 'all');

            do_action( 'dt_after_main_frontend_load' );
        }

        function add_body_classes( $classes ) {
            $classes[] = 'designthemes-theme-'.DT_THEME_VERSION;
            return $classes;
        }
    }
}

if( !function_exists( 'dt_theme' ) ) {
    function dt_theme() {
        return DesignThemesTheme::instance();
    }   
}

dt_theme();

register_activation_hook( __FILE__, 'dt_theme_activation_hook' );
function dt_theme_activation_hook() {
    update_option( constant( 'DT_CUSTOMISER_VAL' ), apply_filters( 'dt_theme_customizer_default', array() ) );    
}