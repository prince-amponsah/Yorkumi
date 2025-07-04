<?php

/* Product Tabs Exploaded - Shortcodes */

if(!function_exists('dtshop_product_tabs_exploded_html')) {
	function dtshop_product_tabs_exploded_html($attrs, $content = null) {

		extract ( shortcode_atts ( array (
			'product_id'    => '',
			'tab'           => '',
			'hide_title'    => '',
			'apply_scroll'  => '',
			'scroll_height' => '',
			'class'         => ''
		), $attrs ) );

		$out = dtshop_product_tabs_exploded_render_html($attrs);

		return $out;

	}
	add_shortcode( 'dtshop_product_tabs_exploded', 'dtshop_product_tabs_exploded_html' );
}


if(!function_exists('dtshop_product_tabs_exploded_render_html')) {
	function dtshop_product_tabs_exploded_render_html($settings) {

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] != '') {

			$hide_title_class = '';
			if($settings['hide_title'] == 'true') {
				$hide_title_class = 'dt-sc-product-hide-tab-title';
			}

			$scroll_class = $scroll_height_style_attr = '';
			if($settings['apply_scroll'] == 'true') {
				$scroll_class             = 'dt-sc-content-scroll';
				$scroll_height            = ($settings['scroll_height'] != '') ? $settings['scroll_height'] : 400;
				$scroll_height_style_attr = 'style = "height:'.esc_attr($scroll_height).'px"';
			}

			$output .= '<div class="dt-sc-product-tabs dt-sc-product-tabs-exploded '.$settings['class'].' '.$hide_title_class.' '.$scroll_class.'" '.$scroll_height_style_attr.'>';

				if($settings['tab'] == 'description') {

					ob_start();
					woocommerce_product_description_tab();
					$output .= ob_get_clean();

				}

				if($settings['tab'] == 'review') {

					ob_start();
					comments_template();
					$output .= ob_get_clean();

				}

				if($settings['tab'] == 'additional_information') {

					ob_start();
					woocommerce_product_additional_information_tab();
					$output .= ob_get_clean();

				}

			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'designthemes-theme');

		}

		return $output;

	}
}