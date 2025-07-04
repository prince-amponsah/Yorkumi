<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Menu_Icon extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-menu-icon';
	}

	public function get_title() {
		return esc_html__( 'Menu Icon', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array( 'dtshop-cart-widgets', 'dtshop-menu-icon' );
	}

	public function get_script_depends() {
		return array( 'jquery-nicescroll', 'dtshop-menu-icon' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'cart_icon_section', array(
			'label' => esc_html__( 'Cart Icon', 'designthemes-theme' ),
		) );

			$this->add_control( 'cart_action', array(
				'label'       => __( 'Cart Action', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => __( 'Choose how you want to display the cart content.', 'designthemes-theme'),
				'default'     => '',
				'options'     => array(
					''                    => __( 'None', 'designthemes-theme'),
					'notification_widget' => __( 'Notification Widget', 'designthemes-theme' ),
					'sidebar_widget'      => __( 'Sidebar Widget', 'designthemes-theme' ),
	            ),
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

		$output = '';

		$settings = $this->get_settings();

		$output .= '<div class="dt-sc-shop-menu-icon '.$settings['class'].'">';

			$output .= '<a href="'.esc_url( wc_get_cart_url() ).'">';
				$output .= '<span class="dt-sc-shop-menu-icon-wrapper">';
					$output .= '<span class="dt-sc-shop-menu-cart-inner">';
						$output .= '<span class="dt-sc-shop-menu-cart-icon"></span>';
						$output .= '<span class="dt-sc-shop-menu-cart-number">0</span>';
					$output .= '</span>';
					$output .= '<span class="dt-sc-shop-menu-cart-totals"></span>';
				$output .= '</span>';
			$output .= '</a>';

			if($settings['cart_action'] == 'notification_widget') {

				$output .= '<div class="dt-sc-shop-menu-cart-content-wrapper">';
					$output .= '<div class="dt-sc-shop-menu-cart-content">'.esc_html__('No products added!', 'designthemes-theme').'</div>';
				$output .= '</div>';

				set_site_transient( 'cart_action', 'notification_widget', 360 );

			} else if($settings['cart_action'] == 'sidebar_widget') {

				set_site_transient( 'cart_action', 'sidebar_widget', 360 );

			} else {

				set_site_transient( 'cart_action', 'none', 360 );

			}

		$output .= '</div>';

		echo savon_html_output($output);

	}

}