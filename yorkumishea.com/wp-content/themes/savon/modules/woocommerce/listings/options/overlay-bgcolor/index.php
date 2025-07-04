<?php

/**
 * Listing Options - Overlay Bg Color
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Option_Overlay_Bgcolor' ) ) {

    class Dt_Woo_Listing_Option_Overlay_Bgcolor extends Dt_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-overlay-bgcolor';
            $this->option_name          = esc_html__('Overlay - Background Color', 'savon');
            $this->option_type          = array ( 'html', 'key-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-';

            $this->render_backend();

        }

        /*
        Backend Render
        */

            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'dt_theme_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 25, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_custom_product_template_hover_options( $template_options ) {

                array_push( $template_options, $this->setting_args() );

                return $template_options;

            }

        /*
        Setting Group
        */
            function setting_group() {

                return 'hover';

            }

        /*
        Setting Arguments
        */
            function setting_args() {

                $settings            = array ();

                $settings['id']      = $this->option_slug;
                $settings['type']    = 'color_picker';
                $settings['title']   = $this->option_name;
                $settings['default'] = $this->option_default_value;

                return $settings;

            }

    }

}

if( !function_exists('dt_woo_listing_option_overlay_bgcolor') ) {
	function dt_woo_listing_option_overlay_bgcolor() {
		return Dt_Woo_Listing_Option_Overlay_Bgcolor::instance();
	}
}

dt_woo_listing_option_overlay_bgcolor();