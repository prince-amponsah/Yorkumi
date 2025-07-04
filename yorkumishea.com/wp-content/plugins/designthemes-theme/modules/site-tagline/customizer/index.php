<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteTagline' ) ) {
    class CustomizerSiteTagline {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-tagline-section',
                    array(
                        'title'    => esc_html__('Site Tagline', 'designthemes-theme'),
                        'panel'    => 'site-identity-main-panel',
                        'priority' => 15,
                    )
                )
            );

            $wp_customize->get_control('blogdescription')->section = 'site-tagline-section';
            $wp_customize->get_control('blogdescription')->priority = 5;


            /**
             * Option :Site Tagline Typography
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-tagline-section',
                            'label'   => esc_html__( 'Typography', 'designthemes-theme'),
                        )
                    )
                );


            /**
             * Option : Site Title Color
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_tagline_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_tagline_color]', array(
                            'label'   => esc_html__( 'Color', 'designthemes-theme' ),
                            'section' => 'site-tagline-section',
                        )
                    )
                );
        }

    }
}

CustomizerSiteTagline::instance();          