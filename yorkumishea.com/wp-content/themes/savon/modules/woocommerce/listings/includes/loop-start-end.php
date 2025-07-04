<?php

/**
 * content-product.php hooks
 *
 * woocommerce_before_shop_loop_item, woocommerce_after_shop_loop_item
 */


/** Hook: woocommerce_before_shop_loop_item. **/

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

if( ! function_exists( 'dtshop_woo_product_style_start' ) ) {

	function dtshop_woo_product_style_start() {

		// Column Class
		$columns = wc_get_loop_prop('columns');

		$display_mode = wc_get_loop_prop( 'product-display-type', 'grid' );
		$display_mode = (isset($display_mode) && !empty($display_mode)) ? $display_mode : 'grid';

		if($display_mode == 'list') {
			$columns = 1;
		}


		$column_class = savon_woo_loop_column_class($columns);

		$product_background_bgcolor = wc_get_loop_prop( 'product-background-bgcolor' );
		$product_background_bgcolor = (isset($product_background_bgcolor) && !empty($product_background_bgcolor)) ? 'style="background-color:'.esc_attr($product_background_bgcolor).';"' : '';

		echo '<div class="'.esc_attr($column_class).'">';
			echo '<div class="product-wrapper" '.savon_html_output($product_background_bgcolor).'>';

	}

	add_action( 'woocommerce_before_shop_loop_item', 'dtshop_woo_product_style_start', 1 );

}


/** Hook: woocommerce_after_shop_loop_item. **/

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

if( ! function_exists( 'dtshop_woo_product_style_end' ) ) {

	function dtshop_woo_product_style_end() {

			echo '</div>';
		echo '</div>';

	}

	add_action( 'woocommerce_after_shop_loop_item', 'dtshop_woo_product_style_end', 100 );

}

// Remove Yith Buttons

savon_woo_remove_anonymous_object_action('woocommerce_after_shop_loop_item', 'YITH_WCQV_Frontend', 'yith_add_quick_view_button' , 15 );
savon_woo_remove_anonymous_object_action('woocommerce_after_shop_loop_item', 'YITH_Woocompare_Frontend', 'add_compare_link' , 20 );


?>