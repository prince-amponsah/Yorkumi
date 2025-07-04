<?php

/**
 * Customizer - Product Single Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Customizer_Single' ) ) {

    class Dt_Theme_Customizer_Single {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function default( $option ) {

            $settings = dt_woo_single_core()->woo_default_settings();
            extract($settings);

            $option['dt-single-product-default-template']           = $product_default_template;
            $option['dt-single-product-sale-countdown-timer']       = $product_sale_countdown_timer;
            $option['dt-single-product-enable-size-guide']          = $product_enable_size_guide;
            $option['dt-single-product-enable-breadcrumb']          = $product_enable_breadcrumb;
            $option['dt-single-product-addtocart-sticky']           = $product_addtocart_sticky;
            $option['dt-single-product-show-360-viewer']            = $product_show_360_viewer;
            $option['dt-single-product-enable-ajax-addtocart']      = $product_enable_ajax_addtocart;

            $option['dt-single-product-upsell-display']             = $product_upsell_display;
            $option['dt-single-product-upsell-title']               = $product_upsell_title;
            $option['dt-single-product-upsell-column']              = $product_upsell_column;
            $option['dt-single-product-upsell-limit']               = $product_upsell_limit;
            if( $product_upsell_style_template == 'predefined' ) {
                $option['dt-single-product-upsell-style-template']  = 'predefined-template-'.$product_upsell_style_custom_template;
            } else {
                $option['dt-single-product-upsell-style-template']  = $product_upsell_style_custom_template;
            }

            $option['dt-single-product-related-display']            = $product_related_display;
            $option['dt-single-product-related-title']              = $product_related_title;
            $option['dt-single-product-related-column']             = $product_related_column;
            $option['dt-single-product-related-limit']              = $product_related_limit;
            if( $product_related_style_template == 'predefined' ) {
                $option['dt-single-product-related-style-template'] = 'predefined-template-'.$product_related_style_custom_template;
            } else {
                $option['dt-single-product-related-style-template'] = $product_related_style_custom_template;
            }

            $option['dt-single-product-show-sharer-facebook']       = $product_show_sharer_facebook;
            $option['dt-single-product-show-sharer-delicious']      = $product_show_sharer_delicious;
            $option['dt-single-product-show-sharer-digg']           = $product_show_sharer_digg;
            $option['dt-single-product-show-sharer-stumbleupon']    = $product_show_sharer_stumbleupon;
            $option['dt-single-product-show-sharer-twitter']        = $product_show_sharer_twitter;
            $option['dt-single-product-show-sharer-googleplus']     = $product_show_sharer_googleplus;
            $option['dt-single-product-show-sharer-linkedin']       = $product_show_sharer_linkedin;
            $option['dt-single-product-show-sharer-pinterest']      = $product_show_sharer_pinterest;

            return $option;

        }

        function register( $wp_customize ) {

            $wp_customize->add_panel(
                new DT_WP_Customize_Panel(
                    $wp_customize,
                    'woocommerce-single-page-section',
                    array(
                        'title'    => esc_html__('Product Single Page', 'designthemes-theme'),
                        'panel'    => 'woocommerce-main-section',
                        'priority' => 40
                    )
                )
            );

                $wp_customize->add_section(
                    new DT_WP_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-default-section',
                        array(
                            'title'    => esc_html__('Default Settings', 'designthemes-theme'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 10,
                        )
                    )
                );

                $wp_customize->add_section(
                    new DT_WP_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-upsell-section',
                        array(
                            'title'    => esc_html__('Upsell Settings', 'designthemes-theme'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 20,
                        )
                    )
                );

                $wp_customize->add_section(
                    new DT_WP_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-related-section',
                        array(
                            'title'    => esc_html__('Related Settings', 'designthemes-theme'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 30,
                        )
                    )
                );

                $wp_customize->add_section(
                    new DT_WP_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-sociable-share-section',
                        array(
                            'title'    => esc_html__('Sociable Share Settings', 'designthemes-theme'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 40,
                        )
                    )
                );

                $wp_customize->add_section(
                    new DT_WP_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-sociable-follow-section',
                        array(
                            'title'    => esc_html__('Sociable Follow Settings', 'designthemes-theme'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 50,
                        )
                    )
                );

        }

    }

}


if( !function_exists('dt_theme_customizer_single') ) {
	function dt_theme_customizer_single() {
		return Dt_Theme_Customizer_Single::instance();
	}
}

dt_theme_customizer_single();