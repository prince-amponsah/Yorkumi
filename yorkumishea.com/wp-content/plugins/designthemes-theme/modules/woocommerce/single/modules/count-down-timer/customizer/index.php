<?php

/**
 * WooCommerce - Single - Module - Count Down Timer - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Count_Down_Timer' ) ) {

    class Dt_Shop_Customizer_Single_Count_Down_Timer {

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

            $product_sale_countdown_timer              = dt_customizer_settings('dt-single-product-sale-countdown-timer' );
            $settings['product_sale_countdown_timer']  = $product_sale_countdown_timer;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Sale Countdown Timer
            */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-sale-countdown-timer]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-sale-countdown-timer]', array(
                            'type'    => 'dt-switch',
                            'label'   => esc_html__( 'Enable Sale Countdown Timer', 'designthemes-theme'),
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


if( !function_exists('dt_shop_customizer_single_count_down_timer') ) {
	function dt_shop_customizer_single_count_down_timer() {
		return Dt_Shop_Customizer_Single_Count_Down_Timer::instance();
	}
}

dt_shop_customizer_single_count_down_timer();