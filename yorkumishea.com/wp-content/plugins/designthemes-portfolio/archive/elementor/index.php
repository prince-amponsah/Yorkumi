<?php

/**
 * Portfolio - Elementor Custom Template Widgets Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DesignThemesPortfolioArchiveElementor {

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

        $this->load_files();

		add_action( 'dtportfolio_register_widgets', array( $this, 'dtportfolio_register_widgets' ), 10, 1 );

		add_action( 'dtportfolio_register_widget_styles', array( $this, 'dtportfolio_register_widget_styles' ), 10, 1 );
		add_action( 'dtportfolio_register_widget_scripts', array( $this, 'dtportfolio_register_widget_scripts' ), 10, 1 );

		add_action( 'dtportfolio_preview_styles', array( $this, 'dtportfolio_preview_styles') );

	}


	/**
	 * Load Files
	 */
	function load_files() {

		require DT_PORTFOLIO_DIR_PATH . 'archive/templates/utils.php';

	}


	/**
	 * Register widgets
	 */
	function dtportfolio_register_widgets( $widgets_manager ) {

		# Portfolio Single - Comment Form
			require DT_PORTFOLIO_DIR_PATH . 'archive/elementor/widgets/portfolio-listing/class-widget-portfolio-listing.php';
			$widgets_manager->register( new Elementor_Portfolio_Listing() );

	}

	/**
	 * Register widgets styles
	 */
	function dtportfolio_register_widget_styles( $suffix ) {

        # Library

            wp_register_style( 'dtportfolio-animation',
                DT_PORTFOLIO_DIR_URL . 'assets/css/animations.css',
                array()
            );

            wp_register_style( 'ilightbox',
                DT_PORTFOLIO_DIR_URL . 'assets/css/ilightbox.css',
                array()
            );

            wp_register_style( 'swiper',
                DT_PORTFOLIO_DIR_URL . 'assets/css/swiper.min.css',
                array()
            );

        # Portfolio Listing

            wp_register_style( 'dtportfolio-common',
                DT_PORTFOLIO_DIR_URL . 'assets/css/common'.$suffix.'.css',
                array()
            );

            wp_register_style( 'dtportfolio-listing',
                DT_PORTFOLIO_DIR_URL . 'archive/elementor/widgets/portfolio-listing/assets/css/style'.$suffix.'.css',
                array()
            );


	}

	/**
	 * Register widgets scripts
	 */
	function dtportfolio_register_widget_scripts( $suffix ) {

        # Library

            wp_register_script( 'isotope-pkgd',
                DT_PORTFOLIO_DIR_URL . 'assets/js/isotope.pkgd.min.js',
                array( 'jquery' ),
                false,
                true
            );

            wp_register_script( 'jquery-swiper',
                DT_PORTFOLIO_DIR_URL . 'assets/js/swiper.min.js',
                array( 'jquery' ),
                false,
                true
            );

            wp_register_script( 'jquery-ilightbox',
                DT_PORTFOLIO_DIR_URL . 'assets/js/ilightbox.min.js',
                array( 'jquery' ),
                false,
                true
            );

            wp_register_script( 'jquery-inview',
                DT_PORTFOLIO_DIR_URL . 'assets/js/jquery.inview.js',
                array( 'jquery' ),
                false,
                true
            );

            wp_register_script( 'jquery-nicescroll',
                DT_PORTFOLIO_DIR_URL . 'assets/js/jquery.nicescroll.js',
                array( 'jquery' ),
                false,
                true
            );

        # Portfolio Listing

            wp_register_script( 'dtportfolio-listing',
                DT_PORTFOLIO_DIR_URL . 'archive/elementor/widgets/portfolio-listing/assets/js/scripts'.$suffix.'.js',
                array( 'jquery' ),
                false,
                true
            );

            wp_localize_script('dtportfolio-listing', 'dtportfoliofrontendobject', array (
                'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
            ));

	}

	/**
	 * Editor Preview Style
	 */
	function dtportfolio_preview_styles() {

        wp_enqueue_style( 'dtportfolio-animation' );
        wp_enqueue_style( 'ilightbox' );
        wp_enqueue_style( 'swiper' );
        wp_enqueue_style( 'dtportfolio-listing' );

	}

}

DesignThemesPortfolioArchiveElementor::instance();