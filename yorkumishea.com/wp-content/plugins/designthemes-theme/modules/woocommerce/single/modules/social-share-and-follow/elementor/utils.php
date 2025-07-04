<?php

/*
* Update Summary Options Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_options_ssf_render' ) ) {
	function dtshop_woo_single_summary_options_ssf_render( $options ) {

		$options['share_follow'] = esc_html__('Summary Share / Follow', 'designthemes-theme');
		return $options;

	}
	add_filter( 'dtshop_woo_single_summary_options', 'dtshop_woo_single_summary_options_ssf_render', 10, 1 );

}


/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_styles_ssf_render' ) ) {
	function dtshop_woo_single_summary_styles_ssf_render( $styles ) {

		array_push( $styles, 'dtshop-social-share-and-follow' );
		return $styles;

	}
	add_filter( 'dtshop_woo_single_summary_styles', 'dtshop_woo_single_summary_styles_ssf_render', 10, 1 );

}
