<?php
/**
 * Listing Options - Icons Group - Icons
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Option_Thumb_Iconsgroup_Icons' ) ) {

    class Dt_Woo_Listing_Option_Thumb_Iconsgroup_Icons extends Dt_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-iconsgroup-icons';
            $this->option_name          = esc_html__('Icons Group - Icons', 'savon');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'dt_theme_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 20, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_thumb_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'thumb';
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
                'cart'      => esc_html__('Cart', 'savon'),
                'wishlist'  => esc_html__('Wishlist', 'savon'),
                'compare'   => esc_html__('Compare', 'savon'),
                'quickview' => esc_html__('Quick View', 'savon')
            );
            $settings['class']      = 'chosen';
            $settings['attributes'] = array( 'multiple' => 'multiple' );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('dt_woo_listing_option_thumb_iconsgroup_icons') ) {
	function dt_woo_listing_option_thumb_iconsgroup_icons() {
		return Dt_Woo_Listing_Option_Thumb_Iconsgroup_Icons::instance();
	}
}

dt_woo_listing_option_thumb_iconsgroup_icons();