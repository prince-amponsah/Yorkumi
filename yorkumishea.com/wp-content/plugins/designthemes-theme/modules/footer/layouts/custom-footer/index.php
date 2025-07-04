<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesCustomFooter' ) ) {
    class DesignThemesCustomFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_footer_layouts', array( $this, 'add_custom_footer_option' ), 20 );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 30 );
            add_filter( 'savon_footer_get_template_part', array( $this, 'register_footer_template' ), 10 );
        }

        function add_custom_footer_option( $options ) {
            $options['custom-footer'] = esc_html__('Custom Footer', 'designthemes-theme');
            return $options;
        }

        function register_general( $wp_customize ) {
            /**
             * Option :Site Elementor Header
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[site_custom_footer]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control(
                    $wp_customize, DT_CUSTOMISER_VAL . '[site_custom_footer]', array(
                        'type'       => 'select',
                        'section'    => 'site-footer-section',
                        'label'      => esc_html__( 'Footer Template', 'designthemes-theme' ),
                        'dependency' => array( 'site_footer', '==', 'custom-footer' ),
                        'choices'    => dt_footer_template_list()
                    )
                )
            );
        }

        function register_footer_template( $template ) {

            $footer_type = dt_customizer_settings( 'site_footer' );

            if( !is_singular() && 'custom-footer' == $footer_type ) :

                $id = dt_customizer_settings( 'site_custom_footer' );

                if( ! $id || $id == -1 ) {
                    echo $template;
                    return;
                }

                apply_filters( 'savon_print_footer_template', $id );

            elseif( !is_singular() ) :
                return $template;
            endif;
        }
    }
}

DesignThemesCustomFooter::instance();