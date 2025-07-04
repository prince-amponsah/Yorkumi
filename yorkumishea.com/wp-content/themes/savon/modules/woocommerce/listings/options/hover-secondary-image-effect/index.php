<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Option_Hover_Secondary_Image_Effect' ) ) {

    class Dt_Woo_Listing_Option_Hover_Secondary_Image_Effect extends Dt_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-hover-secondary-image-effect';
            $this->option_name          = esc_html__('Hover Secondary Image Effect', 'savon');
            $this->option_default_value = 'product-hover-secimage-fade';
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_value_prefix  = 'product-hover-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'dt_theme_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
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
                'product-hover-secimage-fade'         => esc_html__('Fade', 'savon'),
                'product-hover-secimage-zoomin'       => esc_html__('Zoom In', 'savon'),
                'product-hover-secimage-zoomout'      => esc_html__('Zoom Out', 'savon'),
                'product-hover-secimage-zoomoutup'    => esc_html__('Zoom Out Up', 'savon'),
                'product-hover-secimage-zoomoutdown'  => esc_html__('Zoom Out Down', 'savon'),
                'product-hover-secimage-zoomoutleft'  => esc_html__('Zoom Out Left', 'savon'),
                'product-hover-secimage-zoomoutright' => esc_html__('Zoom Out Right', 'savon'),
                'product-hover-secimage-pushup'       => esc_html__('Push Up', 'savon'),
                'product-hover-secimage-pushdown'     => esc_html__('Push Down', 'savon'),
                'product-hover-secimage-pushleft'     => esc_html__('Push Left', 'savon'),
                'product-hover-secimage-pushright'    => esc_html__('Push Right', 'savon'),
                'product-hover-secimage-slideup'      => esc_html__('Slide Up', 'savon'),
                'product-hover-secimage-slidedown'    => esc_html__('Slide Down', 'savon'),
                'product-hover-secimage-slideleft'    => esc_html__('Slide Left', 'savon'),
                'product-hover-secimage-slideright'   => esc_html__('Slide Right', 'savon'),
                'product-hover-secimage-hingeup'      => esc_html__('Hinge Up', 'savon'),
                'product-hover-secimage-hingedown'    => esc_html__('Hinge Down', 'savon'),
                'product-hover-secimage-hingeleft'    => esc_html__('Hinge Left', 'savon'),
                'product-hover-secimage-hingeright'   => esc_html__('Hinge Right', 'savon'),
                'product-hover-secimage-foldup'       => esc_html__('Fold Up', 'savon'),
                'product-hover-secimage-folddown'     => esc_html__('Fold Down', 'savon'),
                'product-hover-secimage-foldleft'     => esc_html__('Fold Left', 'savon'),
                'product-hover-secimage-foldright'    => esc_html__('Fold Right', 'savon'),
                'product-hover-secimage-fliphoriz'    => esc_html__('Flip Horizontal', 'savon'),
                'product-hover-secimage-flipvert'     => esc_html__('Flip Vertical', 'savon')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('dt_woo_listing_option_hover_secondary_image_effect') ) {
	function dt_woo_listing_option_hover_secondary_image_effect() {
		return Dt_Woo_Listing_Option_Hover_Secondary_Image_Effect::instance();
	}
}

dt_woo_listing_option_hover_secondary_image_effect();