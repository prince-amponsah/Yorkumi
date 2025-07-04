<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Dt_Shop_Elementor_Single_Additional_Tabs_Widgets {

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

		add_action( 'dtshop_register_widgets', array( $this, 'dtshop_register_widgets' ), 10, 1 );

		add_action( 'dtshop_register_widget_styles', array( $this, 'dtshop_register_widget_styles' ), 10, 1 );
		add_action( 'dtshop_register_widget_scripts', array( $this, 'dtshop_register_widget_scripts' ), 10, 1 );

		add_action( 'dtshop_preview_styles', array( $this, 'dtshop_preview_styles') );

	}

	/**
	 * Init
	 */
	function dtshop_load_modules() {

		require dt_shop_single_module_additional_tabs()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets
	 */
	function dtshop_register_widgets( $widgets_manager ) {

		require dt_shop_single_module_additional_tabs()->module_dir_path() . 'elementor/widgets/product-tabs-exploded/class-product-tabs-exploded.php';
		$widgets_manager->register( new DTShop_Widget_Product_Additional_Tabs_Exploded() );

	}

	/**
	 * Register widgets styles
	 */
	function dtshop_register_widget_styles( $suffix ) {

		# Product Tabs Exploded

			wp_register_style( 'dtshop-product-single-additional-tabs-exploded',
				dt_shop_single_module_additional_tabs()->module_dir_url() . 'assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function dtshop_register_widget_scripts( $suffix ) {

		# Product Tabs - Exploded

			wp_register_script( 'jquery-nicescroll',
				dt_shop_single_module_additional_tabs()->module_dir_url() . 'assets/js/jquery.nicescroll'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_register_script( 'dtshop-product-single-additional-tabs-exploded',
				dt_shop_single_module_additional_tabs()->module_dir_url() . 'assets/js/scripts'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

	}

	/**
	 * Editor Preview Style
	 */
	function dtshop_preview_styles() {

		# Product Tabs - Exploded
			wp_enqueue_style( 'dtshop-product-single-additional-tabs-exploded' );

	}

}

Dt_Shop_Elementor_Single_Additional_Tabs_Widgets::instance();