<?php
/**
 * Plugin Name:	DesignThemes Framework
 * Description: Base framework plugin for the DesignThemes WordPress themes.
 * Version: 1.6
 * Author: the DesignThemes team
 * Author URI: http://themeforest.net/user/designthemes
 * Text Domain: designthemes-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}

if( !class_exists( 'DesignThemesFramework' ) ) {
    class DesignThemesFramework {

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
            do_action( 'dt_before_fw_plugin_load' );

                add_action( 'plugins_loaded', array( $this, 'i18n' ) );
                $this->define_constants();
                $this->load_helper();
                $this->load_customizer();
                $this->load_codestar();
                $this->load_widget_area_generator();
                $this->load_post_types();
    			add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_filter ( 'cs_framework_settings', array ( $this, 'dt_cs_framework_settings' ) );


            /**
             * After Hook
             */
            do_action( 'dt_after_fw_plugin_load' );
        }

        function dt_cs_framework_settings($settings){

	        $settings           = array(
	          'menu_title'      => esc_html__('DT Settings', 'designthemes-framework'),
	          'menu_type'       => 'menu',
	          'menu_slug'       => 'dt-framework-settings',
	          'ajax_save'       => true,
	          'show_reset_all'  => false,
	          'framework_title' => esc_html__('Designthemes', 'designthemes-framework'),
	        );

            return apply_filters( 'dt_cs_framework_settings', $settings );
        }

        function define_constants() {

            define( 'DT_FW_VERSION', '1.0' );
            define( 'DT_FW_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'DT_FW_DIR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
        }

        function load_helper() {
            require_once DT_FW_DIR_PATH . 'functions.php';
        }

        function load_customizer() {
            require_once DT_FW_DIR_PATH . 'customizer/customizer.php';
        }

        function load_codestar() {
            if( !defined( 'CS_OPTION' ) ) {
                define( 'CS_OPTION', '_dt_cs_options' );
            }
            require_once DT_FW_DIR_PATH . 'cs-framework/cs-framework.php';
        }

        function load_widget_area_generator() {
            require_once DT_FW_DIR_PATH . 'widget-area/widget-area.php';
        }

        function load_post_types() {
            require_once DT_FW_DIR_PATH . 'post-types/post-types.php';
        }

        function i18n() {
            load_plugin_textdomain( 'designthemes-framework', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function add_body_classes( $classes ) {
            $classes[] = 'designthemes-framework-'.DT_FW_VERSION;
            return $classes;
        }
    }
}

if( !function_exists( 'dt_fw' ) ) {
    function dt_fw() {
        return DesignThemesFramework::instance();
    }
}

dt_fw();