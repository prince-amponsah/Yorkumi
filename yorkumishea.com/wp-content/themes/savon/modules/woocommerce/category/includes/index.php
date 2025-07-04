<?php
/**
 * ------------------------------------------------------------------------------------------------
 * Content Product Category Loop
 * ------------------------------------------------------------------------------------------------
 */


/** Hook: woocommerce_before_subcategory. **/

remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );


if( ! function_exists( 'dtshop_woo_product_cat_style_start' ) ) {

	function dtshop_woo_product_cat_style_start() {

		// Column Class
		$display_mode = wc_get_loop_prop( 'product-display-type', 'grid' );
		$display_mode = (isset($display_mode) && !empty($display_mode)) ? $display_mode : 'grid';

        if($display_mode == 'list') {
        	$columns = 4;
            $column_class = savon_woo_loop_column_class($columns);
        } else {
			$columns = wc_get_loop_prop('columns');
			$column_class = savon_woo_loop_column_class($columns);
        }

		echo '<div class="'.esc_attr($column_class).'">';
			echo '<div class="product-wrapper">';

	}

	add_action( 'woocommerce_before_subcategory', 'dtshop_woo_product_cat_style_start', 10 );

}



/** Hook: woocommerce_before_subcategory_title. **/

if( ! function_exists( 'dtshop_woo_before_subcategory_title' ) ) {

	function dtshop_woo_before_subcategory_title($category) {
		echo '<div class="product-thumb">';
			echo '<span class="image">';
				echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">';
	}

	add_action( 'woocommerce_before_subcategory_title', 'dtshop_woo_before_subcategory_title', 5 );

}


/** Hook: woocommerce_shop_loop_subcategory_title. **/

remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );


/** Hook: woocommerce_after_subcategory_title. **/

if( ! function_exists( 'dtshop_woo_after_subcategory_title' ) ) {

	function dtshop_woo_after_subcategory_title($category) {
				echo '</a>';
			echo '</span>';
		echo '</div>';
		echo '<div class="product-details"><h5>'.savon_html_output($category->name);
			if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			}
		echo '</h5></div>';
	}

	add_action( 'woocommerce_after_subcategory_title', 'dtshop_woo_after_subcategory_title', 10 );

}


/** Hook: woocommerce_after_subcategory. **/

remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

if( ! function_exists( 'dtshop_woo_product_cat_style_end' ) ) {

	function dtshop_woo_product_cat_style_end() {

			echo '</div>';
		echo '</div>';

	}

	add_action( 'woocommerce_after_subcategory', 'dtshop_woo_product_cat_style_end', 10 );

}