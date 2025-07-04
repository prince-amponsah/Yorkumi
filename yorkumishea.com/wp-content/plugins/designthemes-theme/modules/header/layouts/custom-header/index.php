<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesCustomHeader' ) ) {
    class DesignThemesCustomHeader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_header_layouts', array( $this, 'add_custom_header_option' ), 20 );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 20 );
            add_filter( 'savon_header_get_template_part', array( $this, 'register_header_template' ) );
        }

        function add_custom_header_option( $options ) {
            $options['custom-header'] = esc_html__('Custom Header', 'designthemes-theme');
            return $options;
        }

        function register_general( $wp_customize ) {
            /**
             * Option :Site Elementor Header
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[site_custom_header]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control(
                    $wp_customize, DT_CUSTOMISER_VAL . '[site_custom_header]', array(
                        'type'       => 'select',
                        'section'    => 'site-header-section',
                        'label'      => esc_html__( 'Header Template', 'designthemes-theme' ),
                        'dependency' => array( 'site_header', '==', 'custom-header' ),
                        'choices'    => dt_header_template_list()
                    )
                )
            );
        }

        function register_header_template( $template ) {
            $header_type = dt_customizer_settings( 'site_header' );

            if( !is_singular() && 'custom-header' == $header_type ) :

                $id = dt_customizer_settings( 'site_custom_header' );

                if( ! $id || $id == -1 ) {
                    echo $template;
                    return;
                }

                apply_filters( 'savon_print_header_template', $id );

            elseif( !is_singular() ):
                echo $template;
            endif;
        }
    }
}

DesignThemesCustomHeader::instance();