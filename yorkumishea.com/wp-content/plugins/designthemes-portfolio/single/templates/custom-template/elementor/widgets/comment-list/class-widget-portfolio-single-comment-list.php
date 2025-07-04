<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Portfolio_Single_Comment_List extends Widget_Base {

	public function get_categories() {
		return [ 'dtportfolio-widgets' ];
	}

	public function get_name() {
		return 'dt-portfolio-single-commentlist';
	}

	public function get_title() {
		return __( 'Portfolio Single - Comment List', 'dtportfolio' );
	}

	public function get_style_depends() {
		return array( 'dtportfolio-comment-list' );
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

		ob_start();

		comments_template();
		$comment_list_template = ob_get_contents();

		ob_end_clean();

		$output .= '<div class="dtportfolio-comment-list-holder '.esc_attr($settings['class']).'">';
			$output .= $comment_list_template;
		$output .= '</div>';

		echo $output;

	}

	protected function content_template() {



	}

}