<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteTitle' ) ) {
    class CustomizerSiteTitle {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'dt_theme_google_fonts_list', array( $this, 'fonts_list' ) );
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-title-section',
                    array(
                        'title'    => esc_html__('Site Title', 'designthemes-theme'),
                        'panel'    => 'site-identity-main-panel',
                        'priority' => 10,
                    )
                )
            );

            $wp_customize->get_control('blogname')->section  = 'site-title-section';
            $wp_customize->get_control('blogname')->priority = 5;

            /**
             * Option :Site Title Typography
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_title_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_title_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-title-section',
                            'label'   => esc_html__( 'Typography', 'designthemes-theme'),
                        )
                    )
                );


            /**
             * Option : Site Title Color
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_title_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_title_color]', array(
                            'label'   => esc_html__( 'Color', 'designthemes-theme' ),
                            'section' => 'site-title-section',
                        )
                    )
                );


            /**
             * Option : Site Title Hover Color
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_title_hover_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_title_hover_color]', array(
                            'label'   => esc_html__( 'Hover Color', 'designthemes-theme' ),
                            'section' => 'site-title-section',
                        )
                    )
                );

        }

        function fonts_list( $fonts ) {
            $settings = dt_customizer_settings( 'site_title_typo' );
            return dt_customizer_frontend_font( $settings, $fonts );
        }

    }
}

CustomizerSiteTitle::instance();          