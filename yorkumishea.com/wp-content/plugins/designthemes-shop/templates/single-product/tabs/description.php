<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', esc_html__( 'Description', 'dtshop' ) ) );

?>

<?php if ( $heading ) : ?>
  <h2><?php echo savon_html_output($heading); ?></h2>
<?php endif; ?>

<?php

/* Customized script */

$product_template = dtshop_woo_product_single_template_option();
if( $product_template == 'custom-template' ) {

	global $product;
	$product_id = $product->get_id();

	$settings = get_post_meta( $product_id, '_custom_settings', true );

	if(isset($settings['description']) && !empty($settings['description'])) {

		if($settings['description'] == 'custom-description' && isset($settings['custom-description']) && !empty($settings['custom-description'])) {

			echo do_shortcode($settings['custom-description']);

		} else if($settings['description'] > 0) {

			$frontend = Elementor\Frontend::instance();
			$post_description = $frontend->get_builder_content( $settings['description'], true );
			echo savon_html_output($post_description);

		}
		
	}

} else {
	the_content();
}