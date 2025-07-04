<?php

/**
 * Listing Customizer - Category Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Listing_Customizer_Category' ) ) {

    class Dt_Theme_Listing_Customizer_Category {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_filter( 'savon_woo_category_page_default_settings', array( $this, 'category_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function default( $option ) {

            $settings = dt_woo_listing_category()->woo_default_settings();
            extract($settings);

            if( $product_style_template == 'predefined' ) {
                $option['dt-woo-category-page-product-style-template'] = 'predefined-template-'.$product_style_custom_template;
            } else {
                $option['dt-woo-category-page-product-style-template'] = $product_style_custom_template;
            }

            $option['dt-woo-category-page-product-per-page']  = $product_per_page;
            $option['dt-woo-category-page-product-layout']    = $product_layout;
            $option['dt-woo-category-page-enable-breadcrumb'] = $enable_breadcrumb;

            // Default Values from Shop Plugin
            $option['dt-woo-category-page-bottom-hook']            = $bottom_hook;
            $option['dt-woo-category-page-show-sorter-on-header']  = $show_sorter_on_header;
            $option['dt-woo-category-page-sorter-header-elements'] = $sorter_header_elements;
            $option['dt-woo-category-page-show-sorter-on-footer']  = $show_sorter_on_footer;
            $option['dt-woo-category-page-sorter-footer-elements'] = $sorter_footer_elements;

            return $option;

        }

        function category_page_default_settings( $settings ) {

            $product_style_custom_template = dt_customizer_settings('dt-woo-category-page-product-style-template' );
            if( isset($product_style_custom_template) && !empty($product_style_custom_template) ) {
                $settings['product_style_template']        = 'custom';
                $settings['product_style_custom_template'] = $product_style_custom_template;
            }

            $product_per_page              = dt_customizer_settings('dt-woo-category-page-product-per-page' );
            $settings['product_per_page']  = $product_per_page;

            $product_layout                = dt_customizer_settings('dt-woo-category-page-product-layout' );
            $settings['product_layout']    = $product_layout;

            $enable_breadcrumb             = dt_customizer_settings('dt-woo-category-page-enable-breadcrumb' );
            $settings['enable_breadcrumb'] = $enable_breadcrumb;

            return $settings;

        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'woocommerce-category-page-section',
                    array(
                        'title'    => esc_html__('Category Page', 'designthemes-theme'),
                        'panel'    => 'woocommerce-main-section',
                        'priority' => 20,
                    )
                )
            );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-category-page-product-style-template]', array(
                            'type'              => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-category-page-product-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'designthemes-theme'),
                                'section'  => 'woocommerce-category-page-section',
                                'choices'  => dt_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );

                /**
                 * Option : Products Per Page
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-category-page-product-per-page]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-category-page-product-per-page]', array(
                                'type'        => 'number',
                                'label'       => esc_html__( 'Products Per Page', 'designthemes-theme' ),
                                'section'     => 'woocommerce-category-page-section'
                            )
                        )
                    );


                /**
                 * Option : Product Layout
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-category-page-product-layout]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                        $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-category-page-product-layout]', array(
                            'type' => 'dt-radio-image',
                            'label' => esc_html__( 'Columns', 'designthemes-theme'),
                            'section' => 'woocommerce-category-page-section',
                            'choices' => apply_filters( 'savon_woo_category_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'designthemes-theme' ),
                                    'path' => DT_THEME_DIR_URL . 'modules/woocommerce/category/customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'designthemes-theme' ),
                                    'path' => DT_THEME_DIR_URL . 'modules/woocommerce/category/customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'designthemes-theme' ),
                                    'path' => DT_THEME_DIR_URL . 'modules/woocommerce/category/customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'designthemes-theme' ),
                                    'path' => DT_THEME_DIR_URL . 'modules/woocommerce/category/customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));

                /**
                 * Option : Enable Breadcrumb
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-woo-category-page-enable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-woo-category-page-enable-breadcrumb]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Enable Breadcrumb', 'designthemes-theme'),
                                'section' => 'woocommerce-category-page-section',
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


if( !function_exists('dt_theme_listing_customizer_category') ) {
	function dt_theme_listing_customizer_category() {
		return Dt_Theme_Listing_Customizer_Category::instance();
	}
}

dt_theme_listing_customizer_category();