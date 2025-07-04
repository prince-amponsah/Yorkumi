<?php

/**
 * WooCommerce - Size Guide - Include Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Others_Size_Guide_Include' ) ) {

    class Dt_Shop_Others_Size_Guide_Include {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

			// On Init
				add_action( 'init', array( $this, 'on_init' ), 10 );

			// Regsiter Fields
				add_filter( 'cs_taxonomy_options', array( $this, 'register_fields' ) );

			// Ajax Call
				add_action( 'wp_ajax_dtshop_size_guide_popup', array( $this, 'dtshop_size_guide_popup' ) );
				add_action( 'wp_ajax_nopriv_dtshop_size_guide_popup', array( $this, 'dtshop_size_guide_popup' ) );

		}


        /**
         * On Init
         */
			function on_init() {

				// Register Taxonomy

					register_taxonomy(
						'size_guide',
						array ( 'product' ),
						array (
							'hierarchical'       => false,
							'show_ui'            => true,
							'query_var'          => false,
							'rewrite'            => false,
							'public'             => false,
							'capabilities'      => array( 'edit_theme_options' ),
							'label'              => esc_html__( 'Size Guide', 'designthemes-theme' ),
							'labels'             => array (
								'name'              => esc_html__( 'Size Guides', 'designthemes-theme' ),
								'singular_name'     => esc_html__( 'Size Guide', 'designthemes-theme' ),
								'menu_name'         => _x( 'Size Guides', 'Admin menu name', 'designthemes-theme' ),
								'search_items'      => esc_html__( 'Search Size Guides', 'designthemes-theme' ),
								'all_items'         => esc_html__( 'All Size Guides', 'designthemes-theme' ),
								'parent_item'       => esc_html__( 'Parent Size Guide', 'designthemes-theme' ),
								'parent_item_colon' => esc_html__( 'Parent Size Guide: ', 'designthemes-theme' ),
								'edit_item'         => esc_html__( 'Edit Size Guide', 'designthemes-theme' ),
								'update_item'       => esc_html__( 'Update Size Guide', 'designthemes-theme' ),
								'add_new_item'      => esc_html__( 'Add new Size Guide', 'designthemes-theme' ),
								'new_item_name'     => esc_html__( 'New Size Guide name', 'designthemes-theme' ),
								'not_found'         => esc_html__( 'No Size Guides found', 'designthemes-theme' ),
							)
						)
					);

				// WooCommerce Default Page - Size Guide Button

					$settings = dt_woo_single_core()->woo_default_settings();
					extract($settings);

					if($product_enable_size_guide) {
						add_action( 'woocommerce_single_product_summary', array( $this, 'dtshop_woo_loop_product_button_elements_sizeguide' ), 35 );
					}

				// WooCommerce Custom Template Page - Size Guide Button

					add_action( 'dt_woo_loop_product_button_elements_sizeguide', array( $this, 'dtshop_woo_loop_product_button_elements_sizeguide' ) );

			}

		/**
         * Regsiter Fields
         */
			function register_fields( $options ) {
				$options[] = array(
					'id'       => 'size_guide_options',
					'taxonomy' => 'size_guide',
					'fields'   => array(
						array(
							'id'      => 'type',
							'type'    => 'image',
							'title'   => esc_html__('Image', 'designthemes-theme')
						),

					)
				);

				return $options;
			}

		/**
         * Size Guide Frontend
         */
			function dtshop_woo_loop_product_button_elements_sizeguide() {


				global $product;
				$product_id = $product->get_id();

				$terms = wp_get_post_terms($product_id, 'size_guide');
				if( is_array($terms) && !empty($terms) ) {

					echo '<div class="wcsg_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Size Guide', 'designthemes-theme' ).'"><a href="#" class="button dt-wcsg-button" data-product_id="'.esc_attr($product_id).'" data-sizeguide-nonce="'.wp_create_nonce('sizeguide_nonce').'">'.esc_html__('Size Guide', 'designthemes-theme' ).'</a></div>';

				}

			}

			function dtshop_size_guide_popup() {

				$sizeguide_nonce = $_POST['sizeguide_nonce'];
				if(isset($sizeguide_nonce) && wp_verify_nonce($sizeguide_nonce, 'sizeguide_nonce')) {

					$product_id = (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != '') ? $_REQUEST['product_id'] : -1;

					if($product_id > -1) {

						$terms = wp_get_post_terms($product_id, 'size_guide');
						if( is_array($terms) && !empty($terms) ) {

							echo '<div class="dt-sc-size-guide-popup-holder">';

								echo '<div class="dt-sc-size-guide-popup-container swiper-container">';
									echo '<div class="dt-sc-size-guide-popup-content swiper-wrapper">';

									foreach( $terms as $term ) {

										$size_guide_options = get_term_meta( $term->term_id, 'size_guide_options', true );
										$image_id = $size_guide_options['type'];

										$image_attributes = wp_get_attachment_image_src( $image_id, 'full' );

										echo '<div class="dt-sc-size-guide-popup-item swiper-slide">';
											echo '<div class="dt-sc-size-guide-popup-content-title">'.esc_html($term->name).'</div>';
											echo '<div class="dt-sc-size-guide-popup-content-details"><img src="'.esc_url($image_attributes[0]).'" width="'.esc_attr($image_attributes[1]).'" height="'.esc_attr($image_attributes[2]).'" alt="'.esc_attr($term->name).'" /></div>';
										echo '</div>';

									}

									echo '</div>';

									echo '<div class="dt-sc-products-pagination-holder">';
										echo '<div class="dt-sc-products-bullet-pagination"></div>';
									echo '</div>';

								echo '</div>';

								echo '<div class="dt-sc-size-guide-popup-close">'.esc_html__('Close','designthemes-theme').'</div>';
							echo '</div>';
						}

					}

				}

				wp_die();

			}

    }

}

if( !function_exists('dtshop_others_size_guide_include') ) {
	function dtshop_others_size_guide_include() {
        $reflection = new ReflectionClass('Dt_Shop_Others_Size_Guide_Include');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Shop_Others_Size_Guide_Include::instance();