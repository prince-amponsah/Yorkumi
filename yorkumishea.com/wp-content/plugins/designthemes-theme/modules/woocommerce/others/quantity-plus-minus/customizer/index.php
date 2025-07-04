<?php

/**
 * WooCommerce - Others - Quantity Plus Minus - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Others_Quantity_Plus_Minus' ) ) {

    class Dt_Shop_Customizer_Others_Quantity_Plus_Minus {

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

            $enable_quantity_plusminus             = dt_customizer_settings('dt-woo-others-enable-quantity-plusminus' );
            $settings['enable_quantity_plusminus'] = $enable_quantity_plusminus;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Enable Quantity Plus Minus
             */

                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-woo-others-enable-quantity-plusminus]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-others-enable-quantity-plusminus]', array(
                            'type'    => 'dt-switch',
                            'label'   => esc_html__( 'Enable Quantity Plus Minus', 'designthemes-theme'),
                            'section' => 'woocommerce-others-section',
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


if( !function_exists('dt_shop_customizer_others_quantity_plus_minus') ) {
	function dt_shop_customizer_others_quantity_plus_minus() {
		return Dt_Shop_Customizer_Others_Quantity_Plus_Minus::instance();
	}
}

dt_shop_customizer_others_quantity_plus_minus();