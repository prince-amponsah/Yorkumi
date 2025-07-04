<?php

/**
 * WooCommerce - Single - Module - Upsell & Related - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Upsell_Related' ) ) {

    class Dt_Shop_Customizer_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function register( $wp_customize ) {

            /**************
             *  Upsell
             **************/

                /**
                * Option : Show Upsell Products
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-upsell-display]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-upsell-display]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Upsell Products', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-upsell-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Upsell Title
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-upsell-title]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        DT_CUSTOMISER_VAL . '[dt-single-product-upsell-title]', array(
                            'type'       => 'text',
                            'section'    => 'woocommerce-single-page-upsell-section',
                            'label'      => esc_html__( 'Upsell Title', 'designthemes-theme' )
                        )
                    );

                /**
                 * Option : Upsell Column
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-upsell-column]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-upsell-column]', array(
                            'type' => 'dt-radio-image',
                            'label' => esc_html__( 'Upsell Column', 'designthemes-theme'),
                            'section' => 'woocommerce-single-page-upsell-section',
                            'choices' => apply_filters( 'savon_woo_upsell_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));


                /**
                * Option : Upsell Limit
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-upsell-limit]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-upsell-limit]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Upsell Limit', 'designthemes-theme'),
                                'section'  => 'woocommerce-single-page-upsell-section',
                                'choices'  => array (
                                    1 => esc_html__( '1', 'designthemes-theme' ),
                                    2 => esc_html__( '2', 'designthemes-theme' ),
                                    3 => esc_html__( '3', 'designthemes-theme' ),
                                    4 => esc_html__( '4', 'designthemes-theme' ),
                                    5 => esc_html__( '5', 'designthemes-theme' ),
                                    6 => esc_html__( '6', 'designthemes-theme' ),
                                    7 => esc_html__( '7', 'designthemes-theme' ),
                                    8 => esc_html__( '8', 'designthemes-theme' ),
                                    9 => esc_html__( '9', 'designthemes-theme' ),
                                    10 => esc_html__( '10', 'designthemes-theme' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-upsell-style-template]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-upsell-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'designthemes-theme'),
                                'section'  => 'woocommerce-single-page-upsell-section',
                                'choices'  => dt_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );


            /**************
             *  Related
             **************/

                /**
                * Option : Show Related Products
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-related-display]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-related-display]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Related Products', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-related-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Related Title
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-related-title]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        DT_CUSTOMISER_VAL . '[dt-single-product-related-title]', array(
                            'type'       => 'text',
                            'section'    => 'woocommerce-single-page-related-section',
                            'label'      => esc_html__( 'Related Title', 'designthemes-theme' )
                        )
                    );

                /**
                 * Option : Related Column
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-related-column]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-related-column]', array(
                            'type' => 'dt-radio-image',
                            'label' => esc_html__( 'Related Column', 'designthemes-theme'),
                            'section' => 'woocommerce-single-page-related-section',
                            'choices' => apply_filters( 'savon_woo_related_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'designthemes-theme' ),
                                    'path' => dt_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));


                /**
                * Option : Related Limit
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-related-limit]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-related-limit]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Related Limit', 'designthemes-theme'),
                                'section'  => 'woocommerce-single-page-related-section',
                                'choices'  => array (
                                    1 => esc_html__( '1', 'designthemes-theme' ),
                                    2 => esc_html__( '2', 'designthemes-theme' ),
                                    3 => esc_html__( '3', 'designthemes-theme' ),
                                    4 => esc_html__( '4', 'designthemes-theme' ),
                                    5 => esc_html__( '5', 'designthemes-theme' ),
                                    6 => esc_html__( '6', 'designthemes-theme' ),
                                    7 => esc_html__( '7', 'designthemes-theme' ),
                                    8 => esc_html__( '8', 'designthemes-theme' ),
                                    9 => esc_html__( '9', 'designthemes-theme' ),
                                    10 => esc_html__( '10', 'designthemes-theme' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-related-style-template]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-related-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'designthemes-theme'),
                                'section'  => 'woocommerce-single-page-related-section',
                                'choices'  => dt_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );


        }

    }

}


if( !function_exists('dt_shop_customizer_single_upsell_related') ) {
	function dt_shop_customizer_single_upsell_related() {
		return Dt_Shop_Customizer_Single_Upsell_Related::instance();
	}
}

dt_shop_customizer_single_upsell_related();