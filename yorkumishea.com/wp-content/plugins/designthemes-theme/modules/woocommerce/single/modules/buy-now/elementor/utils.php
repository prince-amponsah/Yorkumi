<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_options_bn_render' ) ) {
	function dtshop_woo_single_summary_options_bn_render( $options ) {

		$options['buy_now'] = esc_html__('Summary Buy Now', 'designthemes-theme');
		return $options;

	}
	add_filter( 'dtshop_woo_single_summary_options', 'dtshop_woo_single_summary_options_bn_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_styles_bn_render' ) ) {
	function dtshop_woo_single_summary_styles_bn_render( $styles ) {

		array_push( $styles, 'dtshop-buy-now' );
		return $styles;

	}
	add_filter( 'dtshop_woo_single_summary_styles', 'dtshop_woo_single_summary_styles_bn_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_scripts_bn_render' ) ) {
	function dtshop_woo_single_summary_scripts_bn_render( $scripts ) {

		array_push( $scripts, 'dtshop-buy-now' );
		return $scripts;

	}
	add_filter( 'dtshop_woo_single_summary_scripts', 'dtshop_woo_single_summary_scripts_bn_render', 10, 1 );

}