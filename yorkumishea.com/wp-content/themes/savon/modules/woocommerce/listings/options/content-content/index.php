<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Option_Content_Content' ) ) {

    class Dt_Woo_Listing_Option_Content_Content extends Dt_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            $this->option_slug          = 'product-content-content';
            $this->option_name          = esc_html__('Content Elements', 'savon');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'dt_theme_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 10, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_content_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'content';
        }

        /**
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled'            => array(
                    'title'          => esc_html__('Title', 'savon'),
                    'category'       => esc_html__('Category', 'savon'),
                    'price'          => esc_html__('Price', 'savon'),
                    'button_element' => esc_html__('Button Element', 'savon'),
                    'icons_group'    => esc_html__('Icons Group', 'savon'),
                ),
                'disabled'         => array(
                    'excerpt'       => esc_html__('Excerpt', 'savon'),
                    'rating'        => esc_html__('Rating', 'savon'),
                    'countdown'     => esc_html__('Count Down', 'savon'),
                    'separator'     => esc_html__('Separator', 'savon'),
                    'element_group' => esc_html__('Element Group', 'savon'),
                    'swatches'      => esc_html__('Swatches', 'savon'),
                    'product_notes' => esc_html__('Product Notes', 'savon')
                ),
            );



            return $settings;
        }
    }

}

if( !function_exists('dt_woo_listing_option_content_content') ) {
	function dt_woo_listing_option_content_content() {
		return Dt_Woo_Listing_Option_Content_Content::instance();
	}
}

dt_woo_listing_option_content_content();