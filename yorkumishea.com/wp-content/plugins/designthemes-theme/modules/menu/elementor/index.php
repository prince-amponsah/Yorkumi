<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesMenuElementor' ) ) {
    class DesignThemesMenuElementor {

        private static $_instance = null;

        const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

        const MINIMUM_PHP_VERSION = '7.2';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_action( 'plugins_loaded', array( $this, 'register_init' ) );
        }

        function register_init() {
            if ( ! did_action( 'elementor/loaded' ) ) {
                add_action( 'admin_notices', array( $this, 'missing_elementor_plugin' ) );
                return;
            }

            if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
                add_action( 'admin_notices', array( $this, 'minimum_elementor_version' ) );
                return;
            }

            if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
                add_action( 'admin_notices', array( $this, 'minimum_php_version' ) );
                return;
            }

            add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
            $this->load_modules();
        }

        function load_modules() {
            foreach( glob( DT_THEME_DIR_PATH. 'modules/menu/elementor/widgets/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function missing_elementor_plugin() {

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }

            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor */
                esc_html__( '"%1$s" recommends "%2$s" to be installed and activated.', 'designthemes-theme' ),
                '<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-theme' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'designthemes-theme' ) . '</strong>'            
            );

            printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
        }

        function minimum_elementor_version() {

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }

            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" recommends "%2$s" version %3$s or greater.', 'designthemes-theme' ),
                '<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-theme' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'designthemes-theme' ) . '</strong>',
                 self::MINIMUM_ELEMENTOR_VERSION
            );

            printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
        }

        function minimum_php_version() {

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }

            $message = sprintf(
                /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                esc_html__( '"%1$s" recommends "%2$s" version %3$s or greater.', 'designthemes-theme' ),
                '<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-theme' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'designthemes-theme' ) . '</strong>',
                 self::MINIMUM_PHP_VERSION
            );

            printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
        }

        function register_category( $elements_manager ) {
            $elements_manager->add_category(
                'dt-widgets', array(
                    'title' => esc_html__( 'DesignThemes', 'designthemes-theme' ),
                    'icon'  => 'font'
                )
            );
        }
    }
}

DesignThemesMenuElementor::instance();