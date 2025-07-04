<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'designthemes-theme' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'designthemes-theme' );

	/* Customized script */

	$settings = dt_woo_others()->woo_default_settings();
	extract($settings);

	$woo_quantity_plusnminus = $enable_quantity_plusminus;

	$plusminus_class = '';
	if($woo_quantity_plusnminus) {
		$plusminus_class = 'quantity-with-plusminus';
	}

	?>
	<div class="quantity <?php echo esc_attr($plusminus_class); ?>">
		<?php
		/* Customized script */
		if($woo_quantity_plusnminus) {
			?>
			<input type="button" value="-" class="minus" />
			<?php
		}
		?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<input
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'designthemes-theme' ); ?>"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>" />
		<?php
		/* Customized script */
		if(!$woo_quantity_plusnminus) {
			?>
	        <a class="plus arrow-plus" href="#"><i class="dticon-caret-up"></i></a>
	        <a class="minus arrow-minus" href="#"><i class="dticon-caret-down"></i></a>
			<?php
		}
		?>

		<?php
		/* Customized script */
		if($woo_quantity_plusnminus) {
			?>
			<input type="button" value="+" class="plus" />
			<?php
		}
		?>
	</div><?php
}
?>