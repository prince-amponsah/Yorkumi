<?php

/**
 * WooCommerce - Single - Module - Sticky Cart
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Single_Module_Sticky_Cart' ) ) {

    class Dt_Shop_Single_Module_Sticky_Cart {

        private static $_instance = null;

        private $product_addtocart_sticky;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Enable Sticky Cart
                $settings = dt_woo_single_core()->woo_default_settings();
                extract($settings);
                $this->product_addtocart_sticky = $product_addtocart_sticky;

            // Sticky Cart HTML
                add_action( 'wp_footer', array ( $this, 'woo_sticky_cart_html' ), 11 );

            // CSS
                add_filter( 'savon_woo_css', array( $this, 'woo_css'), 10, 1 );

            // JS
                add_filter( 'savon_woo_js', array( $this, 'woo_js'), 10, 1 );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/single/modules/sticky-cart/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/single/modules/sticky-cart/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'dt_theme' ) ) {

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                    }

            }

        /*
        Sticky Cart HTML
        */

            function woo_sticky_cart_html() {

                if ( ! is_product() || !$this->product_addtocart_sticky ) {
                    return;
                }

                global $product;

                echo '<div class="dt-sc-shop-single-sticky-addtocart-container">';
                    echo '<div class="container">';
                        echo '<div class="dt-sc-shop-single-sticky-addtocart-content">';
                            echo '<div class="dt-sc-shop-single-sticky-addtocart-thumbnail">';
                                echo woocommerce_get_product_thumbnail();
                            echo '</div>';
                            echo '<div class="dt-sc-shop-single-sticky-addtocart-info">';
                                echo '<h3>'.savon_html_output($product->get_name()).'</h3>';
                                echo wc_get_rating_html( $product->get_average_rating() );
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="dt-sc-shop-single-sticky-addtocart-section">';
                            echo '<span class="dt-sc-shop-single-sticky-addtocart-price">'.savon_html_output($product->get_price_html()).'</span>';
                            if(savon_check_item_is_in_cart( $product->get_id() )) {
                                echo '<span class="dt-sc-shop-single-sticky-addtocart-added">'.esc_html__('Product Added To Cart', 'designthemes-theme').'</span>';
                            } else {
                                woocommerce_template_loop_add_to_cart();
                            }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

            }

        /*
        CSS
        */
            function woo_css( $css ) {

                if($this->product_addtocart_sticky) {

                    $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                    if( file_exists ( $css_file_path ) ) {

                        ob_start();
                        include( $css_file_path );
                        $css .= "\n\n".ob_get_clean();

                    }

                }

                return $css;

            }

        /*
        JS
        */
            function woo_js( $js ) {

                if($this->product_addtocart_sticky) {

                    $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                    if( file_exists ( $js_file_path ) ) {

                        ob_start();
                        include( $js_file_path );
                        $js .= "\n\n".ob_get_clean();

                    }

                }

                return $js;

            }

    }

}

if( !function_exists('dt_shop_single_module_sticky_cart') ) {
	function dt_shop_single_module_sticky_cart() {
		return Dt_Shop_Single_Module_Sticky_Cart::instance();
	}
}

dt_shop_single_module_sticky_cart();