<?php

/*
 * Product single image - Additional Labels 
 */

if( ! function_exists( 'dtshop_woo_loop_product_additional_360_viewer_label' ) ) {

	function dtshop_woo_loop_product_additional_360_viewer_label( $single_template ) {

		$settings = dt_woo_single_core()->woo_default_settings();
		extract($settings);

		if($product_show_360_viewer) {
			echo do_shortcode('[dtshop_product_images_360viewer product_id="" enable_popup_viewer="true" source="single-product" class="" /]');
		}

	}

	add_action('dt_woo_loop_product_additional_labels', 'dtshop_woo_loop_product_additional_360_viewer_label', 10);

}