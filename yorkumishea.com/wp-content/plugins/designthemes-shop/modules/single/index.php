<?php

/**
 * WooCommerce - Single Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Single' ) ) {

    class Dt_Shop_Single {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load WooCommerce Comments Template
                add_filter( 'comments_template',  array( $this, 'dtshop_comments_template' ), 20, 1 );

            // Load Modules
                $this->load_modules();

        }

        /**
         * Override WooCommerce comments template file
         */
            function dtshop_comments_template( $template ) {

                if ( get_post_type() !== 'product' ) {
                    return $template;
                }

                $plugin_path  = DTSHOP_PLUGIN_PATH . 'templates/';

                if ( file_exists( $plugin_path . 'single-product-reviews.php' ) ) {
                    return $plugin_path . 'single-product-reviews.php';
                }

                return $template;

            }

        /*
        Load Modules
        */

            function load_modules() {

                // Sidebar Widgets
                    include_once DTSHOP_PLUGIN_PATH . 'modules/single/sidebar/index.php';

                // Customizer Widgets
                    include_once DTSHOP_PLUGIN_PATH . 'modules/single/customizer/index.php';

                // Metabox Widgets
                    include_once DTSHOP_PLUGIN_PATH . 'modules/single/metabox/index.php';

            }

    }

}

if( !function_exists('dt_shop_single') ) {
	function dt_shop_single() {
		return Dt_Shop_Single::instance();
	}
}

dt_shop_single();