<?php

/*
Utils
*/

// Column Class

if ( ! function_exists( 'savon_woo_loop_column_class' ) ) {

	function savon_woo_loop_column_class ( $columns ) {

		$columns = intval( $columns );

		switch( $columns ) {
			case 1:
				$class = 'dt-col dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12';
			break;

			case 2:
				$class = 'dt-col dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-6 dt-col-hxlg-6 dt-col-lg-6';
			break;

			case 3:
				$class = 'dt-col dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4';
			break;

			case 4:
			default:
				$class = 'dt-col dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-3 dt-col-lg-3';
			break;
		}

		$class = apply_filters( 'savon_woo_loop_column_class', $class, $columns );

		return $class;

	}

}

// Shop Page - Post Class

if ( ! function_exists( 'savon_woo_product_post_class' ) ) {

	function savon_woo_product_post_class($classes, $class = '', $post_id = '') {

		if ( ! $post_id || ! in_array( get_post_type( $post_id ), array( 'product', 'product_variation' ), true ) ) {
			return $classes;
		}

		// Unset first class

		if(in_array('first', $classes)) {
			unset($classes[array_search('first', $classes)]);
		}


		// Display mode

		$display_mode = wc_get_loop_prop( 'product-display-type', 'grid' );
		$display_mode = (isset($display_mode) && !empty($display_mode)) ? $display_mode : 'grid';

        if($display_mode == 'list') {

			$display_class = 'product-list-view';

			$display_mode_list_option = wc_get_loop_prop( 'product-display-type-list-option', 'left-thumb' );
			$display_mode_list_option = (isset($display_mode_list_option) && !empty($display_mode_list_option)) ? $display_mode_list_option : 'left-thumb';

			$display_class .= ' product-list-'.$display_mode_list_option;

        } else {
            $display_class = 'product-grid-view';
        }

		array_push($classes, $display_class);


		// Item class for Shortcode Carousel

		if($item_class = wc_get_loop_prop( 'item_class' )) {
			array_push($classes, $item_class);
		}


		// Secondary image class

		$show_secondary_image_on_hover = wc_get_loop_prop( 'product-thumb-secondary-image-onhover' );
		$show_secondary_image_on_hover = (isset($show_secondary_image_on_hover) && !empty($show_secondary_image_on_hover)) ? true : false;

		if($show_secondary_image_on_hover) {

			global $product;

			$attachment_ids = $product->get_gallery_image_ids();

			if(isset($attachment_ids['0'])) {
				array_push($classes, 'product-with-secondary-image');
			}

		}


		if(!in_array('product', $classes)) {
			array_push($classes, 'product');
		}

	 	return $classes;

	}

	add_filter('post_class', 'savon_woo_product_post_class', 21, 3 );

}

// Category Page - Post Class

if ( ! function_exists( 'savon_woo_product_cat_post_class' ) ) {

	function savon_woo_product_cat_post_class($classes = '', $class = '', $category = '') {

		// Unset first class

		if(in_array('first', $classes)) {
			unset($classes[array_search('first', $classes)]);
		}


		// Display mode

		$display_mode = wc_get_loop_prop( 'product-display-type', 'grid' );
		$display_mode = (isset($display_mode) && !empty($display_mode)) ? $display_mode : 'grid';

        if($display_mode == 'list') {
            $display_class = 'product-grid-view';
            array_push($classes, $display_class);
        }


		// Item class for Shortcode Carousel

		if($item_class = wc_get_loop_prop( 'item_class' )) {
			array_push($classes, $item_class);
		}

	 	return $classes;

	}

	add_filter('product_cat_class', 'savon_woo_product_cat_post_class', 21, 3 );

}

// Remove Anonymous action

if( ! function_exists( 'savon_woo_remove_anonymous_object_action' ) ) {

	function savon_woo_remove_anonymous_object_action( $tag, $class, $method, $priority = null ){

		if( empty($GLOBALS['wp_filter'][ $tag ]) ){
			return;
		}

		foreach ( $GLOBALS['wp_filter'][ $tag ] as $filterPriority => $filter ){
			if( !($priority===null || $priority==$filterPriority) )
				continue;

			foreach ( $filter as $identifier => $function ){
				if( is_array( $function)
					and is_a( $function['function'][0], $class )
					and $method === $function['function'][1]
				){
					remove_action(
						$tag,
						array ( $function['function'][0], $method ),
						$filterPriority
					);
				}
			}
		}
	}

}


/*
Utils - Button Elements
*/

// Cart

if ( ! function_exists( 'dtshop_woo_loop_product_button_elements_cart' ) ) {

	function dtshop_woo_loop_product_button_elements_cart() {

		call_user_func( 'remove'.'_filter', 'woocommerce_loop_add_to_cart_link', 'dtshop_woo_loop_quantity_inputs_for_add_to_cart_link', 1000, 2 );

		ob_start();
		woocommerce_template_loop_add_to_cart();
		$add_to_cart = ob_get_clean();

		// Add to Cart
		if( !empty($add_to_cart) ) {

			$add_to_cart = str_replace('class="','class="dt-sc-button too-small ',$add_to_cart);
			echo '<div class="wcct_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Add To Cart', 'savon' ).'">'.savon_html_output($add_to_cart).'</div>';

		}

	}

	add_action( 'dt_woo_loop_product_button_elements_cart', 'dtshop_woo_loop_product_button_elements_cart' );

}

// Cart With Quantity

if ( ! function_exists( 'dtshop_woo_loop_product_button_elements_cart_with_quantity' ) ) {

	function dtshop_woo_loop_product_button_elements_cart_with_quantity() {

		add_filter( 'woocommerce_loop_add_to_cart_link', 'dtshop_woo_loop_quantity_inputs_for_add_to_cart_link', 1000, 2 );

		ob_start();
		woocommerce_template_loop_add_to_cart();
		$add_to_cart = ob_get_clean();

		// Add to Cart
		if( !empty($add_to_cart) ) {

			$add_to_cart = str_replace('a class="','a class="dt-sc-button too-small ',$add_to_cart);
			echo '<div class="product-cart-with-quantity">'.savon_html_output($add_to_cart).'</div>';

		}

	}

	add_action( 'dt_woo_loop_product_button_elements_cart_with_quantity', 'dtshop_woo_loop_product_button_elements_cart_with_quantity' );

	// Override loop template and show quantities next to add to cart buttons
	if( ! function_exists( 'dtshop_woo_loop_quantity_inputs_for_add_to_cart_link' ) ) {
		function dtshop_woo_loop_quantity_inputs_for_add_to_cart_link( $html, $product ) {
			if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
				$product_id = $product->get_id();
				$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
					$html .= woocommerce_quantity_input(
						array(
							'min_value'   => 1,
							'max_value'   => 10,
							'input_value' => 1
						),
						$product,
						false
					);
					$html .= '<div class="product-buttons-wrapper product-button">';
						$html .= '<div class="wc_inline_buttons">';
							$html .= '<div class="wcct_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Add To Cart', 'savon' ).'">';
								$html .= '<button type="submit" class="dt-sc-button too-small button product_type_simple add_to_cart_with_quantity_button" data-productid="'.esc_attr($product_id).'">' . esc_html__( 'Add', 'savon' ) . '</button>';
								$html .= '<a href="'.esc_url( wc_get_cart_url() ).'" class="added_to_cart wc-forward" title="' . esc_attr__( 'View Cart', 'savon' ) . '" style="display:none;">' . esc_html__( 'View Cart', 'savon' ) . '</a>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</form>';
			}
			return $html;
		}
	}

}

// Wishlist

if ( ! function_exists( 'dtshop_woo_loop_product_button_elements_wishlist' ) ) {

	function dtshop_woo_loop_product_button_elements_wishlist() {

		// YITH Wishlist
		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {

			global $product;
			$product_id = $product->get_id();

			echo '<div class="wcwl_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Wishlist', 'savon' ).'">'.do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $product_id . '"]').'</div>';

		}

	}

	add_action( 'dt_woo_loop_product_button_elements_wishlist', 'dtshop_woo_loop_product_button_elements_wishlist' );

}

// Quick View

if ( ! function_exists( 'dtshop_woo_loop_product_button_elements_quickview' ) ) {

	function dtshop_woo_loop_product_button_elements_quickview() {

		// YITH Quick View
		if ( shortcode_exists( 'yith_quick_view' ) ) {

			global $product;
			$product_id = $product->get_id();

			echo '<div class="wcqv_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Quick View', 'savon' ).'">'.do_shortcode('[yith_quick_view product_id="' . $product_id . '"]').'</div>';

		}

	}

	add_action( 'dt_woo_loop_product_button_elements_quickview', 'dtshop_woo_loop_product_button_elements_quickview' );

}

// Compare

if ( ! function_exists( 'dtshop_woo_loop_product_button_elements_compare' ) ) {

	function dtshop_woo_loop_product_button_elements_compare() {

		// YITH Compare
		if( class_exists( 'YITH_Woocompare' ) ) {

			global $product;

			$is_button = get_option( 'yith_woocompare_is_button' );
			$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'savon' ) );
			$class = $is_button == 'button' ? 'button compare yith-woocompare-button' : 'compare yith-woocompare-button';
			$url = array('action' => 'yith-woocompare-add-product', 'id' => $product->get_id() );
			$lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;
			if( $lang ) {
				$url['lang'] = $lang;
			}

			echo '<div class="wccm_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Compare', 'savon' ).'"><a href="'.esc_url_raw( add_query_arg( $url ) ).'" class="'.esc_attr($class).'" data-product_id="'.esc_attr($product->get_id()).'" rel="nofollow">'.savon_html_output($button_text).'</a></div>';

		}

	}

	add_action( 'dt_woo_loop_product_button_elements_compare', 'dtshop_woo_loop_product_button_elements_compare' );

}

// Swatches

if ( ! function_exists( 'dtshop_woo_loop_product_button_elements_swatches' ) ) {

	function dtshop_woo_loop_product_button_elements_swatches() {

		// Swatches
		dtshop_woo_loop_product_content_swatches();

	}

	add_action( 'dt_woo_loop_product_button_elements_swatches', 'dtshop_woo_loop_product_button_elements_swatches' );

}


// Product Offer Percentage

if( ! function_exists( 'dtshop_woo_loop_product_offer_percentage' ) ) {

	function dtshop_woo_loop_product_offer_percentage($product) {

		$output = '';

		if( $product && $product->is_on_sale() && ! is_admin() && ! $product->is_type('variable') && ! $product->is_type('grouped')){

			$regular_price = (float) $product->get_regular_price();
			$sale_price = (float) $product->get_price();

			$saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';

			$output .= '<div class="product-offers">';
				$output .= '<span class="product-saved-sale">'.sprintf( esc_html__('Get %1$s off', 'savon' ), '<span>'.$saving_percentage.'</span>' ).'</span>';
			$output .= '</div>';

		}

		return $output;

	}

}

?>