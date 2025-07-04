<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Product_Tabs_Exploded extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-product-single-tabs-exploded';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Tabs Exploded', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array( 'dtshop-product-single-tabs-exploded' );
	}

	public function get_script_depends() {
		return array( 'jquery-nicescroll', 'dtshop-product-single-tabs-exploded' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'product_tabs_exploded_section', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product summary items. No need to provide ID if it is used in Product single page.', 'designthemes-theme'),
			) );

			$this->add_control( 'tab', array(
				'label'       => __( 'Tab', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__('Choose tab that you would like to use.', 'designthemes-theme'),
				'default'     => 'description',
				'options'     => array(
					'description'            => esc_html__( 'Description', 'designthemes-theme' ),
					'review'                 => esc_html__( 'Review', 'designthemes-theme' ),
					'additional_information' => esc_html__( 'Additional Information', 'designthemes-theme' )
				),
			) );

			$this->add_control( 'hide_title', array(
				'label'        => __( 'Hide Title', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'If you wish to hide title you can do it here', 'designthemes-theme' ),
			) );

			$this->add_control( 'apply_scroll', array(
				'label'        => __( 'Apply Content Scroll', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'If you wish to apply scroll you can do it here', 'designthemes-theme' ),
			) );

			$this->add_control( 'scroll_height', array(
				'label'       => esc_html__( 'Scroll Height (px)', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Specify height for your section here.', 'designthemes-theme' ),
				'condition'   => array( 'apply_scroll' => 'true' ),
			) );

			$this->add_control(
				'class',
				array (
					'label' => __( 'Class', 'designthemes-theme' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = dtshop_product_tabs_exploded_render_html($settings);

		echo $output;

	}

}