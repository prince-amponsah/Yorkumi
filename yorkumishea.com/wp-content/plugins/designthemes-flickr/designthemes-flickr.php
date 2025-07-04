<?php
/*
 * Plugin Name:	DesignThemes Flickr
 * URI: 		http://wedesignthemes.com/plugins/designthemes-flickr
 * Description: A simple wordpress plugin designed to implements <strong>Flickr Widget</strong> by designthemes
 * Version: 	1.0
 * Author: 		DesignThemes
 * Text Domain: dt-flickr
 * Author URI:	http://themeforest.net/user/designthemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main class that initiates and runs the plugin.
 */
final class DTFlickr {

	/**
	 * Minimum PHP Version
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance variable
	 */
	private static $_instance = null;

	/**
	 * Base Plugin URL
	 */
	private $plugin_url = null;	

	/**
	 * Base Plugin Path
	 */
	private $plugin_path = null;

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
		
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Textdomain
	 */
	public function i18n() {

		load_plugin_textdomain( 'dt-flickr', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Initialize the plugin
	 */
	public function init() {

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'minimum_php_version' ) );
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'dt_flickr_enqueue_scripts' ) );
		add_action( 'widgets_init', array( $this, 'dt_widgets_init' ) );
		require_once $this->plugin_path( 'widget-flickr.php' );
	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required PHP version.
	 */
	public function minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'dt-flickr' ),
			'<strong>' . esc_html__( 'DesignThemes Flickr', 'dt-flickr' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'dt-flickr' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Returns path to file or dir inside plugin folder
	 */
	public function plugin_path( $path = null ) {

		if ( ! $this->plugin_path ) {
			$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		}

		return $this->plugin_path . $path;
	}

	/**
	 * Returns url to file or dir inside plugin folder
	 */
	public function plugin_url( $path = null ) {

		if ( ! $this->plugin_url ) {
			$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
		}

		return $this->plugin_url . $path;
	}

	/**
	 * Register widgets
	 * Add DesignThemes flickr widget
	 */
	public function dt_widgets_init() {
		register_widget('DThemes_widget_Flickr');
	}

	/**
	 * Enqueue styles for flickr widget
	 */
	public function dt_flickr_enqueue_scripts() {
		wp_enqueue_style ( 'dt-flickr', $this->plugin_url() . 'css/dtflickr.css', array(), false, 'all' );
	}
}

if( !function_exists('dt_flickr') ) {

	function dt_flickr() {
		return DTFlickr::instance();
	}
}

dt_flickr();