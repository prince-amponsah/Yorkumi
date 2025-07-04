<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteToTop' ) ) {
    class CustomizerSiteToTop {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 40 );
        }

        function default( $option ) {
            $option['show_site_to_top'] = '0';
            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-to-top-section',
                    array(
                        'title'    => esc_html__('To Top', 'designthemes-theme'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 40,
                    )
                )                    
            );

                /**
                 * Option : Enable Site To Top
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[show_site_to_top]', array(
                        'type' => 'option',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[show_site_to_top]', array(
                            'type'    => 'dt-switch',
                            'section' => 'site-to-top-section',
                            'label'   => esc_html__( 'Enable To Top', 'designthemes-theme' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            )
                        )
                    )
                );
        }
    }
}

CustomizerSiteToTop::instance();