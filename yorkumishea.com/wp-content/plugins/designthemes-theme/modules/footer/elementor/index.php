<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesFooterElementor' ) ) {
    class DesignThemesFooterElementor {

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
            add_filter( 'savon_print_footer_template', array( $this, 'register_footer_template' ), 20, 1 );
        }

		function register_footer_template( $id ) {

			$elementor_instance = '';

            if( class_exists( '\Elementor\Plugin' ) ) {
                $elementor_instance = Elementor\Plugin::instance();
            }

            ob_start();

            echo '<footer id="footer" class="dt-footer-tpl footer-' .esc_attr( $id ). '">';
                echo '<div class="container">';
                    if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                        $css_file = new \Elementor\Core\Files\CSS\Post( $id );
                        $css_file->enqueue();

                        echo "{$elementor_instance->frontend->get_builder_content_for_display( $id )}";
                    } else {
                        $footer = get_post( $id );
                        echo apply_filters( 'the_content', $footer->post_content );
                    }
                echo '</div>';
            echo '</footer>';

            $content = ob_get_clean();
            echo apply_filters( 'savon_footer_content', $content );
		}
    }
}

DesignThemesFooterElementor::instance();