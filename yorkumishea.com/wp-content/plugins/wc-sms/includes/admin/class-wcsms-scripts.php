<?php if ( !defined( 'ABSPATH' ) ) { exit; }

class  WCSMS_WooCommerce_Frontend_Scripts implements WCSMS_Register_Interface {
	public function register() {
		// add_action( 'admin_enqueue_scripts', array( $this, 'wcsms_admin_enqueue_scripts' ) );
	}

	public function wcsms_admin_enqueue_scripts() {
		wp_enqueue_script( 'admin-wcsms-scripts', WCSMS_PLUGIN_DIR_URL . 'assets/js/admin.js', array ('jquery') );
		// // jquery modal
		// // https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css
		// wp_enqueue_style( 'admin-wcsms-css', WCSMS_PLUGIN_DIR_URL . 'assets/css/jquery.modal.min.css' );
		// // https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js
		// wp_enqueue_script( 'jquery-wcsms-modal', WCSMS_PLUGIN_DIR_URL . 'assets/js/jquery.modal.min.js', array ('jquery') );
	}
}
