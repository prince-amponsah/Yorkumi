<?php

if( ! function_exists( 'dtshop_woo_cart_fragments' ) ) {

	function dtshop_woo_cart_fragments( $fragments  ) {

        $settings = dt_woo_others()->woo_default_settings();
        extract($settings);


		if ( $cart_action = get_site_transient( 'cart_action' ) ) {

			$addtocart_custom_action = $cart_action;

		}

		if($addtocart_custom_action == 'sidebar_widget') {

			// Total items in cart
			ob_start();
			echo count(WC()->cart->get_cart());
			$count = ob_get_clean();

			// Get mini cart
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();


			$fragments ['.dt-sc-shop-cart-widget-header'] = '<div class="dt-sc-shop-cart-widget-header">
																<h3>'.esc_html__( 'Shopping cart', 'designthemes-theme' ).'
																	<span>'.esc_html($count).'</span>
																	<a href="#" class="dt-sc-shop-cart-widget-close-button">'.esc_html__( 'Close', 'designthemes-theme' ).'</a>
																</h3>
															</div>';
			$fragments ['.dt-sc-shop-cart-widget-content'] = '<div class="dt-sc-shop-cart-widget-content">'.savon_html_output($mini_cart).'</div>';


		}


		if($addtocart_custom_action == 'notification_widget') {

			global $woocommerce;

			$items = $woocommerce->cart->get_cart();

			$ids = array();
			foreach($items as $item => $values) {
		        $_product = $values['data']->post;
		        $ids[] = $_product->ID;
			}

			if( is_array($ids) && !empty($ids) ) {

				$last_product_id = end($ids);

				$product = wc_get_product( $last_product_id );

				$fragments ['.dt-sc-shop-cart-widget-header'] = '<div class="dt-sc-shop-cart-widget-header">
																	<a href="#" class="dt-sc-shop-cart-widget-close-button">'.esc_html__( 'Close', 'designthemes-theme' ).'</a>
																</div>';
				$fragments ['.dt-sc-shop-cart-widget-content'] = '<div class="dt-sc-shop-cart-widget-content">
																	<div class="dt-sc-shop-cart-widget-content-thumb">
																		<a class="image" href="'.esc_url($product->get_permalink()).'" title="'.esc_attr($product->get_name()).'">'.savon_html_output($product->get_image()).'</a>
																	</div>
																	<div class="dt-sc-shop-cart-widget-content-info">
																		'.sprintf( esc_html__( 'Product %1$s has been added to cart sucessfully.', 'designthemes-theme' ), '<a class="image" href="'.esc_url($product->get_permalink()).'" title="'.esc_attr($product->get_name()).'">'.savon_html_output($product->get_name()).'</a>').'
																	</div>
																</div>';

			}

		}


		// Shortcode

		// Total items in cart
		$count_html = '';
		$count = count(WC()->cart->get_cart());
		if($count > 0) {
			$count_html = $count;
		}

		// Total items in cart
		$subtotal = WC()->cart->get_cart_subtotal();

		// Get mini cart
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();


		$fragments ['.dt-sc-shop-menu-cart-number'] = '<span class="dt-sc-shop-menu-cart-number">'.savon_html_output($count_html).'</span>';
		$fragments ['.dt-sc-shop-menu-cart-subtotal'] = '<span class="dt-sc-shop-menu-cart-subtotal">'.savon_html_output($subtotal).'</span>';
		$fragments ['.dt-sc-shop-menu-cart-totals'] = '<span class="dt-sc-shop-menu-cart-totals">'.savon_html_output($subtotal).'</span>';
		$fragments ['.dt-sc-shop-menu-cart-content'] = '<div class="dt-sc-shop-menu-cart-content">'.savon_html_output($mini_cart).'</div>';



		return $fragments;

	}

	add_filter('woocommerce_add_to_cart_fragments', 'dtshop_woo_cart_fragments');

}


if ( ! function_exists( 'dtshop_woo_sidebar_widget' ) ) {

	function dtshop_woo_sidebar_widget() {

        $settings = dt_woo_others()->woo_default_settings();
        extract($settings);


		$notification_class = '';
		if($addtocart_custom_action == 'notification_widget') {

			$notification_class = 'cart-notification-widget';

		} else if($addtocart_custom_action == 'sidebar_widget') {

			$notification_class = 'activate-sidebar-widget';

		} else {

			if ( $cart_action = get_site_transient( 'cart_action' ) ) {

				if($cart_action == 'sidebar_widget') {
					$notification_class = 'activate-sidebar-widget';
				}

			}

		}

		if($notification_class != '') {

			echo '<div class="dt-sc-shop-cart-widget '.esc_attr($notification_class).'">';
				echo '<div class="dt-sc-shop-cart-widget-inner">';
					echo '<div class="dt-sc-shop-cart-widget-header">';
						echo '<h3>'.esc_html__( 'Your Shopping cart', 'designthemes-theme' ).'<span></span></h3>';
						echo '<a href="#" class="dt-sc-shop-cart-widget-close-button">'.esc_html__( 'Close', 'designthemes-theme' ).'</a>';
					echo '</div>';
					echo '<div class="dt-sc-shop-cart-widget-content-wrapper">';
						echo '<div class="dt-sc-shop-cart-widget-content"></div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="dt-sc-shop-cart-widget-overlay"></div>';

		}

	}

	add_action( 'wp_footer', 'dtshop_woo_sidebar_widget', 10 );

}