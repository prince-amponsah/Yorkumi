<?php

/**
 * WooCommerce - Elementor Listings Widgets Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Dt_Theme_Elementor_Listings_Widgets {

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

		require DT_THEME_DIR_PATH . 'modules/woocommerce/listings/elementor/widgets/products/shortcodes.php';

	}

	/**
	 * Register widgets
	 */
	function dtshop_register_widgets( $widgets_manager ) {

		require DT_THEME_DIR_PATH . 'modules/woocommerce/listings/elementor/widgets/products/class-widget-products.php';
		$widgets_manager->register( new DTShop_Widget_Products() );

	}

	/**
	 * Register widgets styles
	 */
	function dtshop_register_widget_styles( $suffix ) {

		# Swiper
			wp_register_style( 'swiper',
				DT_THEME_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/css/swiper.min'.$suffix.'.css',
				array()
			);

		# Carousel
			wp_register_style( 'dtshop-products-carousel',
				SAVON_MODULE_URI . '/woocommerce/assets/css/carousel.css',
				array()
			);

		# Products
			wp_register_style( 'dtshop-products',
				DT_THEME_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function dtshop_register_widget_scripts( $suffix ) {

		# Swiper
			wp_register_script( 'jquery-swiper',
				DT_THEME_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/js/swiper.min'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

		# Products
			wp_register_script( 'dtshop-products',
				DT_THEME_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/js/script'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_localize_script('dtshop-products', 'dtshopScObjects',  array (
				'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
			));


	}

	/**
	 * Editor Preview Style
	 */
	function dtshop_preview_styles() {

		# Products
			wp_enqueue_style( 'swiper' );
			wp_enqueue_style( 'dtshop-products' );

	}

}

Dt_Theme_Elementor_Listings_Widgets::instance();