<?php

/**
 * WooCommerce - Single - Module - Sticky Cart - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Sticky_Cart' ) ) {

    class Dt_Shop_Customizer_Single_Sticky_Cart {

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

            $product_addtocart_sticky             = dt_customizer_settings('dt-single-product-addtocart-sticky' );
            $settings['product_addtocart_sticky'] = $product_addtocart_sticky;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Sticky Add to Cart
            */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-addtocart-sticky]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-addtocart-sticky]', array(
                            'type'    => 'dt-switch',
                            'label'   => esc_html__( 'Sticky Add to Cart', 'designthemes-theme'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('dt_shop_customizer_single_sticky_cart') ) {
	function dt_shop_customizer_single_sticky_cart() {
		return Dt_Shop_Customizer_Single_Sticky_Cart::instance();
	}
}

dt_shop_customizer_single_sticky_cart();