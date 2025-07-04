<?php

/**
 * Listing Customizer - Product Single - Default Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Default' ) ) {

    class Dt_Shop_Customizer_Single_Default {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'savon_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_enable_breadcrumb                 = dt_customizer_settings('dt-single-product-enable-breadcrumb' );
            $settings['product_enable_breadcrumb']     = $product_enable_breadcrumb;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Enable Breadcrumb
            */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-enable-breadcrumb]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-enable-breadcrumb]', array(
                            'type'    => 'dt-switch',
                            'label'   => esc_html__( 'Enable Breadcrumb', 'dtshop'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'dtshop' ),
                                'off' => esc_attr__( 'No', 'dtshop' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('dt_shop_customizer_single_default') ) {
	function dt_shop_customizer_single_default() {
		return Dt_Shop_Customizer_Single_Default::instance();
	}
}

dt_shop_customizer_single_default();