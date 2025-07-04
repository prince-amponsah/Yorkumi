<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Portfolio_Single_Gallery_Listings extends Widget_Base {

	public function get_categories() {
		return [ 'dtportfolio-widgets' ];
	}

	public function get_name() {
		return 'dt-portfolio-single-gallery-listing';
	}

	public function get_title() {
		return __( 'Portfolio Single - Gallery Listings', 'dtportfolio' );
	}

	public function get_style_depends() {
		return array( 'dtportfolio-animation', 'dtportfolio-gallery-listings' );
	}

	public function get_script_depends() {
		return array( 'jquery-inview', 'dtportfolio-gallery-listings' );
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

				# Gallery ID(s)
					$this->add_control( 'gallery_ids', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Gallery ID(s)', 'dtportfolio'),
						'default' => '',
						'description' => __('Comma separated gallery item ids to display particular gallery items only.', 'dtportfolio'),
					) );

				# Post Layout
					$this->add_control( 'column', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Post Layout', 'dtportfolio'),
						'default' => 2,
						'options' => array(
							1 => esc_html__('I Column', 'dtportfolio'),
							2 => esc_html__('II Columns', 'dtportfolio'),
							3 => esc_html__('III Columns', 'dtportfolio'),
							4 => esc_html__('IV Columns', 'dtportfolio'),
							5 => esc_html__('V Columns', 'dtportfolio'),
							6 => esc_html__('VI Columns', 'dtportfolio'),
							7 => esc_html__('VII Columns', 'dtportfolio'),
							8 => esc_html__('VIII Columns', 'dtportfolio'),
							9 => esc_html__('IX Columns', 'dtportfolio'),
							10 => esc_html__('X Columns', 'dtportfolio')
						)
					) );

				# Grid Space
					$this->add_control( 'grid_space', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Grid Space', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						)
					) );

				# Hover Design
					$this->add_control( 'hover_design', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Hover Design', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						)
					) );

				# Animation Effect
					$dtportfolio_animationtypes = array('' => 'none', 'flash' => 'flash', 'shake' => 'shake', 'bounce' => 'bounce', 'tada' => 'tada', 'swing' => 'swing', 'wobble' => 'wobble', 'pulse' => 'pulse', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipOutX' => 'flipOutX', 'flipInY' => 'flipInY', 'flipOutY' => 'flipOutY', 'fadeIn' => 'fadeIn', 'fadeInUp' => 'fadeInUp', 'fadeInDown' => 'fadeInDown', 'fadeInLeft' => 'fadeInLeft', 'fadeInRight' => 'fadeInRight', 'fadeInUpBig' => 'fadeInUpBig', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeOut' => 'fadeOut', 'fadeOutUp' => 'fadeOutUp','fadeOutDown' => 'fadeOutDown', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutRight' => 'fadeOutRight', 'fadeOutUpBig' => 'fadeOutUpBig', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeftBig' => 'fadeOutLeftBig','fadeOutRightBig' => 'fadeOutRightBig', 'bounceIn' => 'bounceIn', 'bounceInUp' => 'bounceInUp', 'bounceInDown' => 'bounceInDown', 'bounceInLeft' => 'bounceInLeft', 'bounceInRight' => 'bounceInRight', 'bounceOut' => 'bounceOut', 'bounceOutUp' => 'bounceOutUp', 'bounceOutDown' => 'bounceOutDown', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'rotateIn' => 'rotateIn', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateInDownRight' => 'rotateInDownRight', 'rotateOut' => 'rotateOut', 'rotateOutUpLeft' => 'rotateOutUpLeft','rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'rotateOutDownRight' => 'rotateOutDownRight', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut', 'lightSpeedIn' => 'lightSpeedIn', 'lightSpeedOut' => 'lightSpeedOut', 'slideDown' => 'slideDown', 'slideUp' => 'slideUp', 'slideLeft' => 'slideLeft', 'slideRight' => 'slideRight', 'slideExpandUp' => 'slideExpandUp', 'expandUp' => 'expandUp', 'expandOpen' => 'expandOpen', 'bigEntrance' => 'bigEntrance', 'hatch' => 'hatch', 'floating' => 'floating', 'tossing' => 'tossing', 'pullUp' => 'pullUp', 'pullDown' => 'pullDown', 'stretchLeft' => 'stretchLeft', 'stretchRight' => 'stretchRight', 'zoomIn' => 'zoomIn');


					$this->add_control( 'animation_effect', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Animation Effect', 'dtportfolio'),
						'default' => '',
						'options' => $dtportfolio_animationtypes
					) );

				# Animation Delay
					$this->add_control( 'animation_delay', array(
						'type'    => Controls_Manager::NUMBER,
						'label'   => __('Animation Delay', 'dtportfolio'),
						'default' => '',
						'min'     => 1,
						'max'     => 50000,
						'step'    => 1,
					) );

				# Repeat Animation
					$this->add_control( 'repeat_animation', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Repeat Animation', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''     => esc_html__('False', 'dtportfolio'),
							'true' => esc_html__('True', 'dtportfolio')
						)
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
			$ft_gallery_ids = ( isset($ft_settings['gallery_items']) && !empty($ft_settings['gallery_items']) ) ? array_filter( explode( ",", $ft_settings['gallery_items'] ) ) : array ();

			if($settings['gallery_ids'] != '') {
				$gallery_ids = array_filter( explode( ",", $settings['gallery_ids'] ) );
				$image_ids = array_intersect($gallery_ids, $ft_gallery_ids);
			} else {
				$image_ids = $ft_gallery_ids;
			}

			if( is_array($image_ids) && !empty( $image_ids ) ) {

				$output .= '<div class="dtportfolio-gallery-listing-holder '.esc_attr($settings['class']).'">';

					if( $settings['column'] == 1 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-column';
					} elseif( $settings['column'] == 2 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-half';
					} elseif( $settings['column'] == 3 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-third';
					} elseif( $settings['column'] == 4 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-fourth';
					} elseif( $settings['column'] == 5 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-fifth';
					} elseif( $settings['column'] == 6 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-sixth';
					} elseif( $settings['column'] == 7 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-seventh';
					} elseif( $settings['column'] == 8 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-eight';
					} elseif( $settings['column'] == 9 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-nineth';
					} elseif( $settings['column'] == 10 ) {
						$column_class = 'dtportfolio-column dtportfolio-one-tenth';
					}

					$image_size = 'full';
					if($settings['column'] > 6) {
						$image_size = 'dtportfolio-420x420';
					}

					$grid_space = (isset($settings['grid_space']) && $settings['grid_space'] == 'true') ? 'with-space' : 'no-space';
					$hover_class = (isset($settings['hover_design']) && $settings['hover_design'] == 'true') ? 'dtportfolio-hover-overlay' : 'hover-none';
					$repeat_animation_class = (isset($settings['repeat_animation']) && $settings['repeat_animation'] == 'true') ? 'repeat-animation' : '';


					// Animation
					$animation_class = $animation_settings = '';
					if( $settings['animation_effect'] ) {
						$animation_class    = 'animate';
						$animation_settings = 'data-animationeffect="'.esc_attr( $settings['animation_effect'] ).'" data-animationdelay="'.esc_attr( $settings['animation_delay'] ).'"';
					}


					$output .= '<div class="dtportfolio-container-wrapper">';
						$output .= '<div class="dtportfolio-container dtportfolio-single-container '.esc_attr( $repeat_animation_class ).' '.esc_attr( $grid_space ).'">';

							$grid_sizer_class = str_replace('dtportfolio-column ', '', $column_class);
							$output .= '<div class="dtportfolio-grid-sizer '.$grid_sizer_class.'"></div>';

							$i = 1;
							foreach( $image_ids as $key => $image_id ) {
								$attachment = wp_get_attachment_image_src( $image_id, $image_size );
								if( $attachment ) {

									if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
									if($i == $settings['column']) { $i = 1; } else { $i = $i + 1; }

									$output .= '<div class="dtportfolio-item '.esc_attr( $column_class.' '.$first_class .' '.$animation_class.' '.$hover_class.' '.$grid_space ).'" '.$animation_settings.'>';
										$output .= '<figure>';
											$output .= dtportfolio_img_tag( $image_id, $image_size );
											$output .= '<div class="dtportfolio-image-overlay">';
												$output .= '<div class="links">';
													$output .= '<a href="'.esc_url( $attachment[0] ).'" title="'.get_the_title( $settings['portfolio_id'] ).'" data-gal="prettyPhoto[gallery-listing]"><span class="dticon-search"></span></a>';
												$output .= '</div>';
											$output .= '</div>';
										$output .= '</figure>';
									$output .= '</div>';
								}
							}

						$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';

			}

		}

		echo $output;

	}

	protected function content_template() {



	}

}