<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteHeader' ) ) {
    class CustomizerSiteHeader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 10 );
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-header-section',
                    array(
                        'title'    => esc_html__('Header', 'designthemes-theme'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 10,
                    )
                )                    
            );            

                /**
                 * Option :Site Header
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_header]', array(
                        'type'    => 'option',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_header]', array(
                            'type'    => 'select',
                            'section' => 'site-header-section',
                            'label'   => esc_html__( 'Site Header', 'designthemes-theme' ),
                            'choices' => apply_filters( 'dt_header_layouts', array() ),
                        )
                    )
                );            

        }
    }
}

CustomizerSiteHeader::instance();