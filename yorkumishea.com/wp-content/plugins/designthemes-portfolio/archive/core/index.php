<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveCore' ) ) {
    class DesignThemesPortfolioArchiveCore {

        private static $_instance = null;
        private $page_layout      = '';
        private $sidebar          = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->frontend();
        }

        function frontend() {
            add_filter( 'template_include', array( $this, 'load_template' ) );
            add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
            add_action( 'savon_after_enqueue_js', array( $this, 'enqueue_js' ) );

            add_filter('savon_primary_classes', array( $this, 'primary_classes' ) );
            add_filter('savon_secondary_classes', array( $this, 'secondary_classes' ) );
            add_filter('savon_active_sidebars', array( $this, 'active_sidebars' ) );
        }

        function load_template( $template ) {
            if( is_tax('dt_portfolio_cats') || is_tax('dt_portfolio_tags') ){
                $template = DT_PORTFOLIO_DIR_PATH . 'archive/core/tpl-portfolio-archive.php';
            }

            return $template;
        }

        function enqueue_css() {

            if( is_tax('dt_portfolio_cats') || is_tax('dt_portfolio_tags') ){

                wp_enqueue_style( 'ilightbox', DT_PORTFOLIO_DIR_URL . 'assets/css/ilightbox.css', array() );
                wp_enqueue_style( 'dtportfolio-common', DT_PORTFOLIO_DIR_URL . 'assets/css/common.css', array () );
                wp_enqueue_style( 'dtportfolio-listing', DT_PORTFOLIO_DIR_URL . 'archive/elementor/widgets/portfolio-listing/assets/css/style.css', array () );

            }

        }

        function enqueue_js() {

            if( is_tax('dt_portfolio_cats') || is_tax('dt_portfolio_tags') ){

                wp_enqueue_script( 'isotope-pkgd', DT_PORTFOLIO_DIR_URL . 'assets/js/isotope.pkgd.min.js', array( 'jquery' ), false, true );

                wp_enqueue_script( 'jquery-ilightbox', DT_PORTFOLIO_DIR_URL . 'assets/js/ilightbox.min.js', array( 'jquery' ), false, true );

                wp_enqueue_script( 'dtportfolio-listing', DT_PORTFOLIO_DIR_URL . 'archive/elementor/widgets/portfolio-listing/assets/js/scripts.js', array( 'jquery' ), false, true );
                wp_localize_script('dtportfolio-listing', 'dtportfoliofrontendobject', array (
                    'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
                ));

            }

        }

        function primary_classes( $primary_class ) {

            if( is_tax('dt_portfolio_cats') || is_tax('dt_portfolio_tags') ){

                $primary_class = dt_customizer_settings('portfolio_archive_layout');
                $sidebars      = dt_customizer_settings('portfolio_archive_sidebar');

                if( $primary_class == 'with-left-sidebar' || $primary_class == 'with-right-sidebar' ) {
                    $primary_class = empty( $sidebars ) ?  'content-full-width' : $primary_class;
                } else {
                    $primary_class = 'content-full-width';
                }

                if( $primary_class == 'with-left-sidebar' ) {
                    $primary_class = 'page-with-sidebar with-left-sidebar';
                }elseif( $primary_class == 'with-right-sidebar' ) {
                    $primary_class = 'page-with-sidebar with-right-sidebar';
                }

            }

            return $primary_class;
        }

        function secondary_classes ( $secondary_class ) {

            if( is_tax('dt_portfolio_cats') || is_tax('dt_portfolio_tags') ){

                $secondary_class = dt_customizer_settings('portfolio_archive_layout');

                if( $secondary_class == 'with-left-sidebar' ) {
                    $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
                }elseif( $secondary_class == 'with-right-sidebar' ) {
                    $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
                }
            }

            return $secondary_class;
        }

        function active_sidebars( $sidebars = array() ) {
            if( is_tax('dt_portfolio_cats') || is_tax('dt_portfolio_tags') ){
                $sidebars = dt_customizer_settings('portfolio_archive_sidebar');
                if( $sidebars ) {
                    $sidebars = array( $sidebars );
                } else {
                    $sidebars = array();
                }
            }

            return array_filter( $sidebars );
        }

    }
}

DesignThemesPortfolioArchiveCore::instance();