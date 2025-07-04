<?php

/**
 * content-product.php hooks
 *
 * woocommerce_shop_loop_item_title, woocommerce_after_shop_loop_item_title
 */


/** Hook: woocommerce_shop_loop_item_title **/

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );


if( ! function_exists( 'dtshop_woo_loop_product_content' ) ) {

	function dtshop_woo_loop_product_content() {

		$product_content_enable = wc_get_loop_prop( 'product-content-enable' );

		if($product_content_enable) {

			$product_content_content = wc_get_loop_prop( 'product-content-content' );
			$product_content_content = (isset($product_content_content['enabled']) && !empty($product_content_content['enabled'])) ? array_keys ( $product_content_content['enabled'] ) : false;

			if($product_content_content) {

				$product_show_offer_percentage = wc_get_loop_prop( 'product-show-offer-percentage' );
				$product_show_offer_percentage = (isset($product_show_offer_percentage) && $product_show_offer_percentage == 'content') ? true : false;

				dtshop_woo_loop_product_content_content_setup($product_content_content);

				echo '<div class="product-details">';
					// Product Offer Percentage
					if($product_show_offer_percentage) {
						global $product;
						echo dtshop_woo_loop_product_offer_percentage($product);
					}
					// Others
					do_action('dt_woo_loop_product_content_content', 'content');
					remove_all_actions('dt_woo_loop_product_content_content');
				echo '</div>';

			}

		}

	}

	add_action( 'woocommerce_shop_loop_item_title', 'dtshop_woo_loop_product_content', 10 );

}


/** Hook: woocommerce_after_shop_loop_item_title **/

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

?>