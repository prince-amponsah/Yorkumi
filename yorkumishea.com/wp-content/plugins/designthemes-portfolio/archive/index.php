<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchive' ) ) {
    class DesignThemesPortfolioArchive {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            add_action('after_setup_theme', array( $this, 'after_theme_setup' ) );
        }

        function load_modules() {
            require_once DT_PORTFOLIO_DIR_PATH . 'archive/elementor/index.php';
            require_once DT_PORTFOLIO_DIR_PATH . 'archive/core/index.php';
        }

        function after_theme_setup() {

            if ( function_exists( 'add_theme_support' ) ) {
                add_image_size( 'dtportfolio-635x1100', 635, 1100, true  );
                add_image_size( 'dtportfolio-750x650', 750, 650, true  );
                add_image_size( 'dtportfolio-450x450', 450, 450, true  );
                add_image_size( 'dtportfolio-420x420', 420, 420, true  );
            }

        }

    }
}

DesignThemesPortfolioArchive::instance();