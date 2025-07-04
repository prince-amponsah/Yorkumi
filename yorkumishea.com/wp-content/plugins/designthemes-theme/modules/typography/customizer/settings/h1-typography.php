<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesH1Settings' ) ) {
    class DesignThemesH1Settings {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            $this->selector = apply_filters( 'dt_theme_h1_selector', array( 'h1' ) );
            $this->settings = dt_customizer_settings('h1_typo');

            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'dt_theme_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'dt_theme_plugin_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-h1-section',
                    array(
                        'title'    => esc_html__('H1 Typograpy', 'designthemes-theme'),
                        'panel'    => 'site-typograpy-main-panel',
                        'priority' => 5,
                    )
                )                    
            );

                /**
                 * Option :H1 Typo
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[h1_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[h1_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-h1-section',
                            'label'   => esc_html__( 'H1 Tag', 'designthemes-theme'),
                        )
                    )
                );

                /**
                 * Option : H1 Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[h1_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[h1_color]', array(
                            'label'   => esc_html__( 'Color', 'designthemes-theme' ),
                            'section' => 'site-h1-section',
                        )
                    )
                );
        }

        function fonts_list( $fonts ) {
            return dt_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = dt_customizer_settings('h1_color');

            $css .= dt_customizer_typography_settings( $this->settings );
            $css .= dt_customizer_color_settings( $color );

            $css = dt_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_landscape_style( $style ) {
            $css = dt_customizer_responsive_typography_settings( $this->settings, 'tablet-ls' );
            $css = dt_customizer_dynamic_style( $this->selector, $css );
    
            return $style.$css;
        }

        function tablet_portrait( $style ) {
            $css = dt_customizer_responsive_typography_settings( $this->settings, 'tablet' );
            $css = dt_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function mobile_style( $style ) {
            $css = dt_customizer_responsive_typography_settings( $this->settings, 'mobile' );
            $css = dt_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

    }
}

DesignThemesH1Settings::instance();