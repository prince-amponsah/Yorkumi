<?php

/**
 * Listing Customizer - Shop Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Listing_Customizer_Shop' ) ) {

    class Dt_Shop_Listing_Customizer_Shop {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'savon_woo_shop_page_default_settings', array( $this, 'shop_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function shop_page_default_settings( $settings ) {

            $bottom_hook                        = dt_customizer_settings('dt-woo-shop-page-bottom-hook' );
            $settings['bottom_hook']            = $bottom_hook;

            $show_sorter_on_header              = dt_customizer_settings('dt-woo-shop-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = dt_customizer_settings('dt-woo-shop-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = $sorter_header_elements;

            $show_sorter_on_footer              = dt_customizer_settings('dt-woo-shop-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = dt_customizer_settings('dt-woo-shop-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = $sorter_footer_elements;

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                 * Option : Bottom Hook
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-shop-page-bottom-hook]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-shop-page-bottom-hook]', array(
                                'type'        => 'textarea',
                                'label'       => esc_html__( 'Bottom Hook', 'dtshop' ),
                                'section'     => 'woocommerce-shop-page-section'
                            )
                        )
                    );

                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-shop-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-shop-page-show-sorter-on-header]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'dtshop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'dtshop' ),
                                    'off' => esc_attr__( 'No', 'dtshop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new DT_WP_Customize_Control_Sortable(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'dt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'dtshop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'savon_shop_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'dtshop' ),
                                'result_count'         => esc_html__( 'Result Count', 'dtshop' ),
                                'pagination'           => esc_html__( 'Pagination', 'dtshop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'dtshop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'dtshop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-shop-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-shop-page-show-sorter-on-footer]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'dtshop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'dtshop' ),
                                    'off' => esc_attr__( 'No', 'dtshop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new DT_WP_Customize_Control_Sortable(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'dt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'dtshop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'savon_shop_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'dtshop' ),
                                'result_count'         => esc_html__( 'Result Count', 'dtshop' ),
                                'pagination'           => esc_html__( 'Pagination', 'dtshop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'dtshop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'dtshop' )
                            )),
                        )
                    ));

        }

    }

}


if( !function_exists('dt_shop_listing_customizer_shop') ) {
	function dt_shop_listing_customizer_shop() {
		return Dt_Shop_Listing_Customizer_Shop::instance();
	}
}

dt_shop_listing_customizer_shop();