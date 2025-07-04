<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSkinTertiaryColor' ) ) {
    class DesignThemesSkinTertiaryColor {
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

            add_filter( 'dt_theme_plugin_tertiary_color_css_var', array( $this, 'tertiary_color_var' ) );
            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $option['tertiary_color'] = '#f9ce98';
            return $option;
        }

        function register( $wp_customize ) {

                /**
                 * Option : Tertiary Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[tertiary_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Color(
                        $wp_customize, DT_CUSTOMISER_VAL . '[tertiary_color]', array(
                            'section' => 'site-skin-main-section',
                            'label'   => esc_html__( 'Tertiary Color', 'designthemes-theme' ),
                        )
                    )
                );            

        }

        function tertiary_color_var( $var ) {
            $tertiary_color = dt_customizer_settings( 'tertiary_color' );
            if( !empty( $tertiary_color ) ) {
                $var = '--DTTertiaryColor:'.$tertiary_color.';';
            }

            return $var;
        }        

        function base_style( $style ) {
            $style = apply_filters( 'dt_theme_plugin_tertiary_color_style', $style );

            return $style;
        }        
    }
}

DesignThemesSkinTertiaryColor::instance();