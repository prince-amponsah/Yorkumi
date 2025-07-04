<?php

/**
 * WooCommerce - Others - Cart Notification - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Others_Cart_Notification' ) ) {

    class Dt_Shop_Customizer_Others_Cart_Notification {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'savon_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $addtocart_custom_action                   = dt_customizer_settings('dt-woo-addtocart-custom-action' );
            $settings['addtocart_custom_action']       = $addtocart_custom_action;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Add To Cart Custom Action
             */

                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-woo-addtocart-custom-action]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[dt-woo-addtocart-custom-action]', array(
                        'type'     => 'select',
                        'label'    => esc_html__( 'Add To Cart Custom Action', 'designthemes-theme'),
                        'section'  => 'woocommerce-others-section',
                        'choices'  => apply_filters( 'dtshop_others_addtocart_custom_action',
                            array(
                                ''                    => esc_html__('None', 'designthemes-theme'),
                                'sidebar_widget'      => esc_html__('Sidebar Widget', 'designthemes-theme'),
                                'notification_widget' => esc_html__('Notification Widget', 'designthemes-theme'),
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('dt_shop_customizer_others_cart_notification') ) {
	function dt_shop_customizer_others_cart_notification() {
		return Dt_Shop_Customizer_Others_Cart_Notification::instance();
	}
}

dt_shop_customizer_others_cart_notification();