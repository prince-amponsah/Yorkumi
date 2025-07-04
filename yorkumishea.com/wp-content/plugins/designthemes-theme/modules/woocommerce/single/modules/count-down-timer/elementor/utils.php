<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_options_cdt_render' ) ) {
	function dtshop_woo_single_summary_options_cdt_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'designthemes-theme');
		return $options;

	}
	add_filter( 'dtshop_woo_single_summary_options', 'dtshop_woo_single_summary_options_cdt_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_styles_cdt_render' ) ) {
	function dtshop_woo_single_summary_styles_cdt_render( $styles ) {

		array_push( $styles, 'dtshop-coundown-timer' );
		return $styles;

	}
	add_filter( 'dtshop_woo_single_summary_styles', 'dtshop_woo_single_summary_styles_cdt_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_scripts_cdt_render' ) ) {
	function dtshop_woo_single_summary_scripts_cdt_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'dtshop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'dtshop_woo_single_summary_scripts', 'dtshop_woo_single_summary_scripts_cdt_render', 10, 1 );

}