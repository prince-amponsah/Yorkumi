<?php

/**
 * Listings - Category
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Category' ) ) {

    class Dt_Woo_Listing_Category {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

            /* On Template Load */
                add_action( 'template_redirect', array ( $this, 'woo_template_redirect' ), 20 );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/category/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/category/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
        function load_modules() {

            // Includes
                include_once $this->module_dir_path(). 'includes/index.php';

        }

        /*
        On Template Load
        */
        function woo_template_redirect() {

            if( is_product_category() ) {

                /* Load Default Values */
                    $this->woo_default_settings();

                /* Define Sorter Settings */
                    add_filter( 'savon_woo_sorter_settings', array( $this, 'woo_sorter_settings' ) );

                /* Load Listings */
                    $this->woo_load_listing();

            }

        }

        /*
        Load Default Values
        */
            function woo_default_settings() {

                $this->settings = array (

                    'product_style_template'        => 'predefined',
                    'product_style_custom_template' => 'default',
                    'product_per_page'              => 12,
                    'product_layout'                => 4,
                    'enable_breadcrumb'             => '0',
                    'bottom_hook'                   => '',

                    'show_sorter_on_header'         => '0',
                    'sorter_header_elements'        => array (
                        'display_mode',
                        'display_mode_options'
                    ),
                    'show_sorter_on_footer'         => '0',
                    'sorter_footer_elements'        => array (
                        'pagination',
                        'filter'
                    )

                );

                $this->settings = apply_filters( 'savon_woo_category_page_default_settings', $this->settings );

                return $this->settings;

            }

        /*
        Define Sorter Settings
        */
            function woo_sorter_settings( $settings ) {

                $settings['show_sorter_on_header']  = $this->settings['show_sorter_on_header'];
                $settings['sorter_header_elements'] = $this->settings['sorter_header_elements'];
                $settings['show_sorter_on_footer']  = $this->settings['show_sorter_on_footer'];
                $settings['sorter_footer_elements'] = $this->settings['sorter_footer_elements'];

                return $settings;

            }

        /*
        Listings Loop Prop
        */
            function woo_listings_common_loop_prop() {

                wc_set_loop_prop( 'columns', $this->settings['product_layout']);

            }

        /*
        Load Listings
        */
            function woo_load_listing() {

                $this->woo_listings_common_loop_prop(); /* Listings Loop Prop */

                $type_options = array ();

                if( $this->settings['product_style_template'] == 'predefined' ) {
                    $type_class_instance = 'dt_woo_listing_type_'.$this->settings['product_style_custom_template']; // Type Class Instance
                } else if( $this->settings['product_style_template'] == 'custom' ) {
                    $type_class_instance = 'dt_woo_listing_type_custom'; // Type Class Instance
                }

                if ( function_exists( $type_class_instance ) ) {

                    if( $this->settings['product_style_template'] == 'custom' ) {
                        $type_class_instance()->custom_template = $this->settings['product_style_custom_template'];
                    }

                    $type_options = $type_class_instance()->set_type_options();

                    if( is_array ( $type_options ) && !empty ( $type_options ) ) {
                        foreach ( $type_options as $type_option_key => $type_option ) {

                            $type_option_key = str_replace( 'product-', '', $type_option_key);
                            $type_option_key = str_replace( '-', '_', $type_option_key);
                            $option_class_instance = 'dt_woo_listing_option_'.$type_option_key;  // Option Class Instance

                            if ( function_exists( $option_class_instance ) ) {

                                $option_class_instance()->option_default_value = $type_option;
                                $option_class_instance()->render_frontend();
                                $option_class_instance()->woo_listings_loop_prop();

                            }

                        }
                    }

                    $type_class_instance()->render_frontend();

                }

            }

    }

}


if( !function_exists('dt_woo_listing_category') ) {
	function dt_woo_listing_category() {
		return Dt_Woo_Listing_Category::instance();
	}
}

dt_woo_listing_category();