<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPostCustom' ) ) {
    class DesignThemesPostCustom {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtm_post_styles', array( $this, 'add_post_styles_option' ), 15 );
        }

        function add_post_styles_option( $options ) {
            $options['custom-style'] = esc_html__('Custom Template', 'designthemes-theme');
            return $options;
        }
    }
}

DesignThemesPostCustom::instance();