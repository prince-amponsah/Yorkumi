<?php

/**
 * Listing Types - Type 1
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Type_Type1' ) ) {

    class Dt_Woo_Listing_Type_Type1 {

        private static $_instance = null;

        private $type_slug;

        private $type_name;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Initialize Type */
                $this->type_slug = 'type1';
                $this->type_name = esc_html__('Type 1', 'savon');

            /* Backend Render */
                $this->render_backend();

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
        Backend Render
        */
            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'dt_theme_woo_default_product_templates', array( $this, 'woo_default_product_templates'), 10, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_default_product_templates( $templates ) {

                $type_options = array_merge (
                    array( 'product-template-id' => $this->type_name ),
                    $this->set_type_options()
                );

                $default_template = array (
                    'id'              => 'dt-woo-product-style-template-'.$this->type_slug,
                    'type'            => 'group',
                    'dt_default_type' => true,
                    'title'           => sprintf( esc_html__( 'Product Templates - %1$s', 'savon' ), $this->type_name ),
                    'button_title'    => esc_html__('Add New', 'savon'),
                    'accordion_title' => esc_html__('Add New Template', 'savon'),
                    'fields'          => dt_woo_listing_fw_template_settings()->woo_get_options_params( $type_options, 'default' ),
                    'default'         => array ( 0 => $type_options )
                );

                array_push( $templates, $default_template );

                return $templates;

            }

        /*
        Set Type Options
        */
            function set_type_options() {

                $type_options = array ();

                $type_options['product-display-type'] = 'grid';
                $type_options['product-display-type-list-option'] = 'left-thumb';

                $type_options['product-style']                        = 'product-style-title-eg-highlighter';
                $type_options['product-hover-style']                  = 'product-hover-fade-skinborder';
                $type_options['product-hover-secondary-image-effect'] = 'product-hover-secimage-pushleft';
                $type_options['product-content-hover-effect']         = 'product-content-hover-slideright';
                $type_options['product-thumb-content']          = array (
                    'enabled'      => array (
                        'title'          => esc_html__('Title', 'savon'),
                        'category'       => esc_html__('Category', 'savon'),
                        'price'          => esc_html__('Price', 'savon')
                    ),
                    'disabled'     => array (
                        'button_element' => esc_html__('Button Element', 'savon'),
                        'icons_group'    => esc_html__('Icons Group', 'savon'),
                        'excerpt'        => esc_html__('Excerpt', 'savon'),
                        'rating'         => esc_html__('Rating', 'savon'),
                        'countdown'      => esc_html__('Count Down', 'savon'),
                        'separator'      => esc_html__('Separator', 'savon'),
                        'element_group'  => esc_html__('Element Group', 'savon'),
                        'swatches'       => esc_html__('Swatches', 'savon')
                    )
                );

                $type_options['product-content-enable']         = '1';
                $type_options['product-content-content']        = array (
                    'enabled'      => array(
                        'title'          => esc_html__('Title', 'savon'),
                        'price'          => esc_html__('Price', 'savon')
                    ),
                    'disabled'     => array(
                        'category'       => esc_html__('Category', 'savon'),
                        'button_element' => esc_html__('Button Element', 'savon'),
                        'icons_group'    => esc_html__('Icons Group', 'savon'),
                        'excerpt'        => esc_html__('Excerpt', 'savon'),
                        'rating'         => esc_html__('Rating', 'savon'),
                        'countdown'      => esc_html__('Count Down', 'savon'),
                        'separator'      => esc_html__('Separator', 'savon'),
                        'element_group'  => esc_html__('Element Group', 'savon'),
                        'swatches'       => esc_html__('Swatches', 'savon'),
                        'product_notes'  => esc_html__('Product Notes', 'savon')
                    )
                );
                $type_options['product-content-element-group']  = array (
                    'enabled'      => array(
                        'cart'           => esc_html__('Cart', 'savon'),
                        'category'       => esc_html__('Category', 'savon')
                    ),
                    'disabled'     => array(
                        'title'          => esc_html__('Title', 'savon'),
                        'price'          => esc_html__('Price', 'savon'),
                        'wishlist'       => esc_html__('Wishlist', 'savon'),
                        'compare'        => esc_html__('Compare', 'savon'),
                        'quickview'      => esc_html__('Quick View', 'savon'),
                        'button_element' => esc_html__('Button Element', 'savon'),
                        'icons_group'    => esc_html__('Icons Group', 'savon'),
                        'excerpt'        => esc_html__('Excerpt', 'savon'),
                        'rating'         => esc_html__('Rating', 'savon'),
                        'separator'      => esc_html__('Separator', 'savon'),
                        'swatches'       => esc_html__('Swatches', 'savon')
                    )
                );
                $type_options['product-display-type'] = 'list';

                return $type_options;


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

                        wp_register_style( 'savon-woo-non-archive', '', array (), SAVON_THEME_VERSION, 'all' );
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

if( !function_exists('dt_woo_listing_type_type1') ) {
	function dt_woo_listing_type_type1() {
		return Dt_Woo_Listing_Type_Type1::instance();
	}
}

dt_woo_listing_type_type1();