<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Portfolio_Single_Featured_Video extends Widget_Base {

	public function get_categories() {
		return [ 'dtportfolio-widgets' ];
	}

	public function get_name() {
		return 'dt-portfolio-single-featuredvideo';
	}

	public function get_title() {
		return __( 'Portfolio Single - Featured Video', 'dtportfolio' );
	}

	public function get_style_depends() {
		return array( 'dtportfolio-featured-video' );
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

			$ft_settings = get_post_meta( $settings['portfolio_id'], '_dt_feature_settings', true );
			$ft_settings = is_array( $ft_settings ) ? array_filter( $ft_settings ) : array();

			if( $ft_settings['video_type'] == 'oembed' && !empty( $ft_settings['oembed_url'] ) ) {
				$output .= '<div class="dtportfolio-featured-video-holder">';
					$output .= wp_oembed_get($ft_settings['oembed_url']);
				$output .= '</div>';
			}
			if( $ft_settings['video_type'] == 'self' && !empty( $ft_settings['self_url'] ) ) {
				$output .= '<div class="dtportfolio-featured-video-holder">';
					$output .= wp_video_shortcode( array('src' => $ft_settings['self_url'], 'autoplay' => 'autoplay') );
				$output .= '</div>';
			}

		}

		echo $output;

	}

	protected function content_template() {



	}

}