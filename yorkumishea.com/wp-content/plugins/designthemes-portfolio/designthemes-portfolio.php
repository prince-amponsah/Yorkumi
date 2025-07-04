<?php
/**
 * Plugin Name:	DesignThemes Portfolio
 * Description: Portfolio plugin for the DesignThemes WordPress themes.
 * Version: 1.3
 * Author: the DesignThemes team
 * Author URI: http://themeforest.net/user/designthemes
 * Text Domain: designthemes-portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolio' ) ) {
    class DesignThemesPortfolio {

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
            do_action( 'dt_before_portfolio_plugin_load' );

                $this->define_constants();

                add_action( 'plugins_loaded', array( $this, 'i18n' ) );
                add_action( 'plugins_loaded', array( $this, 'check_requirements' ) );
                add_filter( 'sidebar_post_types', array( $this, 'add_post_type' ) );

            /**
             * After Hook
             */
            do_action( 'dt_after_portfolio_plugin_load' );
        }

        function define_constants() {
            define( 'DT_PORTFOLIO_VERSION', '1.0' );
            define( 'DT_PORTFOLIO_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'DT_PORTFOLIO_DIR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
            define( 'DT_PORTFOLIO_OPTION', 'dt_portfolio_permalinks' );
        }

        function i18n() {
            load_plugin_textdomain( 'designthemes-portfolio', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function check_requirements() {
            if( !defined('DT_FW_VERSION') || !defined('DT_CUSTOMISER_VAL') ) {
                add_action( 'admin_notices', array( $this, 'missing_core_framework' ) );
                return;
            }

            $this->load_modules();
            $this->frontend();
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
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'designthemes-portfolio' ),
                '<strong>' . esc_html__( 'DesignThemes Portfolio Plugin', 'designthemes-portfolio' ) . '</strong>',
                '<strong>' . esc_html__( 'DesignThemes Framework Plugin', 'designthemes-portfolio' ) . '</strong>'
            );

            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }

        function add_post_type( $post_types ) {
            array_push($post_types, 'dt_portfolios' );
            return $post_types;
        }

        function load_modules() {

            /**
             * Before Hook
             */
            do_action( 'dt_before_portfolio_load_modules' );

                include_once DT_PORTFOLIO_DIR_PATH.'register/index.php';
                include_once DT_PORTFOLIO_DIR_PATH.'elementor/index.php';
                include_once DT_PORTFOLIO_DIR_PATH.'customizer/index.php';

                include_once DT_PORTFOLIO_DIR_PATH.'single/index.php';
                include_once DT_PORTFOLIO_DIR_PATH.'archive/index.php';

            /**
             * After Hook
             */
            do_action( 'dt_afer_portfolio_load_modules' );
        }

        function frontend() {
            add_filter( 'body_class', array( $this, 'add_body_classes' ) );
        }

        function add_body_classes( $classes ) {
            $classes[] = 'designthemes-portfolio-'.DT_PORTFOLIO_VERSION;
            return $classes;
        }
    }
}

if( !function_exists( 'dt_portfolio_plugin' ) ) {
    function dt_portfolio_plugin() {
        return DesignThemesPortfolio::instance();
    }
}

dt_portfolio_plugin();