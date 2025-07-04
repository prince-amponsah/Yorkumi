<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteFooter' ) ) {
    class CustomizerSiteFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 20 );
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-footer-section',
                    array(
                        'title'    => esc_html__('Footer', 'designthemes-theme'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 20,
                    )
                )                    
            );            

                /**
                 * Option :Site Footer
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_footer]', array(
                        'type'    => 'option',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_footer]', array(
                            'type'    => 'select',
                            'section' => 'site-footer-section',
                            'label'   => esc_html__( 'Site Footer', 'designthemes-theme' ),
                            'choices' => apply_filters( 'dt_footer_layouts', array( '' => esc_html__('Minimal Footer', 'designthemes-theme') ) ),
                        )
                    )
                );            

        }
    }
}

CustomizerSiteFooter::instance();