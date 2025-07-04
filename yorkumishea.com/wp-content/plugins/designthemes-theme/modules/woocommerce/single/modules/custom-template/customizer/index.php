<?php

/**
 * WooCommerce - Single - Module - Custom Template - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Default_CT' ) ) {

    class Dt_Shop_Customizer_Single_Default_CT {

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

            $product_default_template             = dt_customizer_settings('dt-single-product-default-template' );
            $settings['product_default_template'] = $product_default_template;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Product Template
             */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[dt-single-product-default-template]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[dt-single-product-default-template]', array(
                        'type'     => 'select',
                        'label'    => esc_html__( 'Product Template', 'designthemes-theme'),
                        'section'  => 'woocommerce-single-page-default-section',
                        'choices'  => apply_filters( 'dtshop_single_product_default_template', array(
                                        'woo-default'     => esc_html__( 'WooCommerce Default', 'designthemes-theme' ),
                                        'custom-template' => esc_html__( 'Custom Template', 'designthemes-theme' )
                                    ) )
                    )
                );

        }

    }

}


if( !function_exists('dt_shop_customizer_single_default_ct') ) {
	function dt_shop_customizer_single_default_ct() {
		return Dt_Shop_Customizer_Single_Default_CT::instance();
	}
}

dt_shop_customizer_single_default_ct();