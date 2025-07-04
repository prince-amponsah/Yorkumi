<?php

/**
 * Product single template option
 **/

if( ! function_exists( 'dtshop_woo_product_single_template_option' ) ) {

	function dtshop_woo_product_single_template_option() {

		if(is_singular('product')) {

			if( function_exists( 'dtshop_woo_product_single_custom_template_option' ) ) {
				return dtshop_woo_product_single_custom_template_option();
			} else {
				return 'woo-default';
			}

		}

		return false;

	}

}