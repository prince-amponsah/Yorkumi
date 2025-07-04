<?php

/**
 * WooCommerce - Single - Module - Buy Now - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Buy_Now' ) ) {

    class Dt_Shop_Customizer_Single_Buy_Now {

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

            $product_buy_now                   = dt_customizer_settings('dt-single-product-buy-now' );
            $settings['product_buy_now']       = $product_buy_now;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Buy Now
            */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-buy-now]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-buy-now]', array(
                            'type'    => 'dt-switch',
                            'label'   => esc_html__( 'Enable Buy Now', 'designthemes-theme'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            ),
                            'description'   => esc_html__('This option is applicable only for "WooCommerce Default" single page.', 'designthemes-theme')
                        )
                    )
                );

        }

    }

}


if( !function_exists('dt_shop_customizer_single_buy_now') ) {
	function dt_shop_customizer_single_buy_now() {
		return Dt_Shop_Customizer_Single_Buy_Now::instance();
	}
}

dt_shop_customizer_single_buy_now();