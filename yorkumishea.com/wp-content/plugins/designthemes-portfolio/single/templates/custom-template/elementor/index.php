<?php

/**
 * Portfolio - Elementor Custom Template Widgets Core Class
 */

namespace DTElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DesignThemesPortfolioCustomTemplateElementor {

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

		add_action( 'dtportfolio_register_widgets', array( $this, 'dtportfolio_register_widgets' ), 10, 1 );

		add_action( 'dtportfolio_register_widget_styles', array( $this, 'dtportfolio_register_widget_styles' ), 10, 1 );
		add_action( 'dtportfolio_register_widget_scripts', array( $this, 'dtportfolio_register_widget_scripts' ), 10, 1 );

		add_action( 'dtportfolio_preview_styles', array( $this, 'dtportfolio_preview_styles') );

	}


	/**
	 * Register widgets
	 */
	function dtportfolio_register_widgets( $widgets_manager ) {

		# Portfolio Single - Comment Form
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/comment-form/class-widget-portfolio-single-comment-form.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Comment_Form() );

		# Portfolio Single - Comment List
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/comment-list/class-widget-portfolio-single-comment-list.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Comment_List() );

		# Portfolio Single - Custom Details
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/custom-details/class-widget-portfolio-single-custom-details.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Custom_Details() );

		# Portfolio Single - Featured Image
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/featured-image/class-widget-portfolio-single-featured-image.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Featured_Image() );

		# Portfolio Single - Featured Video
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/featured-video/class-widget-portfolio-single-featured-video.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Featured_Video() );

		# Portfolio Single - Gallery Listings
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/gallery-listings/class-widget-portfolio-single-gallery-listings.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Gallery_Listings() );

		# Portfolio Single - Navigation Links
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/navigation-links/class-widget-portfolio-single-navigation-links.php';
            $widgets_manager->register( new Elementor_Portfolio_Single_Navigation_Links() );

        # Portfolio Single - Onepage Navigation Title Holder
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/one-page-navigation/class-widget-portfolio-single-onepage-navigation-title-holder.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_One_Page_Navigation() );

		# Portfolio Single - Sliders
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/sliders/class-widget-portfolio-single-sliders.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Sliders() );

		# Portfolio Single - Terms
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/terms/class-widget-portfolio-single-terms.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Terms() );

		# Portfolio Single - Title
			require DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/widgets/title/class-widget-portfolio-single-title.php';
			$widgets_manager->register( new Elementor_Portfolio_Single_Title() );


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

        # Portfolio Single - Comment Form
            wp_register_style( 'dtportfolio-comment-form',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/comment-form/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Comment List
            wp_register_style( 'dtportfolio-comment-list',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/comment-list/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Custom Details
            wp_register_style( 'dtportfolio-custom-details',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/custom-details/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Featured Image
            wp_register_style( 'dtportfolio-featured-image',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/featured-image/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Featured Video
            wp_register_style( 'dtportfolio-featured-video',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/featured-video/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Gallery Listings
            wp_register_style( 'dtportfolio-gallery-listings',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/gallery-listings/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Navigation Links
            wp_register_style( 'dtportfolio-navigation-links',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/navigation-links/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Onepage Navigation Title Holder
            wp_register_style( 'dtportfolio-one-page-navigation',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/one-page-navigation/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Sliders
            wp_register_style( 'dtportfolio-sliders',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/sliders/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Terms
            wp_register_style( 'dtportfolio-terms',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/terms/assets/css/style'.$suffix.'.css',
                array()
            );

        # Portfolio Single - Title
            wp_register_style( 'dtportfolio-title',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/title/assets/css/style'.$suffix.'.css',
                array()
            );

	}

	/**
	 * Register widgets scripts
	 */
	function dtportfolio_register_widget_scripts( $suffix ) {

        # Library

            wp_register_script( 'jquery-inview',
                DT_PORTFOLIO_DIR_URL . 'assets/js/jquery.inview.js',
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

            wp_register_script( 'jquery-swiper',
                DT_PORTFOLIO_DIR_URL . 'assets/js/swiper.min.js',
                array( 'jquery' ),
                false,
                true
            );

        # Gallery Listings

            wp_register_script( 'dtportfolio-gallery-listings',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/gallery-listings/assets/js/script'.$suffix.'.js',
                array( 'jquery' ),
                false,
                true
            );

        # One Page Navigation

            wp_register_script( 'dtportfolio-one-page-navigation',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/one-page-navigation/assets/js/script'.$suffix.'.js',
                array( 'jquery' ),
                false,
                true
            );

        # Sliders

            wp_register_script( 'dtportfolio-sliders',
                DT_PORTFOLIO_DIR_URL . 'single/templates/custom-template/elementor/widgets/sliders/assets/js/script'.$suffix.'.js',
                array( 'jquery' ),
                false,
                true
            );

	}

	/**
	 * Editor Preview Style
	 */
	function dtportfolio_preview_styles() {

        wp_enqueue_style( 'dtportfolio-animation' );

        # Portfolio Single - Comment Form
            wp_enqueue_style( 'dtportfolio-comment-form' );

        # Portfolio Single - Comment List
            wp_enqueue_style( 'dtportfolio-comment-list' );

        # Portfolio Single - Custom Details
            wp_enqueue_style( 'dtportfolio-custom-details' );

        # Portfolio Single - Featured Image
            wp_enqueue_style( 'dtportfolio-featured-image' );

        # Portfolio Single - Featured Video
            wp_enqueue_style( 'dtportfolio-featured-video' );

        # Portfolio Single - Gallery Listings
            wp_enqueue_style( 'dtportfolio-gallery-listings' );

        # Portfolio Single - Navigation Links
            wp_enqueue_style( 'dtportfolio-navigation-links' );

        # Portfolio Single - Onepage Navigation Title Holder
            wp_enqueue_style( 'dtportfolio-one-page-navigation' );

        # Portfolio Single - Sliders
            wp_enqueue_style( 'dtportfolio-sliders' );

        # Portfolio Single - Terms
            wp_enqueue_style( 'dtportfolio-terms' );

        # Portfolio Single - Title
            wp_enqueue_style( 'dtportfolio-title' );

	}

}

DesignThemesPortfolioCustomTemplateElementor::instance();