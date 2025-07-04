<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteBreadcrumb' ) ) {
    class CustomizerSiteBreadcrumb {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
            $this->load_modules();
        }

        function register( $wp_customize ) {
            /**
             * Panel
             */
            $wp_customize->add_panel( 
                new DT_WP_Customize_Panel(
                    $wp_customize,
                    'site-breadcrumb-main-panel',
                    array(
                        'title'    => esc_html__('Site Breadcrumb', 'designthemes-theme'),
                        'priority' => dt_customizer_panel_priority( 'breadcrumb' )
                    )
                )
            );
        }

        function load_modules() {
            foreach( glob( DT_THEME_DIR_PATH. 'modules/breadcrumb/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }
    }
}

CustomizerSiteBreadcrumb::instance();