<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioCustomTemplate' ) ) {
    class DesignThemesPortfolioCustomTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            add_filter( 'dtm_portfolio_styles', array( $this, 'add_meta_option' ), 1, 1 );
        }

        function load_modules() {
            require_once DT_PORTFOLIO_DIR_PATH . 'single/templates/custom-template/elementor/index.php';
        }

        function add_meta_option( $options ) {
            $options['custom-template'] = esc_html__('Custom Template', 'designthemes-theme');
            return $options;
        }

    }
}

DesignThemesPortfolioCustomTemplate::instance();


class DesignThemesPortfolioCustomTemplateFront {

    public $post_id;

    function __construct( $post_id ) {
        $this->post_id = $post_id;

        add_filter( 'body_class', array( $this, 'body_class' ) );
        add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
        add_action( 'savon_after_enqueue_js', array( $this, 'enqueue_js' ) );
    }

    function body_class( $classes ) {
        $classes[] = 'dtportfolio-custom-template';

        return $classes;
    }

    function enqueue_css() {}

    function enqueue_js() {}
}