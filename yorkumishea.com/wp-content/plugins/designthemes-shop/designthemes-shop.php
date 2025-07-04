<?php
/*
 * Plugin Name:	DesignThemes Shop
 * URI: 		http://wedesignthemes.com/plugins/designthemes-shop
 * Description: A simple wordpress plugin designed to implement <strong>Shop</strong> by designthemes
 * Version: 	1.1
 * Author: 		DesignThemes
 * Text Domain: dtshop
 * Author URI:	http://themeforest.net/user/designthemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main class that initiates and runs the plugin.
 */
final class Dt_Shop {

	/**
	 * Instance variable
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
	public function __construct() {

		add_action( 'init', array( $this, 'dtshop_i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'dtshop_plugins_loaded' ) );

	}

	/**
	 * Load Textdomain
	 */
		public function dtshop_i18n() {
			load_plugin_textdomain( 'dtshop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

	/**
	 * Initialize the plugin
	 */
		public function dtshop_plugins_loaded() {

			// Check for WooCommerce plugin
				if( !function_exists( 'is_woocommerce' ) ) {
					add_action( 'admin_notices', array( $this, 'dtshop_woo_plugin_req' ) );
					return;
				}

			// Check for DesignThemes Theme plugin
				if( !function_exists( 'dt_theme' ) ) {
					add_action( 'admin_notices', array( $this, 'dtshop_dttheme_plugin_req' ) );
					return;
				}

			// Setup Constants
				$this->dtshop_setup_constants();

			// Load Modules
				$this->dtshop_load_modules();

			// Locate Module Files
				add_filter( 'dt_theme_woo_locate_file',  array( $this, 'dtshop_woo_locate_file' ), 10, 2 );

			// Load WooCommerce Template Files
				add_filter( 'woocommerce_locate_template',  array( $this, 'dtshop_woocommerce_locate_template' ), 30, 3 );

		}


	/**
	 * Admin notice
	 * Warning when the site doesn't have WooCommerce plugin.
	 */
		public function dtshop_woo_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'dtshop' ),
				'<strong>' . esc_html__( 'DesignThemes Shop', 'dtshop' ) . '</strong>',
				'<strong>' . esc_html__( 'WooCommerce - excelling eCommerce', 'dtshop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Admin notice
	 * Warning when the site doesn't have DesignThemes Theme plugin.
	 */
		public function dtshop_dttheme_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'dtshop' ),
				'<strong>' . esc_html__( 'DesignThemes Shop', 'dtshop' ) . '</strong>',
				'<strong>' . esc_html__( 'DesignThemes Theme', 'dtshop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Define constant if not already set.
	 */
		public function dtshop_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

	/**
	 * Configure Constants
	 */
		public function dtshop_setup_constants() {

			$this->dtshop_define_constants( 'DTSHOP_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->dtshop_define_constants( 'DTSHOP_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
			$this->dtshop_define_constants( 'DTSHOP_PLUGIN_NAME', esc_html__('DesignThemes Shop', 'dtshop') );

			$this->dtshop_define_constants( 'DTSHOP_PLUGIN_MODULE_PATH', trailingslashit( DTSHOP_PLUGIN_PATH . 'modules' ) );
			$this->dtshop_define_constants( 'DTSHOP_PLUGIN_MODULE_URL', trailingslashit( DTSHOP_PLUGIN_URL . 'modules' ) );

		}

	/**
	 * Load Modules
	 */
		public function dtshop_load_modules() {

			foreach( glob( DTSHOP_PLUGIN_MODULE_PATH. '*/index.php' ) as $module ) {
				include_once $module;
			}

		}

	/**
	 * Locate Module Files
	 */
		public function dtshop_woo_locate_file( $file_path, $module ) {

			$plugin_file_path = apply_filters( 'dtshop_woo_locate_file', '', $module);

			if( $plugin_file_path ) {
				$file_path = $plugin_file_path;
			} else {
				$file_path = DTSHOP_PLUGIN_PATH . 'modules/' . $module .'.php';
			}

			$located_file_path = false;
			if ( $file_path && file_exists( $file_path ) ) {
				$located_file_path = $file_path;
			}

			return $located_file_path;

		}

	/**
	 * Override WooCommerce default template files
	 */
		public function dtshop_woocommerce_locate_template( $template, $template_name, $template_path ) {

			global $woocommerce;

			$_template = $template;

			if ( ! $template_path ) $template_path = $woocommerce->template_url;

			$plugin_path  = DTSHOP_PLUGIN_PATH . 'templates/';

			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					$template_path . $template_name,
					$template_name
				)
			);

			// Modification: Get the template from this plugin, if it exists
			if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

			// Use default template
			if ( ! $template )
			$template = $_template;

			// Return what we found
			return $template;

		}

}

if( !function_exists('dtshop_instance') ) {
	function dtshop_instance() {
		return Dt_Shop::instance();
	}
}

dtshop_instance();