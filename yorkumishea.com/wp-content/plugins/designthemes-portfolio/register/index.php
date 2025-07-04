<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DTRegisterPortfolioCPT' ) ) {
    class DTRegisterPortfolioCPT {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            add_action( 'admin_init', array( $this, 'permalinks_save' ) );
        }

        function load_modules() {
            include_once DT_PORTFOLIO_DIR_PATH.'register/post-type-portfolio.php';
            include_once DT_PORTFOLIO_DIR_PATH.'register/taxonomy-category.php';
            include_once DT_PORTFOLIO_DIR_PATH.'register/taxonomy-tag.php';
            include_once DT_PORTFOLIO_DIR_PATH.'register/taxonomy-custom-fields.php';
        }

        function permalinks_save() {
            if ( isset( $_POST['permalink_structure'] ) && isset( $_POST['dt_portfolios'] ) ) {
                $permalinks = (array) get_option( DT_PORTFOLIO_OPTION, array() );
                foreach(  $_POST['dt_portfolios'] as $key => $value ) {
                    $permalinks[$key] = $value;
                }
                update_option( DT_PORTFOLIO_OPTION, $permalinks );
            }
        }
    }
}

DTRegisterPortfolioCPT::instance();