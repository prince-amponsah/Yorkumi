<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesWidgetContentSettings' ) ) {
    class DesignThemesWidgetContentSettings {

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
            $this->selector = apply_filters( 'dt_theme_widget_content_selector', array( '.secondary-sidebar .widget' ) );
            $this->settings = dt_customizer_settings('widget_content_typo');

            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'dt_theme_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'dt_theme_plugin_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );            
        }

        function default( $option ) {
            $option['widget_content_color']         = '';
            $option['widget_content_a_color']       = '';
            $option['widget_content_a_hover_color'] = '';
            $option['widget_content_typo']          = array();
            return $option;
        }

        function register( $wp_customize ){

            /**
             * Title Section
             */
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-widgets-content-style-section',
                    array(
                        'title'    => esc_html__('Widget Content', 'designthemes-theme'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 10,
                    )
                )
            );
                /**
                 * Option : Content Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[widget_content_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Color(
                        $wp_customize, DT_CUSTOMISER_VAL . '[widget_content_color]', array(
                            'section' => 'site-widgets-content-style-section',
                            'label'   => esc_html__( 'Content Color', 'designthemes-theme' ),
                        )
                    )
                );

                /**
                 * Option : Content Anchor Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[widget_content_a_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Color(
                        $wp_customize, DT_CUSTOMISER_VAL . '[widget_content_a_color]', array(
                            'section' => 'site-widgets-content-style-section',
                            'label'   => esc_html__( 'Content Link Color', 'designthemes-theme' ),
                        )
                    )
                );

                /**
                 * Option : Content Anchor Hover Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[widget_content_a_hover_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Color(
                        $wp_customize, DT_CUSTOMISER_VAL . '[widget_content_a_hover_color]', array(
                            'section' => 'site-widgets-content-style-section',
                            'label'   => esc_html__( 'Content Link Hover Color', 'designthemes-theme' ),
                        )
                    )
                );                
                
                /**
                 * Option :Content Typo
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[widget_content_typo]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[widget_content_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-widgets-content-style-section',
                            'label'   => esc_html__( 'Content Typography', 'designthemes-theme'),
                        )
                    )
                );

        }

        function fonts_list( $fonts ) {
            return dt_customizer_frontend_font( $this->settings, $fonts );
        }
        
        function base_style( $style ) {
            $css   = '';
            $color = dt_customizer_settings('widget_content_color');

            $css .= dt_customizer_typography_settings( $this->settings );
            $css .= dt_customizer_color_settings( $color );

            $css = dt_customizer_dynamic_style( $this->selector, $css );

            $a_color = dt_customizer_settings('widget_content_a_color');
            $a_color = dt_customizer_color_settings( $a_color );
            if(!empty( $a_color ) ) {
                $css .= dt_customizer_dynamic_style( '.secondary-sidebar .widget a, .secondary-sidebar .widget ul li a', $a_color );
            }
            
            $a_h_color = dt_customizer_settings('widget_content_a_hover_color');
            $a_h_color = dt_customizer_color_settings( $a_h_color );
            if(!empty( $a_h_color ) ) {
                $css .= dt_customizer_dynamic_style( '.secondary-sidebar .widget a:hover, .secondary-sidebar .widget ul li a:hover', $a_h_color );
            }            

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

DesignThemesWidgetContentSettings::instance();      