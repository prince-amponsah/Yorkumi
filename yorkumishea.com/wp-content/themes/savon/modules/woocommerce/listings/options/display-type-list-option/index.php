<?php
/**
 * Listing Options - Display Type - List Option
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Option_Display_Type_List_Option' ) ) {

    class Dt_Woo_Listing_Option_Display_Type_List_Option extends Dt_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-display-type-list-option';
            $this->option_name          = esc_html__('List Option', 'savon');
            $this->option_type          = array ( 'html', 'key-css' );
            $this->option_default_value = 'left-thumb';
            $this->option_value_prefix  = 'product-display-type-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'dt_theme_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 10, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_common_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'common';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'left-thumb'  => esc_html__('Left Thumb', 'savon'),
                'right-thumb' => esc_html__('Right Thumb', 'savon'),
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }

    }

}

if( !function_exists('dt_woo_listing_option_display_type_list_option') ) {
	function dt_woo_listing_option_display_type_list_option() {
		return Dt_Woo_Listing_Option_Display_Type_List_Option::instance();
	}
}

dt_woo_listing_option_display_type_list_option();