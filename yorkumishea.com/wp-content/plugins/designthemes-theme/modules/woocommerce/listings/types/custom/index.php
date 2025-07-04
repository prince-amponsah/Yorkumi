<?php

/**
 * Listing Types - Custom
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Type_Custom' ) ) {

    class Dt_Woo_Listing_Type_Custom {

        private static $_instance = null;

        private $type_slug;

        private $type_name;

        public $custom_template;

        private $custom_template_id;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Initialize Type */
                $this->type_slug = 'custom';
                $this->type_name = esc_html__('Custom', 'designthemes-theme');

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/listings/types/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/listings/types/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Set Type Options
        */
            function set_type_options() {

                $dtcs_product_templates = get_option( CS_OPTION );

                $custom_options = array ();

                if( strpos($this->custom_template, 'predefined-template-') !== false ) {

                    $field_key = str_replace('predefined-template-', 'dt-woo-product-style-template-',  $this->custom_template);
                    $custom_options = ( isset($dtcs_product_templates[$field_key][0]) && !empty($dtcs_product_templates[$field_key][0]) ) ? $dtcs_product_templates[$field_key][0] : array ();

                } else if( strpos($this->custom_template, 'custom-template-') !== false ) {

                    $field_key = str_replace('custom-template-', '',  $this->custom_template);
                    $custom_options = ( isset($dtcs_product_templates['dt-woo-product-style-templates'][$field_key]) && !empty($dtcs_product_templates['dt-woo-product-style-templates'][$field_key]) ) ? $dtcs_product_templates['dt-woo-product-style-templates'][$field_key] : array ();

                }

                if( !empty($custom_options) ) {

                    // CSS

                        /* Overlay Dark Bg Color */

                            if(isset($custom_options['product-overlay-dark-bgcolor']) && !empty($custom_options['product-overlay-dark-bgcolor'])) {
                                $custom_options['product-overlay-dark-bgcolor'] = 'product-overlay-dark-bgcolor';
                            }

                        /* Background Dark Bg Color */

                            if(isset($custom_options['product-background-dark-bgcolor']) && !empty($custom_options['product-background-dark-bgcolor'])) {
                                $custom_options['product-background-dark-bgcolor'] = 'product-background-dark-bgcolor';
                            }

                        /* "Product Style" Common Options */

                            // Product Style - Bordered
                            if(isset($custom_options['product-borderorshadow']) && $custom_options['product-borderorshadow'] == 'product-borderorshadow-shadow') {

                                // Unset Border Type
                                    unset($custom_options['product-border-type']);

                                // Unset Border Position
                                    unset($custom_options['product-border-position']);

                            } else if(isset($custom_options['product-borderorshadow']) && $custom_options['product-borderorshadow'] == 'product-borderorshadow-border') {

                                // Unset Shadow Type
                                    unset($custom_options['product-shadow-type']);

                                // Unset Shadow Position
                                    unset($custom_options['product-shadow-position']);

                            } else if(isset($custom_options['product-borderorshadow']) && $custom_options['product-borderorshadow'] == '') {

                                // Unset Border Type
                                    unset($custom_options['product-border-type']);

                                // Unset Border Position
                                    unset($custom_options['product-border-position']);

                                // Unset Shadow Type
                                    unset($custom_options['product-shadow-type']);

                                // Unset Shadow Position
                                    unset($custom_options['product-shadow-position']);

                            }

                        /* "Product Style - Content" Options */

                            if(!isset($custom_options['product-content-enable']) || empty($custom_options['product-content-enable'])) {

                                // Unset Content Enable
                                    unset($custom_options['product-content-enable']);

                                // Unset Alignment
                                    unset($custom_options['product-content-alignment']);

                                // Unset Icons Group - Style
                                    unset($custom_options['product-content-iconsgroup-style']);

                                // Unset Button Element - Style
                                    unset($custom_options['product-content-buttonelement-style']);

                                // Unset Button Element - Stretch
                                    unset($custom_options['product-content-buttonelement-stretch']);

                            }

                    // HTML

                        $non_archive_listing = wc_get_loop_prop('non_archive_listing');

                        /* "Product Style "Common Options */

                            // Display Mode
                            //if($non_archive_listing) {
                                //unset($custom_options['product-display-type']);
                            //}

                            // Display Mode - List Options
                            //if(!$non_archive_listing) {
                                //unset($custom_options['product-display-type-list-option']);
                            //}


                        /* "Product Style - Content" Options */

                            if(!isset($custom_options['product-content-enable']) || empty($custom_options['product-content-enable'])) {

                                // Unset Content Enable
                                    unset($custom_options['product-content-enable']);

                                // Unset Content
                                    unset($custom_options['product-content-content']);

                                // Unset Button Element - Button
                                    unset($custom_options['product-content-buttonelement-button']);

                                // Unset Button Element - Secondary Button
                                    unset($custom_options['product-content-buttonelement-secondary-button']);

                                // Unset Icons Group - Icons
                                    unset($custom_options['product-content-iconsgroup-icons']);

                                // Unset Element Group Content
                                    unset($custom_options['product-content-element-group']);

                            }

                }

                return $custom_options;

            }

        /*
        Frontend Render
        */
            function render_frontend() {

                $non_archive_listing = wc_get_loop_prop('non_archive_listing');

                if( $non_archive_listing ) {

                    /* Types CSS */
                        add_filter( 'savon_woo_non_archive_css', array( $this, 'woo_listings_css_load'), 10, 1 );

                } else {

                    /* Types CSS */
                        add_filter( 'savon_woo_archive_css', array( $this, 'woo_listings_css_load'), 10, 1 );

                }

            }

        /*
        Types CSS
        */
            function woo_listings_css_load( $css ) {

                $css .= $this->load_type_css();
                $css .= $this->load_type_skin_css();

                return $css;

            }

            // Type Main CSS
            function load_type_css() {

                $css = '';

                $css_file_path = $this->module_dir_path() . 'assets/css/'.$this->type_slug.'.css';

                if( file_exists ( $css_file_path ) ) {

                    ob_start();
                    include( $css_file_path );
                    $css .= "\n\n".ob_get_clean();

                }

                return $css;

            }

            // Type Skin CSS
            function load_type_skin_css() {

                $css = '';
                return $css;

            }

        /*
        For Non Archive Listing
        */
            function for_non_archive_listing() {

                /* Load Other Modules */

                    $sub_modules = array (
                        'includes' => 'listings/includes/index'
                    );

                    if( is_array( $sub_modules ) && !empty( $sub_modules ) ) {
                        foreach( $sub_modules as $sub_module ) {

                            if( $file_content = savon_woo_locate_file( $sub_module ) ) {
                                include_once $file_content;
                            }

                        }
                    }


                /* Assets Load */

                    // CSS

                        wp_register_style( 'savon-woo-non-archive', '', array (), DT_THEME_VERSION, 'all' );
                        wp_enqueue_style( 'savon-woo-non-archive' );

                        $css = '';

                        // Load common styles
                        if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {
                            $css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/common.css';

                            if( file_exists ( $css_file_path ) ) {

                                ob_start();
                                include( $css_file_path );
                                $css .= "\n\n".ob_get_clean();

                            }
                        }

                        $css = apply_filters( 'savon_woo_non_archive_css', $css );

                        if( !empty($css) ) {
                            wp_add_inline_style( 'savon-woo-non-archive', $css );
                        }

                    // JS

                        wp_register_script( 'savon-woo-non-archive', '', array ('jquery'), false, true );
                        wp_enqueue_script( 'savon-woo-non-archive' );

                        $js = '';

                        // Load common js
                        if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {
                            $js_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/js/common.js';

                            if( file_exists ( $js_file_path ) ) {

                                ob_start();
                                include( $js_file_path );
                                $js .= "\n\n".ob_get_clean();

                            }
                        }

                        $js = apply_filters( 'savon_woo_non_archive_js', $js );

                        if( !empty($js) ) {
                            wp_add_inline_script( 'savon-woo-non-archive', $js );
                        }

            }

    }

}

if( !function_exists('dt_woo_listing_type_custom') ) {
	function dt_woo_listing_type_custom() {
		return Dt_Woo_Listing_Type_Custom::instance();
	}
}

dt_woo_listing_type_custom();