<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSiteLoader' ) ) {
    class DesignThemesSiteLoader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->load_loader_layouts();
            $this->load_modules();

            $this->frontend();
        }

        function load_loader_layouts() {
            foreach( glob( DT_THEME_DIR_PATH. 'modules/site-loader/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/site-loader/customizer/index.php';
        }

        function frontend() {
            $show_site_loader = dt_customizer_settings( 'show_site_loader' );
            if( $show_site_loader ) {
                add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'savon_hook_top', array( $this, 'load_template' ) );
            }
        }

        function add_body_classes( $classes ) {
            $classes[] = 'has-page-loader';
            return $classes;
        }

        function enqueue_assets() {
            
            wp_enqueue_script( 'pace', DT_THEME_DIR_URL . 'modules/site-loader/assets/js/pace.min.js', array('jquery'), DT_THEME_VERSION, true );
            wp_localize_script('pace', 'paceOptions', array(
                'restartOnRequestAfter' => 'false',
                'restartOnPushState'    => 'false'
            ) );

            wp_enqueue_script( 'site-loader', DT_THEME_DIR_URL . 'modules/site-loader/assets/js/site-loader.js', array('pace'), DT_THEME_VERSION, true );
        }

        function load_template() {
            $site_loader = dt_customizer_settings( 'site_loader' );
            echo dt_theme_get_template_part( 'site-loader/layouts/'.$site_loader, '/template', '', array() );
        }

    }
}

DesignThemesSiteLoader::instance();