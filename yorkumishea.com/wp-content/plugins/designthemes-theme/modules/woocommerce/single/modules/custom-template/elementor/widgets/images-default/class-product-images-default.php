<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Product_Images_Default extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-product-images-default';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Images Default', 'designthemes-theme' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_images_default_section', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display woocommerce default product images gallery. No need to provide ID if it is used in Product single page.', 'designthemes-theme'),
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if(is_singular('product')) {

			ob_start();
			do_action( 'woocommerce_before_single_product_summary' );
			$woocommerce_before_single_product_summary = ob_get_clean();

			$output .= $woocommerce_before_single_product_summary;

		}

		echo $output;

	}

}