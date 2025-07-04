<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteLayout' ) ) {
    class CustomizerSiteLayout {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'body_class', array( $this, 'body_class' ) );
        }
        
        function register( $wp_customize ) {

            /**
             * Site Layout Section
             */
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-layout-main-section',
                    array(
                        'title'    => esc_html__('Site Layout', 'designthemes-theme'),
                        'priority' => dt_customizer_panel_priority( 'layout' )
                    )
                )                    
            );

                /**
                 * Option :Site Layout
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_layout]', array(
                        'type'    => 'option',
                        'default' => 'wide'
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_layout]', array(
                            'type'    => 'select',
                            'section' => 'site-layout-main-section',
                            'label'   => esc_html__( 'Site Layout', 'designthemes-theme' ),
                            'choices' => apply_filters( 'dt_site_layouts', array() ),
                        )
                    )
                );


            do_action('dt_site_layout_cutomizer_options', $wp_customize );

        }

        function body_class( $classes ) {
            $layout = dt_customizer_settings('site_layout');
            
            if( !empty( $layout ) ) {
                $classes[] = $layout;
            }

            return $classes;
        }        
    }
}

CustomizerSiteLayout::instance();