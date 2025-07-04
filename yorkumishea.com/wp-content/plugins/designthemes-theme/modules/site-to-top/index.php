<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSiteToTop' ) ) {
    class DesignThemesSiteToTop {

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
            include_once DT_THEME_DIR_PATH.'modules/site-to-top/customizer/index.php';
        }

        function frontend() {
            $show = dt_customizer_settings('show_site_to_top');
            if( $show ) {
                add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wp_footer', array( $this, 'load_template' ), 999 );
            }
        }

        function add_body_classes( $classes ) {
            $classes[] = 'has-go-to-top';
            return $classes;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-to-top', DT_THEME_DIR_URL . 'modules/site-to-top/assets/css/dt-totop.css', false, DT_THEME_VERSION, 'all' );
            wp_enqueue_script( 'go-to-top', DT_THEME_DIR_URL . 'modules/site-to-top/assets/js/go-to-top.js', array('jquery'), DT_THEME_VERSION, true );
        }

        function load_template() {
            $args = array(
                'icon' => '<i class="dticon-angle-up"></i>'
            );

            echo dt_theme_get_template_part( 'site-to-top/layouts/', 'template', '', $args );
        }        
    }
}

DesignThemesSiteToTop::instance();