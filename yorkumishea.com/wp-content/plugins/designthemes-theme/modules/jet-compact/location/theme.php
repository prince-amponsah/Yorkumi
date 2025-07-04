<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'JetLocationTheme' ) ) {
    class JetLocationTheme {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            $map = $this->get_map();

            if( !empty( $map ) ) {

                foreach ($map as $hook => $location ) {

                    add_action( $hook, array( $this, 'process_location' ), -999 );
                }
            }
        }

        public function get_map() {

            $site_header = dt_customizer_settings( 'site_header' );
            if( $site_header == 'standard-header' ) {
                return false;
            }

            return array(
                'savon_header'         => 'header',
                'savon_elemtor_footer' => 'footer'
            );
        }

        public function process_location() {
            $hook     = current_filter();
            $map      = $this->get_map();
            $location = ! empty( $map[ $hook ] ) ? $map[ $hook ] : false;

            if ( ! $location ) {
                return;
            }

            $done = $this->do_location( $location );
            if ( $done ) {
                remove_all_actions( $hook );
            }            
        }

        /**
         * Try to do theme core location
         */
        public function do_location( $name = 'header' ) {

            if ( ! function_exists( 'jet_theme_core' ) ) {
                return false;
            }

            if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
                return false;
            }

            $done = jet_theme_core()->locations->do_location( $name );

            return $done;

        }        
    }
}

JetLocationTheme::instance();