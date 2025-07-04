<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Metabox_Single_360_Viewer' ) ) {
    class Dt_Shop_Metabox_Single_360_Viewer {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'product_options' ) );
        }

        function product_options( $options ) {

			$options[] = array(
				'id'        => '_360viewer_gallery',
				'title'     => esc_html__('Product 360 View Gallery','designthemes-theme'),
				'post_type' => 'product',
				'context'   => 'side',
				'priority'  => 'low',
				'sections'  => array(
							array(
							'name'   => '360view_section',
							'fields' =>  array(
											array (
												'id'          => 'product-360view-gallery',
												'type'        => 'gallery',
												'title'       => esc_html__('Gallery Images', 'designthemes-theme'),
												'desc'        => esc_html__('Simply add images to gallery items.', 'designthemes-theme'),
												'add_title'   => esc_html__('Add Images', 'designthemes-theme'),
												'edit_title'  => esc_html__('Edit Images', 'designthemes-theme'),
												'clear_title' => esc_html__('Remove Images', 'designthemes-theme'),
											)
										)
							)
							)
			);

			return $options;

		}

    }
}

Dt_Shop_Metabox_Single_360_Viewer::instance();