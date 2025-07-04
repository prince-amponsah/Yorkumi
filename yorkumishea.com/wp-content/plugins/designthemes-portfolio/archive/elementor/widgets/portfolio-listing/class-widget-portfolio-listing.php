<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Portfolio_Listing extends Widget_Base {

	public function get_categories() {
		return [ 'dtportfolio-widgets' ];
	}

	public function get_name() {
		return 'dt-portfolio-listing';
	}

	public function get_title() {
		return __( 'Portfolio Listing', 'dtportfolio' );
	}

	public function get_style_depends() {
		return array( 'dtportfolio-animation', 'ilightbox', 'swiper', 'dtportfolio-common', 'dtportfolio-listing' );
	}

	public function get_script_depends() {
		return array( 'isotope-pkgd', 'swiper', 'jquery-ilightbox', 'jquery-inview', 'jquery-nicescroll', 'dtportfolio-listing' );
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

				# Portfolio Type
					$this->add_control( 'portfolio_type', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Portfolio Type', 'dtportfolio'),
						'default' => 'default',
						'options' => array(
							'default' => esc_html__('Default Portfolio', 'dtportfolio'),
							'related' => esc_html__('Related Portfolio', 'dtportfolio')
						)
					) );

				# Portfolio ID
					$this->add_control( 'portfolio_ids', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Portfolio IDs', 'dtportfolio'),
						'default' => '',
						'description' => __('Enter portfolio ids separated by comma to display portfolio items.', 'dtportfolio'),
					) );

				# Posts Per Page
					$this->add_control( 'posts_per_page', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Posts Per Page', 'dtportfolio'),
						'default' => -1,
						'description' => __('Number of posts to show.', 'dtportfolio'),
					) );


				# Hover Style
					$this->add_control( 'hover_style', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Hover Style', 'dtportfolio'),
						'default' => 'modern-title',
						'options' => array(
							'modern-title'                            => esc_html__('Modern Title', 'dtportfolio'),
							'title-icons-overlay'                     => esc_html__('Title & Icons Overlay', 'dtportfolio'),
							'title-overlay'                           => esc_html__('Title Overlay', 'dtportfolio'),
                            'icons-only'         => esc_html__('Icons Only', 'dtportfolio'),
                            'classic'            => esc_html__('Classic', 'dtportfolio'),
                            'minimal-icons'      => esc_html__('Minimal Icons', 'dtportfolio'),
                            'presentation'       => esc_html__('Presentation', 'dtportfolio'),
                            'girly'              => esc_html__('Girly', 'dtportfolio'),
                            'art'                => esc_html__('Art', 'dtportfolio'),
                            'extended'           => esc_html__('Extended', 'dtportfolio'),
                            'boxed'              => esc_html__('Boxed', 'dtportfolio'),
                            'centered-box'       => esc_html__('Centered Box', 'dtportfolio'),
                            'with-gallery-thumb' => esc_html__('With Gallery Thumb', 'dtportfolio'),
                            'with-gallery-list'  => esc_html__('With Gallery List', 'dtportfolio'),
                            'grayscale'          => esc_html__('Grayscale', 'dtportfolio'),
                            'highlighter'        => esc_html__('Highlighter', 'dtportfolio'),
                            'with-details'       => esc_html__('With Details', 'dtportfolio'),
                            'bottom-border'      => esc_html__('Bottom Border', 'dtportfolio'),
                            'with-intro'         => esc_html__('With Intro', 'dtportfolio')
						)
					) );

				# Cursor Hover Style
					$this->add_control( 'cursor_hover_style', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Cursor Hover Style', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''                    => esc_html__('Default', 'dtportfolio'),
							'cursor-hover-style1' => esc_html__('Style 1', 'dtportfolio'),
							'cursor-hover-style2' => esc_html__('Style 2', 'dtportfolio'),
							'cursor-hover-style3' => esc_html__('Style 3', 'dtportfolio'),
							'cursor-hover-style4' => esc_html__('Style 4', 'dtportfolio'),
							'cursor-hover-style5' => esc_html__('Style 5', 'dtportfolio'),
							'cursor-hover-style6' => esc_html__('Style 6', 'dtportfolio')
						)
					) );

				# Featured Display
					$this->add_control( 'featured_display', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Featured Display', 'dtportfolio'),
						'default' => 'image',
						'options' => array(
							'image' => esc_html__('Image', 'dtportfolio'),
							'video' => esc_html__('Video', 'dtportfolio')
						),
						'condition' => [
							'post_style' => array ('default', 'fullpage', 'framed', 'multiscroll'),
						]
					) );

				# Masonry Size
					$this->add_control( 'masonry_size', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Masonry Size', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						),
						'condition' => [
							'post_style' => array ('default', 'fixed', 'framed'),
						]
					) );

				# Categories

					// Generate Categories List

					$categories = get_categories(
						array(
							'hide_empty' =>  0,
							'taxonomy'   =>  'dt_portfolio_cats'
						)
					);

					$categories_array = array ();
					foreach( $categories as $category ){
						$categories_array[$category->term_id] = $category->name;
					}

					$this->add_control( 'categories', array(
						'type'    => Controls_Manager::SELECT2,
						'label'   => __('Categories', 'dtportfolio'),
						'default' => '',
						'multiple' => true,
						'options' => $categories_array
					) );

				# Tags

					// Generate Tags List

					$tags = get_categories(
						array(
							'hide_empty' =>  0,
							'taxonomy'   =>  'dt_portfolio_tags'
						)
					);

					$tags_array = array ();
					foreach( $tags as $category ){
						$tags_array[$category->term_id] = $category->name;
					}

					$this->add_control( 'tags', array(
						'type'    => Controls_Manager::SELECT2,
						'label'   => __('Tags', 'dtportfolio'),
						'default' => '',
						'multiple' => true,
						'options' => $tags_array
					) );

				# Show Details Below Image
					$this->add_control( 'details_position', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Show Details Below Image', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''                    => esc_html__('None', 'dtportfolio'),
							'details-below-image' => esc_html__('Details Below Image', 'dtportfolio')
						),
						'condition' => [
							'post_style' => array ('default', 'fullpage', 'parallax', 'striped', 'fixed', 'framed'),
						]
					) );

				# Pagination Type
					$this->add_control( 'pagination_type', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Pagination Type', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''                    => esc_html__('None', 'dtportfolio'),
							'numbered-pagination' => esc_html__('Numbered Pagination', 'dtportfolio'),
							'load-more'           => esc_html__('Load More', 'dtportfolio'),
							'lazy-load'           => esc_html__('Lazy Load', 'dtportfolio')
						),
						'condition' => [
							'post_style' => array ('default', 'parallax', 'striped', 'fixed', 'framed'),
						]
					) );

				# Enable Fullwidth
					$this->add_control( 'enable_fullwidth', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Fullwidth', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						)
					) );

				# Class
					$this->add_control( 'class', array(
						'type'    => Controls_Manager::TEXT,
						'label'   => __('Class', 'dtportfolio'),
						'default' => ''
					) );

			$this->end_controls_section();


		# Post Style

			$this->start_controls_section( 'dt_section_post_style', array(
				'label' => __( 'Post Style', 'dtportfolio'),
			) );

				$this->add_control( 'post_style', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Post Style', 'dtportfolio'),
					'default' => 'default',
					'options' => array(
						'default'     => esc_html__('Default', 'dtportfolio'),
						'fullpage'    => esc_html__('Full Page', 'dtportfolio'),
						'parallax'    => esc_html__('Parallax', 'dtportfolio'),
						'striped'     => esc_html__('Striped', 'dtportfolio'),
						'fixed'       => esc_html__('Fixed', 'dtportfolio'),
						'framed'      => esc_html__('Framed', 'dtportfolio'),
						'multiscroll' => esc_html__('Multi Scroll', 'dtportfolio')
					),
					'description' => __('"Full Page", "Multi Scroll" will work correctly when compatible header and footer is used.', 'dtportfolio')
				) );

			# Fullpage - Navigation Position
				$this->add_control( 'fullpage_navigation_position', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Fullpage Navigation Position', 'dtportfolio'),
					'default' => '',
					'options' => array(
						''      => esc_html__('None', 'dtportfolio'),
						'left'  => esc_html__('Left', 'dtportfolio'),
						'right' => esc_html__('Right', 'dtportfolio')
					),
					'condition' => [
						'post_style' => 'fullpage',
					]
				) );

			# Fullpage - Type
				$this->add_control( 'fullpage_type', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Fullpage Type', 'dtportfolio'),
					'default' => '',
					'options' => array(
						''                 => esc_html__('Default', 'dtportfolio'),
						'splitted-section' => esc_html__('Splitted Section', 'dtportfolio')
					),
					'condition' => [
						'post_style' => 'fullpage',
					]
				) );

			# Fullpage - Splitted Sections
				$this->add_control( 'fullpage_splitted_sections', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Fullpage Splitted Sections', 'dtportfolio'),
					'default' => 'leftside-image',
					'options' => array(
						'leftside-image'    => esc_html__('Leftside Image', 'dtportfolio'),
						'rightside-image'   => esc_html__('Rightside Image', 'dtportfolio'),
						'alternate-content' => esc_html__('Alternate Content', 'dtportfolio')
					),
					'condition' => [
						'post_style'    => 'fullpage',
						'fullpage_type' => 'splitted-section',
					]
				) );

			# Disable Mouse Scrolling
				$this->add_control( 'fullpage_disable_auto_scrolling', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Disable Mouse Scrolling', 'dtportfolio'),
					'default' => 'false',
					'options' => array(
						'false' => esc_html__('False', 'dtportfolio'),
						'true'  => esc_html__('True', 'dtportfolio')
					),
					'condition' => [
						'post_style' => 'fullpage',
					]
				) );



			# Enable Arrows
				$this->add_control( 'multiscroll_enable_arrows', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Enable Arrows', 'dtportfolio'),
					'default' => 'false',
					'options' => array(
						'false' => esc_html__('False', 'dtportfolio'),
						'true'  => esc_html__('True', 'dtportfolio')
					),
					'condition' => [
						'post_style' => 'multiscroll',
					]
				) );

			# Columns
				$this->add_control( 'column', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Columns', 'dtportfolio'),
					'default' => 4,
					'options' => array(
						1  => esc_html__('I Column', 'dtportfolio'),
						2  => esc_html__('II Columns', 'dtportfolio'),
						3  => esc_html__('III Columns', 'dtportfolio'),
						4  => esc_html__('IV Columns', 'dtportfolio'),
						5  => esc_html__('V Columns', 'dtportfolio'),
						6  => esc_html__('VI Columns', 'dtportfolio'),
						7  => esc_html__('VII Columns', 'dtportfolio'),
						8  => esc_html__('VIII Columns', 'dtportfolio'),
						9  => esc_html__('IX Columns', 'dtportfolio'),
						10 => esc_html__('X Columns', 'dtportfolio')
					),
					'condition' => [
						'post_style' => array('default', 'striped', 'fixed', 'framed'),
					]
				) );

			# Grid Space
				$this->add_control( 'grid_space', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Grid Space', 'dtportfolio'),
					'default' => 'false',
					'options' => array(
						'false' => esc_html__('False', 'dtportfolio'),
						'true'  => esc_html__('True', 'dtportfolio')
					),
					'condition' => [
						'post_style' => array('default', 'framed'),
					]
				) );

			# Filter
				$this->add_control( 'filter', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Filter', 'dtportfolio'),
					'default' => 'false',
					'options' => array(
						'false' => esc_html__('False', 'dtportfolio'),
						'true'  => esc_html__('True', 'dtportfolio')
					),
					'condition' => [
						'post_style'            => array('default', 'framed'),
					]
				) );

			# Filter Design Type
				$this->add_control( 'filter_design_type', array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __('Filter Design Type', 'dtportfolio'),
					'default' => '',
					'options' => array(
						'' => esc_html__('Default', 'dtportfolio'),
						'type1' => esc_html__('Type 1', 'dtportfolio'),
						'type2' => esc_html__('Type 2', 'dtportfolio'),
						'type3' => esc_html__('Type 3', 'dtportfolio')
					),
					'condition' => [
						'post_style' => array('default', 'framed'),
						'filter'     => array('true'),
					]
				) );

			$this->end_controls_section();



		# Miscellaneous

			$this->start_controls_section( 'dt_section_miscellaneous', array(
				'label' => __( 'Miscellaneous', 'dtportfolio'),
			) );

				# Disable Individual Item Options
					$this->add_control( 'disable_misc_options', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Disable Individual Item Options', 'dtportfolio'),
						'default' => 'true',
						'options' => array(
							''     => esc_html__('False', 'dtportfolio'),
							'true' => esc_html__('True', 'dtportfolio')
						)
					) );

				# Hover Background Color
					$this->add_control( 'misc_hover_background_color', array(
						'type'    => Controls_Manager::COLOR,
						'label'   => __('Hover Background Color', 'dtportfolio'),
						'default' => '',
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Hover Content Color
					$this->add_control( 'misc_hover_content_color', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Hover Content Color', 'dtportfolio'),
						'default' => '',
						'options' => array(
							'' => esc_html__('Default', 'dtportfolio'),
							'hover-content-color-dark'  => esc_html__('Hover Content Color Dark', 'dtportfolio'),
							'hover-content-color-light'  => esc_html__('Hover Content Color Light', 'dtportfolio')
						),
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Hover Gradient Color
					$this->add_control( 'misc_hover_gradient_color', array(
						'type'    => Controls_Manager::COLOR,
						'label'   => __('Hover Gradient Color', 'dtportfolio'),
						'default' => '',
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Hover Gradient Direction
					$this->add_control( 'misc_hover_gradient_direction', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Hover Gradient Direction', 'dtportfolio'),
						'default' => '',
						'options' => array(
							'lefttoright' => esc_html__('Left to Right', 'dtportfolio'),
							'toptobottom' => esc_html__('Top to Bottom', 'dtportfolio'),
							'diagonal' => esc_html__('Diagonal', 'dtportfolio')
						),
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Hover State
					$this->add_control( 'misc_hover_state', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Hover State', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''     => esc_html__('False', 'dtportfolio'),
							'true' => esc_html__('True', 'dtportfolio')
						),
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Animation Effect
					$dtportfolio_animationtypes = array('' => 'none', 'flash' => 'flash', 'shake' => 'shake', 'bounce' => 'bounce', 'tada' => 'tada', 'swing' => 'swing', 'wobble' => 'wobble', 'pulse' => 'pulse', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipOutX' => 'flipOutX', 'flipInY' => 'flipInY', 'flipOutY' => 'flipOutY', 'fadeIn' => 'fadeIn', 'fadeInUp' => 'fadeInUp', 'fadeInDown' => 'fadeInDown', 'fadeInLeft' => 'fadeInLeft', 'fadeInRight' => 'fadeInRight', 'fadeInUpBig' => 'fadeInUpBig', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeOut' => 'fadeOut', 'fadeOutUp' => 'fadeOutUp','fadeOutDown' => 'fadeOutDown', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutRight' => 'fadeOutRight', 'fadeOutUpBig' => 'fadeOutUpBig', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeftBig' => 'fadeOutLeftBig','fadeOutRightBig' => 'fadeOutRightBig', 'bounceIn' => 'bounceIn', 'bounceInUp' => 'bounceInUp', 'bounceInDown' => 'bounceInDown', 'bounceInLeft' => 'bounceInLeft', 'bounceInRight' => 'bounceInRight', 'bounceOut' => 'bounceOut', 'bounceOutUp' => 'bounceOutUp', 'bounceOutDown' => 'bounceOutDown', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'rotateIn' => 'rotateIn', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateInDownRight' => 'rotateInDownRight', 'rotateOut' => 'rotateOut', 'rotateOutUpLeft' => 'rotateOutUpLeft','rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'rotateOutDownRight' => 'rotateOutDownRight', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut', 'lightSpeedIn' => 'lightSpeedIn', 'lightSpeedOut' => 'lightSpeedOut', 'slideDown' => 'slideDown', 'slideUp' => 'slideUp', 'slideLeft' => 'slideLeft', 'slideRight' => 'slideRight', 'slideExpandUp' => 'slideExpandUp', 'expandUp' => 'expandUp', 'expandOpen' => 'expandOpen', 'bigEntrance' => 'bigEntrance', 'hatch' => 'hatch', 'floating' => 'floating', 'tossing' => 'tossing', 'pullUp' => 'pullUp', 'pullDown' => 'pullDown', 'stretchLeft' => 'stretchLeft', 'stretchRight' => 'stretchRight', 'zoomIn' => 'zoomIn');

					$this->add_control( 'misc_animation_effect', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Animation Effect', 'dtportfolio'),
						'default' => '',
						'options' => $dtportfolio_animationtypes,
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Animation Delay
					$this->add_control( 'misc_animation_delay', array(
						'type'    => Controls_Manager::NUMBER,
						'label'   => __('Animation Delay', 'dtportfolio'),
						'default' => '',
						'min'     => 1,
						'max'     => 50000,
						'step'    => 1,
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

				# Repeat Animation
					$this->add_control( 'misc_repeat_animation', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Repeat Animation', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''     => esc_html__('False', 'dtportfolio'),
							'true' => esc_html__('True', 'dtportfolio')
						),
						'condition' => [
							'disable_misc_options' => 'true',
						]
					) );

			$this->end_controls_section();


		# Carousel

			$this->start_controls_section( 'dt_section_carousel', array(
				'label' => __( 'Carousel', 'dtportfolio'),
			) );

				# Display Style
					$this->add_control( 'listing_display_style', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Display Style', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''     => esc_html__('List', 'dtportfolio'),
							'carousel' => esc_html__('Carousel', 'dtportfolio')
						),
						'description' => __('Select display style for your portfolio.', 'dtportfolio'),
						'condition' => [
							'pagination_type' => array (''),
							'post_style'      => array ('default', 'striped', 'fixed', 'framed'),
							'filter'          => array ('false')
						]
					) );

				# Effect
					$this->add_control( 'carousel_effect', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Effect', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''          => esc_html__('Default', 'dtportfolio'),
							'multirows' => esc_html__('Multi Rows', 'dtportfolio')
						),
						'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Cube and Fade effect.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Number of Rows
					$this->add_control( 'carousel_number_of_rows', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Number of Rows', 'dtportfolio'),
						'default' => 1,
						'options' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5,
						),
						'description' => esc_html__( 'Number rows to show, it will work along with multi row effect only.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'carousel_effect'       => array ('multirows'),
							'filter'                => array ('false')
						]
					) );

				# Auto Play
					$this->add_control( 'carousel_auto_play', array(
						'type'    => Controls_Manager::NUMBER,
						'label'   => __('Auto Play', 'dtportfolio'),
						'default' => '',
						'min'     => 1,
						'max'     => 50000,
						'step'    => 1,
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Slides Per View
					$this->add_control( 'carousel_slides_per_view', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Slides Per View', 'dtportfolio'),
						'default' => 1,
						'options' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5,
							6 => 6,
							7 => 7,
							8 => 8,
							9 => 9,
							10 => 10
						),
						'description' => esc_html__( 'Number slides of to show in view port.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Loop Mode
					$this->add_control( 'carousel_loop_mode', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Loop Mode', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false'          => esc_html__('False', 'dtportfolio'),
							'true'      => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel. Thumbnail pagination wont work along with "Loop Mode".', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Mousewheel Control
					$this->add_control( 'carousel_mousewheel_control', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Mousewheel Control', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false'          => esc_html__('False', 'dtportfolio'),
							'true'      => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Centered Mode
					$this->add_control( 'carousel_center_mode', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Centered Mode', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false'          => esc_html__('False', 'dtportfolio'),
							'true'      => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'If you wish you can enable centered mode for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Vertical Direction
					$this->add_control( 'carousel_vertical_direction', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Vertical Direction', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false'          => esc_html__('False', 'dtportfolio'),
							'true'      => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'To make your slides to navigate vertically.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Pagination Type
					$this->add_control( 'carousel_pagination_type', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Pagination Type', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''            => esc_html__('None', 'dtportfolio'),
							'bullets'     => esc_html__('Bullets', 'dtportfolio'),
							'fraction'    => esc_html__('Fraction', 'dtportfolio'),
							'progressbar' => esc_html__('Progress Bar', 'dtportfolio')
						),
						'description' => esc_html__( 'Choose pagination type you like to use.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Thumbnail Pagination
					$this->add_control( 'carousel_thumbnail_pagination', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Thumbnail Pagination', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'To enable thumbnail pagination.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'carousel_effect'       => array (''),
							'filter'                => array ('false')
						]
					) );

				# Enable Arrow Pagination
					$this->add_control( 'carousel_arrow_pagination', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Arrow Pagination', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'To enable arrow pagination.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Arrow Type
					$this->add_control( 'carousel_arrow_pagination_type', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Arrow Type', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''          => esc_html__('Default', 'dtportfolio'),
							'type2'      => esc_html__('Type 2', 'dtportfolio')
						),
						'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Scrollbar
					$this->add_control( 'carousel_scrollbar', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Scrollbar', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'To enable scrollbar for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Arrow For Mouse Pointer
					$this->add_control( 'carousel_arrow_for_mouse_pointer', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Arrow For Mouse Pointer', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'To enable arrow for mouse pointer for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Pagination Color Scheme
					$this->add_control( 'carousel_pagination_color_scheme', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Pagination Color Scheme', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''          => esc_html__('Light', 'dtportfolio'),
							'dark'      => esc_html__('Dark', 'dtportfolio')
						),
						'description' => esc_html__( 'Choose pagination color scheme for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Enable Play/Pause Button
					$this->add_control( 'carousel_play_pause_button', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Enable Play/Pause Button', 'dtportfolio'),
						'default' => 'false',
						'options' => array(
							'false' => esc_html__('False', 'dtportfolio'),
							'true'  => esc_html__('True', 'dtportfolio')
						),
						'description' => esc_html__( 'To enable play pause button for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Space Between Sliders
					$this->add_control( 'carousel_space_between', array(
						'type'    => Controls_Manager::NUMBER,
						'label'   => __('Space Between Sliders', 'dtportfolio'),
						'description' => esc_html__( 'Space between sliders can be given here.', 'dtportfolio' ),
						'default' => '',
						'min'     => 1,
						'max'     => 100,
						'step'    => 1,
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Overall Pagination Design Types
					$this->add_control( 'carousel_pagination_design_type', array(
						'type'    => Controls_Manager::SELECT,
						'label'   => __('Overall Pagination Design Types', 'dtportfolio'),
						'default' => '',
						'options' => array(
							''          => esc_html__('Default', 'dtportfolio'),
							'type2'      => esc_html__('Type 2', 'dtportfolio'),
							'type3'      => esc_html__('Type 3', 'dtportfolio')
						),
						'description' => esc_html__( 'Choose overall pagination design type for your carousel.', 'dtportfolio' ),
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

				# Content Over Slider
					$this->add_control( 'content_over_slider', array(
						'type'    => Controls_Manager::TEXTAREA,
						'label'   => __('Content Over Slider', 'dtportfolio'),
						'description' => esc_html__( 'If you like to show any content over slider you can add it here.', 'dtportfolio' ),
						'default' => '',
						'condition' => [
							'pagination_type'       => array (''),
							'post_style'            => array ('default', 'striped', 'fixed', 'framed'),
							'listing_display_style' => array ('carousel'),
							'filter'                => array ('false')
						]
					) );

			$this->end_controls_section();


	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract($settings);

		$output = '';

		$paged = 1;
		if($pagination_type == 'numbered-pagination') {

			if ( get_query_var('paged') ) {
				$paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
				$paged = get_query_var('page');
			}

		}
		$settings['paged'] = $paged;

		$args = array ();
		if( !empty($portfolio_ids) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post__in'       => explode(',', $portfolio_ids),
				'post_type'      => 'dt_portfolios'
			);

		elseif( empty($categories) && empty($tags) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios'
			);

		elseif( !empty($categories) && empty($tags) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios',
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'tax_query'      => array (
					array (
						'taxonomy' => 'dt_portfolio_cats',
						'field'    => 'id',
						'operator' => 'IN',
						'terms'    => $categories
					)
				)
			);

		elseif( !empty($tags) && empty($categories) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios',
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'tax_query'      => array (
					array (
						'taxonomy' => 'dt_portfolio_tags',
						'field'    => 'id',
						'operator' => 'IN',
						'terms'    => $tags
					)
				)
			);

		else:

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios'
			);

		endif;


		if( $portfolio_type == 'related' && is_singular('dt_portfolios') ) {

			global $post;
			$related_portfolio_id = $post->ID;

			$related_portfolio_terms = wp_get_object_terms( $related_portfolio_id, 'dt_portfolio_cats', array ('fields' => 'ids') );
			$args['post__not_in'] = array ($related_portfolio_id);
			$args['tax_query'][] = array (
										'taxonomy' => 'dt_portfolio_cats',
										'field' => 'id',
										'terms' => $related_portfolio_terms ,
										'operator' => 'IN'
									);

		}




		$portfolio_query = new \WP_Query($args);
		if($portfolio_query->have_posts()):

			$total_count = $portfolio_query->post_count;
			$settings['total_count'] = $total_count;

			// Initialize Base Class
			require_once DT_PORTFOLIO_DIR_PATH.'archive/templates/base.php';
			$pa_base = new \DesignThemesPortfolioArchiveBase(-1, $settings);
			$pa_base->container_filters_and_actions();

			// Load Post Style Template File
			require_once DT_PORTFOLIO_DIR_PATH.'archive/templates/'.$post_style.'/index.php';
			$post_style_class_name = '\DesignThemesPortfolioArchive'.ucfirst($post_style).'Template';
			$pa_template = new $post_style_class_name(-1, $settings);
			$pa_template->container_filters_and_actions();


			$output .= '<div class="'.implode(' ', apply_filters('dtportfolio_container_wrapper_classes', array ()) ).'">';

				ob_start();
				do_action( 'dtportfolio_listings_before_container_div' );
				$output .= ob_get_clean();

				if(in_array($pagination_type, array ('load-more', 'lazy-load'))):

					$output .= '<div class="message hidden">'.esc_html__('No more records to load!', 'dtportfolio').'</div>';

				endif;

				$output .= '<div class="'.implode(' ', apply_filters('dtportfolio_container_classes', array ()) ).'" '.implode(' ', apply_filters('dtportfolio_container_attributes', array ()) ).'>';

					if($listing_display_style != 'carousel' && !in_array($post_style, array ('fullpage', 'multiscroll'))):
						$output .= '<div class="'.implode(' ', apply_filters('dtportfolio_grid_sizer_classes', array ( 'dtportfolio-grid-sizer' )) ).'"></div>';
					endif;

					while( $portfolio_query->have_posts() ):
						$portfolio_query->the_post();

						$current_post = $portfolio_query->current_post;

						// Initialize Loop Class
						$portfolio_id = get_the_ID();
						$pa_template = new $post_style_class_name($portfolio_id, $settings);
						$output .= $pa_template->item_setup_loop($current_post);

					endwhile;

					wp_reset_postdata();

				$output .= '</div>';

				ob_start();
				do_action( 'dtportfolio_listings_after_container_div' );
				$output .= ob_get_clean();

				if( in_array($pagination_type, array('load-more', 'lazy-load')) ):

					if($posts_per_page > 0):

						$ajax_call_data = '';
						if(is_array($settings) && !empty($settings)):
							unset($settings['content_over_slider']);
							$ajax_call_data = json_encode($settings);
						endif;

						if($pagination_type == 'load-more') {
							$label = esc_html__('Load More', 'dtportfolio' );
						} else if ($pagination_type == 'lazy-load') {
							$label = esc_html__('Scroll To Load More','dtportfolio');
						}

						$output .= '<a href="javascript:void(0)" class="dtportfolio-infinite-portfolio-load-more '.$pagination_type.' aligncenter" data-ajaxcall-data='.esc_js($ajax_call_data).'><span>'.$label.'</span></a>';

					endif;

				elseif( $pagination_type == 'numbered-pagination' ):

						$output .= '<div class="pagination">';
							$output .= paginate_links( array (
												'current'   => $paged,
												'type'      => 'list',
												'end_size'  => 2,
												'mid_size'  => 3,
												'prev_next' => true,
												'prev_text' => '<i class="fas fa-angle-double-left"></i>',
												'next_text' => '<i class="fas fa-angle-double-right"></i>',
												'total'     => $portfolio_query->max_num_pages
												) );
						$output .= '</div>';

				endif;

				$output .= $pa_base->assets_load();

			$output .= '</div>';
			$output .= '<div class="dtportfolio-fullwidth-wrapper-fix"></div>';

			$pa_base->reset_all_container_filters_and_actions();

		endif;

		echo $output;

	}

	protected function content_template() {

	}

}