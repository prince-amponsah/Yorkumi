<?php

/*
* Product Additional Tabs
*/

if( ! function_exists( 'dtshop_woo_additional_product_tabs' ) ) {

	function dtshop_woo_additional_product_tabs( $tabs ) {

		global $post;

		$settings = get_post_meta( $post->ID, '_custom_settings', true );
		$product_additional_tabs = (isset($settings['product-additional-tabs']) && !empty($settings['product-additional-tabs'])) ? $settings['product-additional-tabs'] : array ();

		if( is_array( $product_additional_tabs ) && !empty( $product_additional_tabs ) ) {

			$priority = 40;

			foreach( $product_additional_tabs as $product_additional_tab_key => $product_additional_tab ) {

				$tab_title = $product_additional_tab['tab_title'];
				$tab_description = $product_additional_tab['tab_description'];

				$tab_key = str_replace(' ', '', $tab_title);
				$tab_key = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_key);

				$tab_key = 'dt_'.strtolower($tab_key);

				$tabs[$tab_key] = array(
					'title' 	=> $tab_title,
					'priority' 	=> $priority,
					'callback' 	=> 'dtshop_woo_additional_product_tabs_content'
				);

				$priority = $priority + 10;

			}

		}

		return $tabs;

	}

	function dtshop_woo_additional_product_tabs_content( $key ) {

		global $post;

		$settings = get_post_meta( $post->ID, '_custom_settings', true );
		$product_additional_tabs = (isset($settings['product-additional-tabs']) && !empty($settings['product-additional-tabs'])) ? $settings['product-additional-tabs'] : array ();

		if( is_array( $product_additional_tabs ) && !empty( $product_additional_tabs ) ) {

			foreach( $product_additional_tabs as $product_additional_tab_key => $product_additional_tab ) {

				$tab_title = $product_additional_tab['tab_title'];
				$tab_description = $product_additional_tab['tab_description'];

				$tab_content = '';
				if(isset($tab_description) && !empty($tab_description)) {

					if($tab_description == 'custom-description' && isset($product_additional_tab['tab_custom_description']) && !empty($product_additional_tab['tab_custom_description'])) {

						$tab_content = $product_additional_tab['tab_custom_description'];

					} else if($tab_description > 0) {

						$frontend = Elementor\Frontend::instance();
						$post_description = $frontend->get_builder_content( $tab_description, true );
						$tab_content = $post_description;

					}

				}

				$tab_key = str_replace(' ', '', $tab_title);
				$tab_key = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_key);

				$tab_key = 'dt_'.strtolower($tab_key);

				if($tab_key == $key) {

					echo '<h2>'.esc_html($tab_title).'</h2>';
					echo do_shortcode($tab_content);

				}

			}

		}

	}

	add_filter( 'woocommerce_product_tabs', 'dtshop_woo_additional_product_tabs', 10 );

}