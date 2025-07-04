<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesHeaderElementor' ) ) {
    class DesignThemesHeaderElementor {

        private static $_instance = null;

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
            add_filter( 'savon_print_header_template', array( $this, 'register_header_template' ), 10, 1 );
        }

		function register_header_template( $id ) {

			$elementor_instance = '';

            if( class_exists( '\Elementor\Plugin' ) ) {
                $elementor_instance = Elementor\Plugin::instance();
            }

            ob_start();

            echo '<div id="header-'.esc_attr( $id ).'" class="dt-header-tpl header-' .esc_attr( $id ). '">';

                if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                    $css_file = new \Elementor\Core\Files\CSS\Post( $id );
                    $css_file->enqueue();

                    echo "{$elementor_instance->frontend->get_builder_content_for_display( $id )}";
                } else {
                    $header = get_post( $id );
                    echo apply_filters( 'the_content', $header->post_content );
                }

            echo '</div>';

            $content = ob_get_clean();
            echo apply_filters( 'savon_header_content', $content );
		}
    }
}

DesignThemesHeaderElementor::instance();