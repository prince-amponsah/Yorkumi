<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteLoader' ) ) {
    class CustomizerSiteLoader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 30 );
        }

        function default( $option ) {

            $option['show_site_loader'] = '1';
            $option['site_loader']      = '';

            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-loader-section',
                    array(
                        'title'    => esc_html__('Loader', 'designthemes-theme'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 30,
                    )
                )                    
            );

                /**
                 * Option : Enable Site Loader
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[show_site_loader]', array(
                        'type' => 'option',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[show_site_loader]', array(
                            'type'    => 'dt-switch',
                            'section' => 'site-loader-section',
                            'label'   => esc_html__( 'Enable Loader', 'designthemes-theme' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            )
                        )
                    )
                );

                /**
                 * Option :Site Loader
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[site_loader]', array(
                        'type'    => 'option',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[site_loader]', array(
                            'type'       => 'select',
                            'section'    => 'site-loader-section',
                            'label'      => esc_html__( 'Select Loader', 'designthemes-theme' ),
                            'choices'    => apply_filters( 'dt_loader_layouts', array() ),
                            'dependency' => array( 'show_site_loader', '!=', '' ),
                        )
                    )
                );                 
        }

    }
}

CustomizerSiteLoader::instance();