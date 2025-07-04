<?php
/**
 * ------------------------------------------------------------------------------------------------
 * Checkout
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


if( ! function_exists( 'dtshop_woo_checkout_login_open' ) ) {

	function dtshop_woo_checkout_login_open() {
		if ( ! is_user_logged_in() ) {
			echo '<div class="woocommerce-checkout-header-login">';
		}
	}

	add_action( 'woocommerce_before_checkout_form', 'dtshop_woo_checkout_login_open', 11 );

}

add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 12 );


if( ! function_exists( 'dtshop_woo_checkout_login_close' ) ) {

	function dtshop_woo_checkout_login_close() {
		if ( ! is_user_logged_in() ) {
			echo '</div>';
		}
	}

	add_action( 'woocommerce_before_checkout_form', 'dtshop_woo_checkout_login_close', 13 );

}


if( ! function_exists( 'dtshop_woo_checkout_coupon_open' ) ) {

	function dtshop_woo_checkout_coupon_open() {
		echo '<div class="woocommerce-checkout-header-coupon">';
	}

	add_action( 'woocommerce_before_checkout_form', 'dtshop_woo_checkout_coupon_open', 14 );

}

add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 15 );


if( ! function_exists( 'dtshop_woo_checkout_coupon_close' ) ) {

	function dtshop_woo_checkout_coupon_close() {
		echo '</div>';
	}

	add_action( 'woocommerce_before_checkout_form', 'dtshop_woo_checkout_coupon_close', 16 );

}