<?php
/** Product single template option **/

if( ! function_exists( 'dtshop_woo_product_single_custom_template_option' ) ) {

	function dtshop_woo_product_single_custom_template_option() {

		global $post;

		$settings = get_post_meta( $post->ID, '_custom_settings', true );
		$product_template = (isset($settings['product-template']) && $settings['product-template'] != '') ? $settings['product-template'] : 'admin-option';

		if($product_template == 'admin-option') {
			$settings = dt_woo_single_core()->woo_default_settings();
			extract($settings);
			$product_template = (isset($product_default_template) && $product_default_template != '') ? $product_default_template : 'woo-default';
		}

		return $product_template;

	}

}


/** Product single template **/

if( ! function_exists( 'dtshop_woo_product_single_template' ) ) {

	function dtshop_woo_product_single_template( $single_template ) {

		if (is_singular( 'product' )) {

			$product_template = dtshop_woo_product_single_custom_template_option();

			if( $product_template == 'custom-template' ) {
				$single_template = dt_shop_single_module_custom_template()->module_dir_path() . 'templates/custom-template.php';
			}

		}

		return $single_template;

	}

	add_filter('template_include', 'dtshop_woo_product_single_template', 100);

}