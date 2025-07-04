<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Product_360_Image_Viewer extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-product-single-images-360-viewer';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Images 360 Viewer', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array( 'dtshop-product-single-images-360-viewer' );
	}

	public function get_script_depends() {
		return array( 'jquery-360viewer', 'dtshop-product-single-images-360-viewer' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_images_360viewer_section', array(
			'label' => esc_html__( 'Product', 'designthemes-theme' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product images in list format. No need to provide ID if it is used in Product single page.', 'designthemes-theme'),
			) );

			$this->add_control( 'enable_popup_viewer', array(
				'label'        => esc_html__( 'Enable PopUp Viewer', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can show 360 viewer in popup.', 'designthemes-theme'),
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control(
				'source',
				array (
					'label' => __( 'Source', 'designthemes-theme' ),
					'type'  => Controls_Manager::TEXT
				)
			);

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

		$output = dtshop_product_images_360viewer_render_html($settings);

		echo $output;

	}


}