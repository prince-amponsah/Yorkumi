<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Dt_Shop_Elementor_Single_Social_Widgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {

		$this->dtshop_load_modules();

		add_action( 'dtshop_register_widgets', array( $this, 'dtshop_register_widgets' ), 20, 1 );

		add_action( 'dtshop_register_widget_styles', array( $this, 'dtshop_register_widget_styles' ), 10, 1 );

		add_action( 'dtshop_preview_styles', array( $this, 'dtshop_preview_styles') );

	}

	/**
	 * Init
	 */
	function dtshop_load_modules() {

		require dt_shop_single_module_social_share_and_follow()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets
	 */
	function dtshop_register_widgets( $widgets_manager ) {

		require dt_shop_single_module_social_share_and_follow()->module_dir_path() . 'elementor/widgets/index.php';
		$widgets_manager->register( new DTShop_Widget_Product_Summary_Extend() );

	}

	/**
	 * Register widgets styles
	 */
	function dtshop_register_widget_styles( $suffix ) {

		# Social Sahre & Follow

			wp_register_style( 'dtshop-social-share-and-follow',
				dt_shop_single_module_social_share_and_follow()->module_dir_url() . 'elementor/widgets/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Editor Preview Style
	 */
	function dtshop_preview_styles() {

		# Social Sahre & Follow
			wp_enqueue_style( 'dtshop-social-share-and-follow' );

	}

}

Dt_Shop_Elementor_Single_Social_Widgets::instance();