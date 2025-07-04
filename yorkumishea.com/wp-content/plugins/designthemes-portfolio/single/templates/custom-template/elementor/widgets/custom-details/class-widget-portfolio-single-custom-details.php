<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Portfolio_Single_Custom_Details extends Widget_Base {

	public function get_categories() {
		return [ 'dtportfolio-widgets' ];
	}

	public function get_name() {
		return 'dt-portfolio-single-customdetails';
	}

	public function get_title() {
		return __( 'Portfolio Single - Custom Details', 'dtportfolio' );
	}

	public function get_style_depends() {
		return array( 'dtportfolio-custom-details' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->content_tab();
	}

	# CONTENT TAB
	protected function content_tab() {

		# General
			$this->start_controls_section( 'dt_section_general', array(
				'label' => __( 'General', 'dtportfolio'),
			) );

				# Portfolio ID
					$this->add_control( 'portfolio_id', array(
						'type'    => Controls_Manager::HIDDEN,
						'label'   => __('Portfolio ID', 'dtportfolio'),
						'default' => '',
						'description' => __('Enter portfolio id here. If you are going to use this shortcode in portfolio single page no need to give portfolio id.', 'dtportfolio'),
					) );

				# Types
					$this->add_control( 'type', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Types', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''      => esc_html__('Default', 'dtportfolio'),
							'type2' => esc_html__('Type 2', 'dtportfolio'),
							'type3' => esc_html__('Type 3', 'dtportfolio')
						),
						'description' => __('Select the type of custom details.', 'dtportfolio')
					) );

				# Class
					$this->add_control( 'class', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Class', 'dtportfolio'),
						'default' => '',
						'description' => __('If you wish you can add additional class name here.', 'dtportfolio'),
					) );

			$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$output = '';

		if($settings['portfolio_id'] == '' && is_singular('dt_portfolios')) {
			global $post;
			$settings['portfolio_id'] = $post->ID;
		}

		if($settings['portfolio_id'] != '') {

			$fields_settings = get_post_meta( $settings['portfolio_id'], '_dt_custom_fields_settings', true );
			if( is_array( $fields_settings ) && !empty( $fields_settings ) ) {

				$output .= '<ul class="dtportfolio-project-details '.esc_attr($settings['type']).' '.esc_attr($settings['class']).'">';

				foreach( $fields_settings as $key => $fields_setting ) {

					$term_id = (int)str_replace( 'dt_portfolio_fields_', '', $key );

					$meta = get_term_meta( $term_id, 'dt_portfolio_fields_options', true );
					$type = isset( $meta['type'] ) ? $meta['type'] : 'text';

					$term = get_term( $term_id, 'dt_portfolio_fields' );

					if($type == 'link') {
						$target = '';
						if(isset($fields_setting['target']) && $fields_setting['target']) {
							$target = 'target="_blank"';
						}
						$output .= '<li><span>'.esc_html($term->name).' : </span> <a href="'.esc_url($fields_setting['link']).'" '.$target.'>'.esc_html($fields_setting['text']).'</a> </li>';
					} else {
						$output .= '<li><span>'.esc_html($term->name).' : </span> '.$fields_setting.' </li>';
					}

				}

				$output .= '</ul>';

			}

		}


		echo $output;

	}

	protected function content_template() {



	}

}