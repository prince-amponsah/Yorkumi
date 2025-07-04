<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Dt_Shop_Elementor_Single_Widgets {

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

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets
	 */
	function dtshop_register_widgets( $widgets_manager ) {

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/images-carousel/class-product-images-carousel.php';
		$widgets_manager->register( new DTShop_Widget_Product_Images_Carousel() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/images-default/class-product-images-default.php';
		$widgets_manager->register( new DTShop_Widget_Product_Images_Default() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/images-list/class-product-images-list.php';
		$widgets_manager->register( new DTShop_Widget_Product_Images_List() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/product-tabs/class-product-tabs.php';
		$widgets_manager->register( new DTShop_Widget_Product_Tabs() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/product-tabs-exploded/class-product-tabs-exploded.php';
		$widgets_manager->register( new DTShop_Widget_Product_Tabs_Exploded() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/related-products/class-related-products.php';
		$widgets_manager->register( new DTShop_Widget_Related_Products() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/summary/class-product-summary.php';
		$widgets_manager->register( new DTShop_Widget_Product_Summary() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/summary-nav-bar/class-product-summary-nav-bar.php';
		$widgets_manager->register( new DTShop_Widget_Product_Summary_Nav_bar() );

		require dt_shop_single_module_custom_template()->module_dir_path() . 'elementor/widgets/upsell-products/class-upsell-products.php';
		$widgets_manager->register( new DTShop_Widget_Upsell_Products() );




	}

	/**
	 * Register widgets styles
	 */
	function dtshop_register_widget_styles( $suffix ) {

		# Images Carousel

			wp_register_style( 'swiper',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/images-carousel/assets/css/swiper.min'.$suffix.'.css',
				array()
			);

			wp_register_style( 'dtshop-product-single-images-carousel',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/images-carousel/assets/css/style'.$suffix.'.css',
				array()
			);

		# Images List

			wp_register_style( 'dtshop-product-single-images-list',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/images-list/assets/css/style'.$suffix.'.css',
				array()
			);

		# Product Tabs

			wp_register_style( 'dtshop-product-single-tabs',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/product-tabs/assets/css/style'.$suffix.'.css',
				array()
			);

		# Product Tabs Exploded

			wp_register_style( 'dtshop-product-single-tabs-exploded',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/product-tabs-exploded/assets/css/style'.$suffix.'.css',
				array()
			);

		# Related Products

			wp_register_style( 'dtshop-product-single-related-products',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/related-products/assets/css/style'.$suffix.'.css',
				array()
			);

		# Summary

			wp_register_style( 'dtshop-product-single-summary',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/summary/assets/css/style'.$suffix.'.css',
				array()
			);

		# Summary Nav Bar

			wp_register_style( 'dtshop-product-single-summary-nav-bar',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/summary-nav-bar/assets/css/style'.$suffix.'.css',
				array()
			);

		# Upsell Products

			wp_register_style( 'dtshop-product-single-upsell-products',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/upsell-products/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function dtshop_register_widget_scripts( $suffix ) {

		# Libraries

			wp_register_script( 'jquery-nicescroll',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/assets/js/jquery.nicescroll'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

		# Images Carousel

			wp_register_script( 'jquery-swiper',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/images-carousel/assets/js/swiper.min'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_register_script( 'dtshop-product-single-images-carousel',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/images-carousel/assets/js/script'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

		# Images List

			wp_register_script( 'dtshop-product-single-images-list',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/images-list/assets/js/script'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

		# Product Tabs - Exploded

			wp_register_script( 'dtshop-product-single-tabs-exploded',
				dt_shop_single_module_custom_template()->module_dir_url() . 'elementor/widgets/product-tabs-exploded/assets/js/script'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

	}

	/**
	 * Editor Preview Style
	 */
	function dtshop_preview_styles() {

		# Images Carousel
			wp_enqueue_style( 'swiper' );
			wp_enqueue_style( 'dtshop-product-single-images-carousel' );

		# Images List
			wp_enqueue_style( 'dtshop-product-single-images-list' );

		# Product Tabs
			wp_enqueue_style( 'dtshop-product-single-tabs' );

		# Product Tabs Exploded
			wp_enqueue_style( 'dtshop-product-single-tabs-exploded' );

		# Related Products
			wp_enqueue_style( 'dtshop-product-single-related-products' );

		# Summary
			wp_enqueue_style( 'dtshop-product-single-summary' );

		# Summary Nav Bar
			wp_enqueue_style( 'dtshop-product-single-summary-nav-bar' );

		# Upsell Products
			wp_enqueue_style( 'dtshop-product-single-upsell-products' );

	}

}

Dt_Shop_Elementor_Single_Widgets::instance();