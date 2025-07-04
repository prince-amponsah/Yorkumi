<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPostCustomModern' ) ) {
    class DesignThemesPostCustomModern {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtm_post_styles', array( $this, 'add_post_styles_option' ) );
        }

        function add_post_styles_option( $options ) {
            $options['custom-modern'] = esc_html__('Modern', 'designthemes-theme');
            return $options;
        }
    }
}

DesignThemesPostCustomModern::instance();