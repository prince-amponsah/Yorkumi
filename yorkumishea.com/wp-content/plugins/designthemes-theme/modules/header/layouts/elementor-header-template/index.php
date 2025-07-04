<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesElementorHeader' ) ) {
    class DesignThemesElementorHeader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_header_layouts', array( $this, 'add_elementor_header_option' ), 20 );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 20 );

        }

        function add_elementor_header_option( $options ) {
            $options['elementor-header'] = esc_html__('Elementor Header', 'designthemes-theme');
            return $options;
        }

        function register_general( $wp_customize ) {
            /**
             * Option :Site Elementor Header
             */
            /*$wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[site_elementor_header]', array(
                    'type'    => 'option',
                )
            );
            
            $wp_customize->add_control(
                new DT_WP_Customize_Control(
                    $wp_customize, DT_CUSTOMISER_VAL . '[site_elementor_header]', array(
                        'type'       => 'select',
                        'section'    => 'site-header-section',
                        'label'      => esc_html__( 'Elementor Headers', 'designthemes-theme' ),
                        'dependency' => array( 'site_header', '==', 'elementor-header' ),
                        'choices'    => dt_header_template_list()
                    )
                )
            );  */

            /**
             * Option :Site Elementor Header
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[site_elementor_header]', array(
                    'type'    => 'dt-description',
                )
            );
            
            $wp_customize->add_control(
                new DT_WP_Customize_Control_Description(
                    $wp_customize, DT_CUSTOMISER_VAL . '[site_elementor_header]', array(
                        'type'        => 'dt-description',
                        'section'     => 'site-header-section',
                        'label'       => esc_html__( 'Elementor Headers', 'designthemes-theme' ),
                        'dependency'  => array( 'site_header', '==', 'elementor-header' ),
                        'description' => esc_html__( 'Compatible with Jet Elements, you can build and assign it in elementor.', 'designthemes-theme' ),
                    )
                )
            );            

        }        
    }
}

DesignThemesElementorHeader::instance();