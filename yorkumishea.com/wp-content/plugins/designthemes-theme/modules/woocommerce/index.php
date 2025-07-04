<?php

/**
 * WooCommerce
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_WooCommerce' ) ) {

    class Dt_Theme_WooCommerce {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {
            add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
        }

        /*
        Plugins Loaded
        */
            function plugins_loaded() {

                if ( !class_exists( 'WooCommerce' ) ) {
                    return;
                }

                /* Load Modules */
                    $this->load_modules();

                /* Override WooCommerce default template files */
                    add_filter( 'woocommerce_locate_template',  array( $this, 'woocommerce_locate_template' ), 20, 3 );

                /* Locate File */
                    add_filter( 'savon_woo_locate_file', array( $this, 'woo_locate_file'), 1, 2 );

            }

        /*
        Load Modules
        */
            function load_modules() {

                /* Elementor */
                    require_once DT_THEME_DIR_PATH . 'modules/woocommerce/elementor/index.php';

                /* Customizer */
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/customizer/index.php';

                /* Load Listing Helpers */
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/listings/index.php';

                /* Template Pages */
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/shop/index.php';
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/category/index.php';
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/tag/index.php';

                /* Single Page */
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/single/index.php';

                /* Others */
                    include_once DT_THEME_DIR_PATH . 'modules/woocommerce/others/index.php';

            }

        /**
         * Override WooCommerce default template files
         */
            function woocommerce_locate_template( $template, $template_name, $template_path ) {

                global $woocommerce;

                $_template = $template;

                if ( ! $template_path ) $template_path = $woocommerce->template_url;

                $plugin_path  = DT_THEME_DIR_PATH . 'modules/woocommerce/templates/';

                // Look within passed path within the theme - this is priority
                $template = locate_template(
                    array(
                        $template_path . $template_name,
                        $template_name
                    )
                );

                // Modification: Get the template from this plugin, if it exists
                if ( ! $template && file_exists( $plugin_path . $template_name ) )
                $template = $plugin_path . $template_name;

                // Use default template
                if ( ! $template )
                $template = $_template;

                // Return what we found
                return $template;

            }

        /*
        Locate File
        */
            function woo_locate_file( $file_path, $module ) {

                $plugin_file_path = apply_filters( 'dt_theme_woo_locate_file', '', $module);

                if( $plugin_file_path ) {
                    $file_path = $plugin_file_path;
                } else {
                    $file_path = DT_THEME_DIR_PATH . 'modules/woocommerce/' . $module .'.php';
                }

                $located_file_path = false;
                if ( $file_path && file_exists( $file_path ) ) {
                    $located_file_path = $file_path;
                }

                return $located_file_path;

            }

    }

}

if( !function_exists('dt_theme_woocommerce') ) {
	function dt_theme_woocommerce() {
        return Dt_Theme_WooCommerce::instance();
	}
}

dt_theme_woocommerce();

