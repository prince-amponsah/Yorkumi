<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesBreadCrumbTypo' ) ) {
    class DesignThemesBreadCrumbTypo {

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
            add_action( 'customize_register', array( $this, 'register' ), 15);            
        }

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-typo-section',
                    array(
                        'title'    => esc_html__('Typograpy', 'designthemes-theme'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 15,
                    )
                )
            );

            /**
             * Option :Breadcrumb Title Typo
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_title_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_title_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-breadcrumb-typo-section',
                            'label'   => esc_html__( 'Title Typography', 'designthemes-theme'),
                        )
                    )
                );


            /**
             * Option :Breadcrumb Typo
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_typo]', array(
                            'type'    => 'dt-typography',
                            'section' => 'site-breadcrumb-typo-section',
                            'label'   => esc_html__( 'Breadcrumb Typography', 'designthemes-theme'),
                        )
                    )
                );
        }
    }
}

DesignThemesBreadCrumbTypo::instance();