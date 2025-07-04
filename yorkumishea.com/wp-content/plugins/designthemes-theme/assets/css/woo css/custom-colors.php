<?php

/* ---------------------------------------------------------------------------
 * Custom Color Styles
 * --------------------------------------------------------------------------- */

 if(!function_exists('dtshop_theme_custom_colors_styles')) {
	function dtshop_theme_custom_colors_styles() {

		$primary_color = dtshop_get_option( 'primary-color' );
		$secondary_color = dtshop_get_option( 'secondary-color' );
		$tertiary_color = dtshop_get_option( 'tertiary-color' );

		$css = '';

		if( !empty( $primary_color ) ) {

			// HEX
			
				# Primary BG Color - WooCommerce Defaults
					$css .= '.woocommerce ul.products li.product .product-buttons-wrapper.product-button .wc_inline_buttons .wc_btn_inline, .woocommerce ul.products li.product .product-buttons-wrapper.product-icons a, .woocommerce ul.products li.product .product-buttons-wrapper.product-icons button, .woocommerce ul.products li.product .product-buttons-wrapper.product-icons .button, .woocommerce ul.products li.product .product-buttons-wrapper.product-icons a.button, 
															
					.woocommerce .view-mode a:hover, .woocommerce .view-mode a.active, .woocommerce .swiper-button-prev, .woocommerce .swiper-button-next { background-color:'.$primary_color.'; }';
					
				# Primary Color - WooCommerce Defaults
					$css .= '.woocommerce ul.products li.product .product-details div[class$="product-buttons-wrapper"] a, .woocommerce ul.products li.product .product-details div[class$="product-buttons-wrapper"] button, .woocommerce ul.products li.product .product-details div[class$="product-buttons-wrapper"] .button { color:'.$primary_color.'; }';

			// RGBA

				$primary_color_rgba = dtshop_hex2rgb( $primary_color );
				$primary_color_rgba = implode(',', $primary_color_rgba);


		}

		if( !empty( $secondary_color ) ) {

			// HEX

				# Secondary BG Color - WooCommerce Defaults
					$css .= '.woocommerce ul.products li.product .product-buttons-wrapper.product-icons .wc_inline_buttons .wc_btn_inline a:hover, .woocommerce ul.products li.product .product-buttons-wrapper.product-icons .wc_inline_buttons .wc_btn_inline button:hover, div[class*="product"] .dt-special-products-carousel.swiper-container div[class*="arrow-pagination"] > a[class*="arrow"]:hover, .zoo-cw-group-attribute.zoo-cw-type-text .zoo-cw-attribute-option .zoo-cw-attr-item:after { background-color:'.$secondary_color.'; }';


			// RGBA

				$secondary_color_rgba = dtshop_hex2rgb( $secondary_color );
				$secondary_color_rgba = implode(',', $secondary_color_rgba);


		}

		if( !empty( $tertiary_color ) ) {

			$tertiary_color_rgba = dtshop_hex2rgb( $tertiary_color );
			$tertiary_color_rgba = implode(',', $tertiary_color_rgba);

		}

		wp_add_inline_style( 'dtshop-woo', $css );

	}
	add_action( 'wp_enqueue_scripts', 'dtshop_theme_custom_colors_styles', 105 );
}