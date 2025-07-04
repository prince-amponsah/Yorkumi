<?php

/**
 * Product labels
 **/


// Remove sale flash from single product page
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

if( ! function_exists( 'dtshop_woo_loop_product_additional_labels' ) ) {

	function dtshop_woo_loop_product_additional_labels( $single_template ) {

		dtshop_woo_show_product_additional_labels();

	}

	add_action('dt_woo_loop_product_additional_labels', 'dtshop_woo_loop_product_additional_labels', 20);

}

// Product Labels - Used in Product Images Shortcodes

if( ! function_exists( 'dtshop_woo_show_product_additional_labels' ) ) {

	function dtshop_woo_show_product_additional_labels() {

		global $product;
		$product_id = $product->get_id();

		$settings = get_post_meta( $product_id, '_custom_settings', true );

		if( $product->is_on_sale() && $product->is_in_stock() ) {
			echo '<span class="onsale"><span>'.esc_html__('Sale', 'savon').'</span></span>';
		} else if( !$product->is_in_stock() ) {
			echo '<span class="out-of-stock"><span>'.esc_html__('Sold Out','savon').'</span></span>';
		}

		if( $product->is_featured() ) {
			echo '<div class="featured-tag">
						<div>
							<i class="dticon-thumb-tack"></i>
							<span>'.esc_html__('Featured', 'savon').'</span>
						</div>
					</div>';
		}

		if(isset($settings['product-new-label']) && $settings['product-new-label'] == 'true') {
			echo '<span class="new"><span>'.esc_html__('New', 'savon').'</span></span>';
		}

	}

}