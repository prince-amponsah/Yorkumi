<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_button_options_sg_render' ) ) {
	function dtshop_woo_single_summary_button_options_sg_render( $options ) {

		$options['sizeguide'] = esc_html__('Button Size Guide', 'designthemes-theme');
		return $options;

	}
	add_filter( 'dtshop_woo_single_summary_button_options', 'dtshop_woo_single_summary_button_options_sg_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_styles_sg_render' ) ) {
	function dtshop_woo_single_summary_styles_sg_render( $styles ) {

		array_push( $styles, 'swiper' );
		array_push( $styles, 'dtshop-size-guide' );
		return $styles;

	}
	add_filter( 'dtshop_woo_single_summary_styles', 'dtshop_woo_single_summary_styles_sg_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_scripts_sg_render' ) ) {
	function dtshop_woo_single_summary_scripts_sg_render( $scripts ) {

		array_push( $scripts, 'jquery-swiper' );
		array_push( $scripts, 'dtshop-size-guide' );
		return $scripts;

	}
	add_filter( 'dtshop_woo_single_summary_scripts', 'dtshop_woo_single_summary_scripts_sg_render', 10, 1 );

}