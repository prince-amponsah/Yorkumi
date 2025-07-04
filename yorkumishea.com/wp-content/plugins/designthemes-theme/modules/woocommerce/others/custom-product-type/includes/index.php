<?php


// Product Custom Type

if( ! function_exists( 'dtshop_woo_loop_product_custom_type' ) ) {

	function dtshop_woo_loop_product_custom_type($product_id) {

        $output = '';

        $product_show_custom_type = wc_get_loop_prop( 'product-show-custom-type' );
        $product_show_custom_type = ($product_show_custom_type == '' || (isset($product_show_custom_type) && $product_show_custom_type == 'true')) ? true : false;

        if( $product_show_custom_type ) {

            $settings = get_post_meta( $product_id, '_custom_product_type', true );

            if(isset($settings['custom-product-type']) && $settings['custom-product-type'] != '') {

                $custom_product_types = array (
                    'veg'     => esc_html__( 'Veg', 'designthemes-theme' ),
                    'non-veg' => esc_html__( 'Non Veg', 'designthemes-theme')
                );

                $output .= '<div class="product-custom-type">';
                    $output .= '<span class="product-custom-type-label '.esc_attr($settings['custom-product-type']).'">'.$custom_product_types[$settings['custom-product-type']].'</span>';
                $output .= '</div>';
            }

        }

		echo savon_html_output( $output );

    }

    add_action( 'savon_woo_before_product_thumb_image', 'dtshop_woo_loop_product_custom_type', 10, 1 );

}