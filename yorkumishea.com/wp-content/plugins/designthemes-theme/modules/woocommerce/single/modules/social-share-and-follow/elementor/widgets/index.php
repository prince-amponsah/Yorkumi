<?php

namespace DTElementor\Widgets;
use DTElementor\Widgets\DTShop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class DTShop_Widget_Product_Summary_Extend extends DTShop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'designthemes-theme' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => __( 'Share / Follow Type', 'designthemes-theme' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'designthemes-theme'),
					'share'  => esc_html__('Share', 'designthemes-theme'),
					'follow' => esc_html__('Follow', 'designthemes-theme'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'designthemes-theme' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => __( 'Social Icon Style', 'designthemes-theme' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'designthemes-theme' ),
					'bgfill'        => esc_html__( 'BG Fill', 'designthemes-theme' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'designthemes-theme' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'designthemes-theme' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'designthemes-theme' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'designthemes-theme' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => __( 'Social Icon Radius', 'designthemes-theme' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'designthemes-theme' ),
					'rounded' => esc_html__( 'Rounded', 'designthemes-theme' ),
					'circle'  => esc_html__( 'Circle', 'designthemes-theme' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => __( 'Social Icon Inline Alignment', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'designthemes-theme' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}