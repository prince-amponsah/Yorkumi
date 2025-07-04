<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_options_ai_render' ) ) {
	function dtshop_woo_single_summary_options_ai_render( $options ) {

		$options['additional_info']                   = esc_html__('Summary Additional Info', 'designthemes-theme');
		$options['additional_info_delivery_period']   = esc_html__('Summary Additional Info - Delivery Period', 'designthemes-theme');
		$options['additional_info_realtime_visitors'] = esc_html__('Summary Additional Info - Real Time Visitors', 'designthemes-theme');
		$options['additional_info_shipping_offer']    = esc_html__('Summary Additional Info - Shipping Offer', 'designthemes-theme');
		return $options;

	}
	add_filter( 'dtshop_woo_single_summary_options', 'dtshop_woo_single_summary_options_ai_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_styles_ai_render' ) ) {
	function dtshop_woo_single_summary_styles_ai_render( $styles ) {

		array_push( $styles, 'dtshop-additional-info' );
		return $styles;

	}
	add_filter( 'dtshop_woo_single_summary_styles', 'dtshop_woo_single_summary_styles_ai_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'dtshop_woo_single_summary_scripts_ai_render' ) ) {
	function dtshop_woo_single_summary_scripts_ai_render( $scripts ) {

		array_push( $scripts, 'dtshop-additional-info' );
		return $scripts;

	}
	add_filter( 'dtshop_woo_single_summary_scripts', 'dtshop_woo_single_summary_scripts_ai_render', 10, 1 );

}