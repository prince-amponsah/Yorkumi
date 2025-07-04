<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteHooks' ) ) {
    class CustomizerSiteHooks {

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
                    'site-hook-main-panel',
                    array(
                        'title'    => esc_html__('Site Hooks', 'designthemes-theme'),
                        'priority' => dt_customizer_panel_priority( 'hooks' )
                    )
                )
            );
        }

        function load_modules() {
            foreach( glob( DT_THEME_DIR_PATH. 'modules/hooks/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }        

    }
}

CustomizerSiteHooks::instance();