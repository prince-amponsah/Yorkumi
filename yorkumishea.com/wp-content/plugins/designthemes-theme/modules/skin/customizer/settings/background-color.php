<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesMainBGColor' ) ) {
    class DesignThemesMainBGColor {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'dt_theme_plugin_body_bg_color_css_var', array( $this, 'body_bg_color_var' ) );
            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $option['body_bg_color'] = '#ffffff';
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option : Primary Color
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[body_bg_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Color(
                    $wp_customize, DT_CUSTOMISER_VAL . '[body_bg_color]', array(
                        'section' => 'site-skin-main-section',
                        'label'   => esc_html__( 'Main Background Color', 'designthemes-theme' ),
                    )
                )
            );
        }

        function body_bg_color_var( $var ) {
            $body_bg_color = dt_customizer_settings( 'body_bg_color' );
            if( !empty( $body_bg_color ) ) {
                $var = '--DTBodyBGColor:'.$body_bg_color.';';
            }

            return $var;            
        }

        function base_style( $style ) {
            return $style;
        }
    }
}

DesignThemesMainBGColor::instance();