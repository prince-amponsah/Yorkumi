<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Metabox_Single_Additional_Tabs' ) ) {
    class Dt_Shop_Metabox_Single_Additional_Tabs {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtshop_product_custom_settings', array( $this, 'dtshop_product_custom_settings' ), 10 );
        }

        function dtshop_product_custom_settings( $options ) {

			$elementor_template_args = array (
				'numberposts' => -1,
				'post_type'   => 'elementor_library',
				'fields'      => 'ids'
			);

			$elementor_templates_arr = get_posts ($elementor_template_args);

			$elementor_templates = array ( '' => esc_html__('None', 'designthemes-theme'), 'custom-description' => esc_html__('Custom Description', 'designthemes-theme') );
			foreach($elementor_templates_arr as $elementor_template) {
				$elementor_templates[$elementor_template] = get_the_title($elementor_template);
			}

			$product_options = array (

				array (
					'id'              => 'product-additional-tabs',
					'type'            => 'group',
					'title'           => esc_html__('Additional Tabs', 'designthemes-theme'),
					'info'            => esc_html__('Click button to add title and description.', 'designthemes-theme'),
					'button_title'    => esc_html__('Add New Tab', 'designthemes-theme'),
					'accordion_title' => esc_html__('Adding New Tab Field', 'designthemes-theme'),
					'fields'          => array (

						array (
							'id'          => 'tab_title',
							'type'        => 'text',
							'title'       => esc_html__('Title', 'designthemes-theme'),
						),

						array (
							'id'         => 'tab_description',
							'type'       => 'select',
							'title'      => esc_html__('Description', 'designthemes-theme'),
							'options'    => $elementor_templates,
							'info'       => esc_html__('Choose "Elementor Templates" here to use for "Description", if you choose "Custom Description" option you can provide your own content below.', 'designthemes-theme'),
							'attributes' => array ( 'data-depend-id' => 'tab_description' )
						),

						array (
							'id'         => 'tab_custom_description',
							'type'       => 'textarea',
							'title'      => esc_html__('Custom Description', 'designthemes-theme'),
							'dependency' => array ( 'tab_description', '==', 'custom-description' )
						)

					)
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Dt_Shop_Metabox_Single_Additional_Tabs::instance();