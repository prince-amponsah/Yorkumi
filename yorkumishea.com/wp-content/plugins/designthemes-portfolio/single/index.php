<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioPost' ) ) {
    class DesignThemesPortfolioPost {

        private static $_instance  = null;
        private $post_style = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_files();
            $this->load_single_styles();
            $this->frontend();
        }

        function load_files() {
            include_once DT_PORTFOLIO_DIR_PATH . 'single/helper.php';
            include_once DT_PORTFOLIO_DIR_PATH . 'single/metabox/index.php';
        }

        function load_single_styles() {
            foreach( glob( DT_PORTFOLIO_DIR_PATH. 'single/templates/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function frontend() {
            add_filter('single_template', array($this, 'load_template'));
        }

        function load_template( $template ) {
            global $post;

            if( !empty( $post ) && 'dt_portfolios' == $post->post_type ) {

                $settings = get_post_meta( get_queried_object_id(), '_dt_portfolio_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) && !empty( $settings['layout'] ) ) {
                    $this->post_style = $settings['layout'];
                    $template = DT_PORTFOLIO_DIR_PATH . 'single/templates/'. $settings['layout'] . '/single.php';
                } else {
                    $this->post_style = 'custom-template';
                    $template = DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/single.php';
                }

                $this->enqueue_files();
                $this->call_front_class( get_queried_object_id(), $this->post_style );

            }

            return $template;
        }

        function enqueue_files() {
            add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
        }

        function enqueue_css() {
            wp_enqueue_style( 'dtportfolio-common', DT_PORTFOLIO_DIR_URL . 'assets/css/common.css', false, DT_PORTFOLIO_VERSION, 'all' );
            wp_enqueue_style( 'dtportfolio-single', DT_PORTFOLIO_DIR_URL . 'single/assets/css/style.css', false, DT_PORTFOLIO_VERSION, 'all');
        }

        function call_front_class( $post_id, $post_style ) {

            if( !empty( $post_style ) ) {

                $class = str_replace( "-", " ", $post_style );
                $class = ucwords( $class );
                $class = str_replace(" ","", $class );
                $class = trim( "DesignThemesPortfolio".$class."Front" );
                if( class_exists( $class ) ) {
                    new $class( $post_id );
                }
            }
        }

    }
}

DesignThemesPortfolioPost::instance();