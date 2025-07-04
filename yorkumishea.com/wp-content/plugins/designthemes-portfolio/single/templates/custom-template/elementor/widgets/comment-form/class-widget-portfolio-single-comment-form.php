<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Portfolio_Single_Comment_Form extends Widget_Base {

	public function get_categories() {
		return [ 'dtportfolio-widgets' ];
	}

	public function get_name() {
		return 'dt-portfolio-single-commentform';
	}

	public function get_title() {
		return __( 'Portfolio Single - Comment Form', 'dtportfolio' );
	}

	public function get_style_depends() {
		return array( 'dtportfolio-comment-form' );
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

				# Form Title
					$this->add_control( 'form_title', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Form Title', 'dtportfolio'),
						'default' => '',
						'description' => __('If you wish you can provide form title here.', 'dtportfolio'),
					) );

				# Form Submit Button Label
					$this->add_control( 'form_submit_button_label', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Form Submit Button Label', 'dtportfolio'),
						'default' => '',
						'description' => __('If you wish you can provide form submit button label here.', 'dtportfolio'),
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

		if ( post_password_required() ) {
			return;
		}

		$output = '';

		$output .= '<div class="dtportfolio-comment-form-holder '.esc_attr($settings['class']).'">';

	    	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
	    		$output .= '<p class="no-comments">'.esc_html__( 'Comments are closed.', 'dtportfolio').'</p>';
	    	}

	    	if($settings['form_title'] != '') {
	    		$form_title = $settings['form_title'];
	    	} else {
	    		$form_title = esc_html__( 'Leave a Comment', 'dtportfolio' );
	    	}

	    	if($settings['form_submit_button_label'] != '') {
	    		$form_submit_button_label = $settings['form_submit_button_label'];
	    	} else {
	    		$form_submit_button_label = esc_html__( 'Comment', 'dtportfolio' );
	    	}

			ob_start();

			$comments_args = array (
								'title_reply'  => $form_title,
								'label_submit' => $form_submit_button_label,
								'class_form'   => 'comment-form'
							);

			comment_form($comments_args);

			$comment_form = ob_get_contents();
			ob_end_clean();

			$output .= $comment_form;

		$output .= '</div>';

		echo $output;

	}

	protected function content_template() {



	}

}