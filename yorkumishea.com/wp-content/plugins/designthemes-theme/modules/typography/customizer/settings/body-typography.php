<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesBodySettings' ) ) {
    class DesignThemesBodySettings {

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
            $this->selector = apply_filters( 'dt_theme_body_selector', array( 'body' ) );
            $this->settings = dt_customizer_settings('body_typo');

            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'dt_theme_google_fonts_list', array( $this, 'fonts_list' ) );

            add_filter( 'dt_theme_plugin_body_text_color_css_var', array( $this, 'body_text_color_var' ) );
            add_filter( 'dt_theme_plugin_link_color_css_var', array( $this, 'body_link_color_var' ) );
            add_filter( 'dt_theme_plugin_link_hover_color_css_var', array( $this, 'body_link_hover_color_var' ) );

            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'dt_theme_plugin_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );            
        }

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-body-section',
                    array(
                        'title'    => esc_html__('Body Content Typograpy', 'designthemes-theme'),
                        'panel'    => 'site-typograpy-main-panel',
                        'priority' => 35,
                    )
                )
            );

                /**
                 * Option :Body Typo
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[body_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[body_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-body-section',
                            'label'   => esc_html__( 'Body', 'designthemes-theme'),
                        )
                    )
                );

                /**
                 * Option : Body Content Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[body_content_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[body_content_color]', array(
                            'label'   => esc_html__( 'Color', 'designthemes-theme' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

                /**
                 * Option : Body Content Link Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[body_link_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[body_link_color]', array(
                            'label'   => esc_html__( 'Link Color', 'designthemes-theme' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

                /**
                 * Option : Body Content Link Hover Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[body_link_hover_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[body_link_hover_color]', array(
                            'label'   => esc_html__( 'Link Hover Color', 'designthemes-theme' ),
                            'section' => 'site-body-section',
                        )
                    )
                );            

        }

        function fonts_list( $fonts ) {
            return dt_customizer_frontend_font( $this->settings, $fonts );
        }

        function body_text_color_var( $var ) {
            $body_content_color = dt_customizer_settings( 'body_content_color' );
            if( !empty( $body_content_color ) ) {
                $var = '--DTBodyTxtColor:'.$body_content_color.';';
            }

            return $var;
        }
        
        function body_link_color_var( $var ) {
            $body_link_color = dt_customizer_settings( 'body_link_color' );
            if( !empty( $body_link_color ) ) {
                $var = '--DTLinkColor:'.$body_link_color.';';
            }

            return $var;
        }
        
        function body_link_hover_color_var( $var ) {
            $body_link_hover_color = dt_customizer_settings( 'body_link_hover_color' );
            if( !empty( $body_link_hover_color ) ) {
                $var = '--DTLinkHoverColor:'.$body_link_hover_color.';';
            }

            return $var;
        }        

        function base_style( $style ) {
            $css   = '';
            $color = dt_customizer_settings('body_content_color');

            $css .= dt_customizer_typography_settings( $this->settings );
            $css .= dt_customizer_color_settings( $color );

            $css = dt_customizer_dynamic_style( $this->selector, $css );

            $l_color = dt_customizer_settings('body_link_color');
            if( !empty( $l_color ) ) {
                $css .= 'a { color:'.$l_color.';}'."\n";
            }
    
            $lh_color = dt_customizer_settings('body_link_hover_color');
            if( !empty( $lh_color ) ) {
                $css .= 'a:hover { color:'.$lh_color.';}'."\n";
            }
    
            if( isset( $settings['text-decoration'] ) && !empty( $settings['text-decoration'] ) ) {
                $css .= 'body p { text-decoration:'.$settings['text-decoration'].';}'."\n";
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

DesignThemesBodySettings::instance();