<?php

/**
 * WooCommerce - Single - Module - Additional Info - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Additional_Info' ) ) {

    class Dt_Shop_Customizer_Single_Additional_Info {

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

            $product_additional_info                   = dt_customizer_settings('dt-single-product-additional-info' );
            $settings['product_additional_info']       = $product_additional_info;

            $product_ai_delivery_period                = dt_customizer_settings('dt-single-product-ai-delivery-period' );
            $settings['product_ai_delivery_period']    = $product_ai_delivery_period;

            $product_ai_visitors_min_value             = dt_customizer_settings('dt-single-product-ai-visitors-min-value' );
            $settings['product_ai_visitors_min_value'] = $product_ai_visitors_min_value;

            $product_ai_visitors_max_value             = dt_customizer_settings('dt-single-product-ai-visitors-max-value' );
            $settings['product_ai_visitors_max_value'] = $product_ai_visitors_max_value;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Additional Info
            */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-additional-info]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-additional-info]', array(
                            'type'    => 'dt-switch',
                            'label'   => esc_html__( 'Enable Additional Info', 'designthemes-theme'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            ),
                            'description'   => esc_html__('This option is applicable only for "WooCommerce Default" single page.', 'designthemes-theme')
                        )
                    )
                );

            /**
             * Option : Additional Info - Delivery Period
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-ai-delivery-period]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[dt-single-product-ai-delivery-period]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Delivery Period', 'designthemes-theme' ),
                        'dependency'  => array( 'dt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Delivery Offer: If purchased today product will be delivered in above mentioned period.', 'designthemes-theme')
                    )
                );

            /**
             * Option : Additional Info - Visitors Min Value
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-ai-visitors-min-value]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[dt-single-product-ai-visitors-min-value]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Visitors Min Value', 'designthemes-theme' ),
                        'dependency'  => array( 'dt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Real Time Visitors: Minimum value', 'designthemes-theme')
                    )
                );

            /**
             * Option : Additional Info - Visitors Max Value
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-ai-visitors-max-value]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[dt-single-product-ai-visitors-max-value]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Visitors Max Value', 'designthemes-theme' ),
                        'dependency'  => array( 'dt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Real Time Visitors: Maximum value', 'designthemes-theme')
                    )
                );


        }

    }

}


if( !function_exists('dt_shop_customizer_single_additional_info') ) {
	function dt_shop_customizer_single_additional_info() {
		return Dt_Shop_Customizer_Single_Additional_Info::instance();
	}
}

dt_shop_customizer_single_additional_info();