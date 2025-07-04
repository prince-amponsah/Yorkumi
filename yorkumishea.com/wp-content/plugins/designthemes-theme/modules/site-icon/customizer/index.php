<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteIcon' ) ) {
    class CustomizerSiteIcon {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-icon-section',
                    array(
                        'title'    => esc_html__('Site Icon', 'designthemes-theme'),
                        'panel'    => 'site-identity-main-panel',
                        'priority' => 20,
                    )
                )
            );

            $wp_customize->get_control('site_icon')->section = 'site-icon-section';           
        }

    }
}

CustomizerSiteIcon::instance();          