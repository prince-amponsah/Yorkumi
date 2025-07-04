<?php

/**
 * WooCommerce - Wishlist Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Others_Wishlist' ) ) {

    class Dt_Shop_Others_Wishlist {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Wishlist Template File
                add_filter( 'yith_wcwl_locate_template',  array( $this, 'yith_wcwl_locate_template' ), 10, 2 );

            // Wishlist Page Options
                add_filter( 'yith_wcwl_wishlist_page_options', array( $this, 'yith_wcwl_wishlist_page_options' ) );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/others/wishlist/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/others/wishlist/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Override Wishlist default template files
         */
            function yith_wcwl_locate_template( $template_path, $template_name ) {

                $plugin_path = $this->module_dir_path() . 'templates/'.$template_name;

                if( file_exists( $plugin_path ) ){
                    return $plugin_path;
                }

                return $template_path;

            }

        /**
         * Override Wishlist settings
         */
            function yith_wcwl_wishlist_page_options( $settings ) {

                $wishlist_page = $settings['wishlist_page'];

                unset( $wishlist_page['style_section_start'] );

                    unset( $wishlist_page['use_buttons'] );
                    unset( $wishlist_page['add_to_cart_colors'] );
                    unset( $wishlist_page['rounded_buttons_radius'] );
                    unset( $wishlist_page['add_to_cart_icon'] );
                    unset( $wishlist_page['add_to_cart_custom_icon'] );
                    unset( $wishlist_page['style_1_button_colors'] );
                    unset( $wishlist_page['style_2_button_colors'] );
                    unset( $wishlist_page['wishlist_table_style'] );
                    unset( $wishlist_page['headings_style'] );
                    unset( $wishlist_page['share_colors'] );

                    unset( $wishlist_page['fb_button_icon'] );
                    unset( $wishlist_page['fb_button_custom_icon'] );
                    unset( $wishlist_page['fb_button_colors'] );

                    unset( $wishlist_page['tw_button_icon'] );
                    unset( $wishlist_page['tw_button_custom_icon'] );
                    unset( $wishlist_page['tw_button_colors'] );

                    unset( $wishlist_page['pr_button_icon'] );
                    unset( $wishlist_page['pr_button_custom_icon'] );
                    unset( $wishlist_page['pr_button_colors'] );

                    unset( $wishlist_page['em_button_icon'] );
                    unset( $wishlist_page['em_button_custom_icon'] );
                    unset( $wishlist_page['em_button_colors'] );

                    unset( $wishlist_page['wa_button_icon'] );
                    unset( $wishlist_page['wa_button_custom_icon'] );
                    unset( $wishlist_page['wa_button_colors'] );

                unset( $wishlist_page['style_section_end'] );


                $settings = array( 'wishlist_page' => $wishlist_page );

                return $settings;
            }


    }

}

if( !function_exists('dtshop_others_wishlist') ) {
	function dtshop_others_wishlist() {
        $reflection = new ReflectionClass('Dt_Shop_Others_Wishlist');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Shop_Others_Wishlist::instance();