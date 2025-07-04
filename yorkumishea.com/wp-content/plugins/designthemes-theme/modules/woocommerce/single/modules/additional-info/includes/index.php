<?php

/*
 * Product Countdown Timer
 */

if ( ! function_exists( 'dtshop_products_additional_info' ) ) {

	function dtshop_products_additional_info() {

		if(is_product()) {

			$settings = dt_woo_single_core()->woo_default_settings();
			extract($settings);

			$product_template = dtshop_woo_product_single_template_option();

			if( $product_template == 'woo-default' ) {

				if(!$product_additional_info) {
					return;
				}

			}

		}

		echo '<ul class="product-additional-info">';

			// Delivery Period Offer

			dtshop_products_ai_delivery_period(false, $product_ai_delivery_period);

			// RealTime Visitors

			dtshop_products_ai_realtime_visitors(false, $product_ai_visitors_min_value, $product_ai_visitors_max_value);

			// Free Shipping Offer

			dtshop_products_ai_shipping_offer(false);


		echo '</ul>';

	}

	add_action( 'woocommerce_single_product_summary', 'dtshop_products_additional_info', 36 );

}

// Delivery Period Offer

if ( ! function_exists( 'dtshop_products_ai_delivery_period' ) ) {

	function dtshop_products_ai_delivery_period($wrap = false, $product_ai_delivery_period = "") {

		if($wrap) {
			echo '<ul class="product-additional-info single-item">';
		}

			global $product;
			$availability = $product->get_availability();
			if ( $availability['class'] != 'out-of-stock' && $product_ai_delivery_period != '' && $product_ai_delivery_period > 0 ) {

				$delivery_date = date_i18n(get_option('date_format'), strtotime('+' . $product_ai_delivery_period . " days"));

				echo '<li class="product-additional-info-item">';
					echo '<i class="fa fa-eye"></i>';

					echo sprintf(
						esc_html__('Order in the next %1$s to get it by %2$s', 'designthemes-theme'),
						'<span class="offer-end-of-day" data-timezone="'.get_option('gmt_offset').'" data-hours="'.esc_attr__('hours', 'designthemes-theme').'" data-minutes="'.esc_attr__('minutes', 'designthemes-theme').'"></span>',
						'<span class="offer-delivery-date">'.esc_html($delivery_date).'</span>'
					);

				echo '</li>';

			}

		if($wrap) {
			echo '</ul>';
		}

	}

}

// Real Time Visitors

if ( ! function_exists( 'dtshop_products_ai_realtime_visitors' ) ) {

	function dtshop_products_ai_realtime_visitors($wrap = false, $product_ai_visitors_min_value = "", $product_ai_visitors_max_value = "") {

		if($wrap) {
			echo '<ul class="product-additional-info single-item">';
		}

			$rand_visitor_count = rand( $product_ai_visitors_min_value, $product_ai_visitors_max_value );
			echo '<li class="product-additional-info-item">';
				echo '<i class="fa fa-eye"></i>';
				echo sprintf(
					esc_html__('Real Time %1$s Visitors Right Now', 'designthemes-theme'),
					'<span id="ai-visitors-count" class="ai-visitors-count" data-min-visitors="' . $product_ai_visitors_min_value . '"data-max-visitors="' . $product_ai_visitors_max_value . '">' . $rand_visitor_count . '</span>'
				);
			echo '</li>';

		if($wrap) {
			echo '</ul>';
		}

	}

}

// Free Shipping Offer

if ( ! function_exists( 'dtshop_products_ai_shipping_offer' ) ) {

	function dtshop_products_ai_shipping_offer($wrap = false) {

		if($wrap) {
			echo '<ul class="product-additional-info single-item">';
		}

			# Get Free Shipping Methods for Rest of the World Zone & populate array $min_amounts
			$default_zone = new WC_Shipping_Zone( 0 );

			$default_methods = $default_zone->get_shipping_methods();
			foreach ( $default_methods as $key => $value ) {
				if ( $value->id === "free_shipping" ) {
					if ( $value->min_amount > 0 ) {
						$min_amounts[] = $value->min_amount;
					}
				}
			}
			# Get Free Shipping Methods for all other ZONES & populate array $min_amounts
			$delivery_zones = WC_Shipping_Zones::get_zones();
			foreach ( $delivery_zones as $key => $delivery_zone ) {
				foreach ( $delivery_zone['shipping_methods'] as $key => $value ) {
					if ( $value->id === "free_shipping" ) {
						if ( $value->min_amount > 0 ) {
							$min_amounts[] = $value->min_amount;
						}
					}
				}
			}
			#Find lowest min_amount
			if ( isset( $min_amounts ) ) {
				if ( is_array( $min_amounts ) && $min_amounts ) {

					$current = isset(WC()->cart->subtotal) ? WC()->cart->subtotal : 0;
					$min_amount = min( $min_amounts );

					echo '<li class="product-additional-info-item">';
						echo '<i class="fa fa-eye"></i>';
						echo sprintf(
							esc_html__('Spend %1$s to get Free Shipping', 'designthemes-theme'),
							'<span class="offer-free-shipping">' . wc_price( $min_amount - $current ) . '</span>'
						);
					echo '</li>';

				}
			}

		if($wrap) {
			echo '</ul>';
		}

	}

}