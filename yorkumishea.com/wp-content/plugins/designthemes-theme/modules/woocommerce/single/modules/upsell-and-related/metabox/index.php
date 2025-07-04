<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Metabox_Single_Upsell_Related' ) ) {
    class Dt_Shop_Metabox_Single_Upsell_Related {

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

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('dt_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'designthemes-theme'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'designthemes-theme' ),
							'true'         => esc_html__( 'Show', 'designthemes-theme'),
							null           => esc_html__( 'Hide', 'designthemes-theme'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'designthemes-theme'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'designthemes-theme' ),
						1              => esc_html__( 'One Column', 'designthemes-theme' ),
						2              => esc_html__( 'Two Columns', 'designthemes-theme' ),
						3              => esc_html__( 'Three Columns', 'designthemes-theme' ),
						4              => esc_html__( 'Four Columns', 'designthemes-theme' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'designthemes-theme'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'designthemes-theme' ),
						1              => esc_html__( 'One', 'designthemes-theme' ),
						2              => esc_html__( 'Two', 'designthemes-theme' ),
						3              => esc_html__( 'Three', 'designthemes-theme' ),
						4              => esc_html__( 'Four', 'designthemes-theme' ),
						5              => esc_html__( 'Five', 'designthemes-theme' ),
						6              => esc_html__( 'Six', 'designthemes-theme' ),
						7              => esc_html__( 'Seven', 'designthemes-theme' ),
						8              => esc_html__( 'Eight', 'designthemes-theme' ),
						9              => esc_html__( 'Nine', 'designthemes-theme' ),
						10              => esc_html__( 'Ten', 'designthemes-theme' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'designthemes-theme'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'designthemes-theme' ),
							'true'         => esc_html__( 'Show', 'designthemes-theme'),
							null           => esc_html__( 'Hide', 'designthemes-theme'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'designthemes-theme'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'designthemes-theme' ),
						2              => esc_html__( 'Two Columns', 'designthemes-theme' ),
						3              => esc_html__( 'Three Columns', 'designthemes-theme' ),
						4              => esc_html__( 'Four Columns', 'designthemes-theme' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'designthemes-theme'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'designthemes-theme' ),
						1              => esc_html__( 'One', 'designthemes-theme' ),
						2              => esc_html__( 'Two', 'designthemes-theme' ),
						3              => esc_html__( 'Three', 'designthemes-theme' ),
						4              => esc_html__( 'Four', 'designthemes-theme' ),
						5              => esc_html__( 'Five', 'designthemes-theme' ),
						6              => esc_html__( 'Six', 'designthemes-theme' ),
						7              => esc_html__( 'Seven', 'designthemes-theme' ),
						8              => esc_html__( 'Eight', 'designthemes-theme' ),
						9              => esc_html__( 'Nine', 'designthemes-theme' ),
						10              => esc_html__( 'Ten', 'designthemes-theme' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Dt_Shop_Metabox_Single_Upsell_Related::instance();