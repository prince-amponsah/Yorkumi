<?php

/**
 * WooCommerce - Elementor Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DesignThemesPortfolioElementor {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	const MINIMUM_PHP_VERSION = '7.2';

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

		$this->load_modules();

	}

	/**
	 * Requirement Verification
	 */
	public function load_modules() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'missing_elementor_plugin' ) );
			return;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'minimum_elementor_version' ) );
			return;
		}

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'minimum_php_version' ) );
			return;
		}

		add_action( 'elementor/elements/categories_registered', array( $this, 'dtportfolio_register_category' ) );

		add_action( 'elementor/widgets/register', array( $this, 'dtportfolio_register_widgets' ) );

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'dtportfolio_register_widget_styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'dtportfolio_register_widget_scripts' ) );

		add_action( 'elementor/preview/enqueue_styles', array( $this, 'dtportfolio_preview_styles') );

	}

	public function missing_elementor_plugin() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" recommends "%2$s" to be installed and activated.', 'designthemes-portfolio' ),
			'<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-portfolio' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'designthemes-portfolio' ) . '</strong>'
		);

		printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" recommends "%2$s" version %3$s or greater.', 'designthemes-portfolio' ),
			'<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-portfolio' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'designthemes-portfolio' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" recommends "%2$s" version %3$s or greater.', 'designthemes-portfolio' ),
			'<strong>' . esc_html__( 'DesignThemes Theme Plugin', 'designthemes-portfolio' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'designthemes-portfolio' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Register category
	 * Add plugin category in elementor
	 */
	public function dtportfolio_register_category( $elements_manager ) {

		$elements_manager->add_category(
			'dtportfolio-widgets', array(
				'title' => esc_html__( 'DesignThemes - Portfolio', 'designthemes-portfolio' ),
				'icon'  => 'font'
			)
		);

	}

	/**
	 * Register designthemes widgets
	 */
	public function dtportfolio_register_widgets( $widgets_manager ) {

		do_action( 'dtportfolio_register_widgets', $widgets_manager );

	}

	/**
	 * Register designthemes widgets styles
	 */
	public function dtportfolio_register_widget_styles() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';

		do_action( 'dtportfolio_register_widget_styles', $suffix );

	}

	/**
	 * Register designthemes widgets scripts
	 */
	public function dtportfolio_register_widget_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';

		do_action( 'dtportfolio_register_widget_scripts', $suffix );

	}

	/**
	 * Editor Preview Style
	 */
	public function dtportfolio_preview_styles() {

		do_action( 'dtportfolio_preview_styles' );

	}

}

DesignThemesPortfolioElementor::instance();