<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

use Elementor\Icons_Manager;

class Elementor_Advanced_Carousel extends DTElementorWidgetBase {
    public function get_name() {
        return 'dt-advanced-carousel';
    }

    public function get_title() {
        return esc_html__('Advanced Carousel', 'designthemes-theme');
    }

    public function get_icon() {
		return 'eicon-slider-push dtel-icon';
	}

	public function get_style_depends() {
		return array( 'jquery-slick', 'dt-advanced-carousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-slick', 'dt-advanced-carousel' );
	}

    protected function register_controls() {
        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'designthemes-theme'),
        ) );
			$repeater = new Repeater();
			$repeater->add_control( 'item_type', array(
				'label'   => esc_html__( 'Content Type', 'designthemes-theme' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'designthemes-theme' ),
					'template' => esc_html__( 'Template', 'designthemes-theme' ),
				)
			) );
			$repeater->add_control(
				'graphic_element_front',
				array (
					'label' => esc_html__( 'Graphic Element', 'designthemes-theme' ),
					'type' => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'none' => array (
							'title' => esc_html__( 'None', 'designthemes-theme' ),
							'icon' => 'fa fa-ban',
						),
						'image' => array (
							'title' => esc_html__( 'Image', 'designthemes-theme' ),
							'icon' => 'fa fa-picture-o',
						),
						'icon' => array (
							'title' => esc_html__( 'Icon', 'designthemes-theme' ),
							'icon' => 'fa fa-star',
						),
					),
					'default' => 'icon',
					'condition' => array( 'item_type' => 'default' )
				)
			);
			$repeater->add_control(
				'image_front',
				array (
					'label' => esc_html__( 'Choose Image', 'designthemes-theme' ),
					'type' => Controls_Manager::MEDIA,
					'default' => array (
						'url' => Utils::get_placeholder_image_src(),
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array (
					'name' => 'image_front', // Actually its `image_size`
					'default' => 'thumbnail',
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);
			$repeater->add_control(
				'icon_front',
				array (
					'label' => esc_html__( 'Icon', 'designthemes-theme' ),
					'type' => Controls_Manager::ICONS,
					'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid', ),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);
			$repeater->add_control(
				'icon_view_front',
				array (
					'label' => esc_html__( 'View', 'designthemes-theme' ),
					'type' => Controls_Manager::SELECT,
					'options' => array (
						'default' => esc_html__( 'Default', 'designthemes-theme' ),
						'stacked' => esc_html__( 'Stacked', 'designthemes-theme' ),
						'framed' => esc_html__( 'Framed', 'designthemes-theme' ),
					),
					'default' => 'default',
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);
			$repeater->add_control(
				'icon_shape_front',
				array (
					'label' => esc_html__( 'Shape', 'designthemes-theme' ),
					'type' => Controls_Manager::SELECT,
					'options' => array (
						'circle' => esc_html__( 'Circle', 'designthemes-theme' ),
						'square' => esc_html__( 'Square', 'designthemes-theme' ),
					),
					'default' => 'circle',
					'condition' => array (
						'icon_view_front!' => 'default',
						'graphic_element_front' => 'icon',
					),
				)
			);
			$repeater->add_control( 'item_title', array(
				'label'       => esc_html__( 'Title', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Item Title', 'designthemes-theme' ),
				'default'     => esc_html__( 'Item Title', 'designthemes-theme' ),
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control( 'item_text', array(
				'label'       => esc_html__( 'Description', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Item Description', 'designthemes-theme' ),
				'default'     => 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.',
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control( 'item_link', array(
				'label'       => esc_html__( 'Link', 'designthemes-theme' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'designthemes-theme' ),
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control( 'item_button_text', array(
				'label'     => esc_html__( 'Item Button Text', 'designthemes-theme' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array( 'item_type' => 'default', ),
			) );
			$repeater->add_control('item_template', array(
				'label'     => esc_html__( 'Select Template', 'designthemes-theme' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->dt_get_elementor_page_list(),
				'condition' => array( 'item_type' => 'template' )
			) );
			$this->add_control( 'dt_carousel_slider_content', array(
				'type'        => Controls_Manager::REPEATER,
				'label'       => esc_html__('Carousel Items', 'designthemes-theme'),
				'description' => esc_html__('Carousel items is a template which you can choose from Elementor library. Each template will be a carousel content', 'designthemes-theme' ),
				'fields'      => array_values( $repeater->get_controls() ),
			) );
        $this->end_controls_section();

		$this->start_controls_section( 'dt_section_additional', array(
			'label' => esc_html__( 'Carousel Options', 'designthemes-theme'),
		) );
			$this->add_control( 'slider_type', array(
				'label'              => esc_html__( 'Slider Type', 'designthemes-theme' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'horizontal',
				'frontend_available' => true,
				'options'            => array(
					'horizontal' => esc_html__( 'Horizontal', 'designthemes-theme' ),
					'vertical'   => esc_html__( 'Vertical', 'designthemes-theme' ),
				),
			) );
			$this->add_control( 'slide_to_scroll', array(
				'label'              => esc_html__( 'Slider Type', 'designthemes-theme' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'single',
				'frontend_available' => true,
				'options'            => array(
					'all'    => esc_html__( 'All visible', 'designthemes-theme' ),
					'single' => esc_html__( 'One at a Time', 'designthemes-theme' ),
				),
			) );
			$this->add_responsive_control( 'item_to_show', array(
				'label'           => esc_html__( 'Items To Show', 'designthemes-theme' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 25,
				'step'            => 1,
				'desktop_default' => 5,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
			) );
			$this->add_control( 'infinite_loop', array(
				'label'              => esc_html__( 'Infinite loop', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true
			) );
			$this->add_control( 'speed', array(
				'label'       => esc_html__( 'Transition speed', 'designthemes-theme' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 10000,
				'step'        => 1,
				'default'     => 300,
				'description' => esc_html__( "Speed at which next slide comes.(ms)", "dt-elementor" ),
			) );
			$this->add_control( 'autoplay', array(
				'label'              => esc_html__( 'Autoplay Slides?', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true
			) );
			$this->add_control( 'autoplay_speed', array(
				'label'       => esc_html__( 'Autoplay speed', 'designthemes-theme' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 10000,
				'step'        => 1,
				'default'     => 5000,
				'condition'   => array( 'autoplay' => 'yes' ),
				'description' => esc_html__( "Speed at which next slide comes.(ms)", "dt-elementor" ),
			) );
			$this->add_control( 'draggable', array(
				'label'              => esc_html__( 'Draggable Effect?', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Allow slides to be draggable", "dt-elementor" ),
			) );
			$this->add_control( 'touch_move', array(
				'label'              => esc_html__( 'Touch Move Effect?', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Enable slide moving with touch", "dt-elementor" ),
				'condition'          => array( 'draggable' => 'yes' ),
			) );
			$this->add_control( 'adaptive_height', array(
				'label'              => esc_html__( 'Adaptive Height', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Turn on Adaptive Height", "dt-elementor" ),
			) );
			$this->add_control( 'pauseohover', array(
				'label'              => esc_html__( 'Pause on hover', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'condition'          => array( 'autoplay' => 'yes' ),
				'description'        => esc_html__( "Pause the slider on hover", "dt-elementor" ),
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'dt_arrow_section', array(
			'label' => esc_html__( 'Arrow', 'designthemes-theme' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );
			$this->add_control( 'arrows', array(
				'label'              => esc_html__( 'Navigation Arrows', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Display next / previous navigation arrows", "dt-elementor" ),
			) );
			$this->add_control( 'arrow_style', array(
				'label'              => esc_html__( 'Arrow Style', 'designthemes-theme' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'default',
				'frontend_available' => true,
				'condition'          => array( 'arrows' => 'yes' ),
				'options'            => array(
					'default'       => esc_html__('Default', 'designthemes-theme' ),
					'circle-bg'     => esc_html__('Circle Background', 'designthemes-theme' ),
					'square-bg'     => esc_html__('Square Background','designthemes-theme'),
					'circle-border' => esc_html__('Circle Border','designthemes-theme'),
					'square-border' => esc_html__('Square Border','designthemes-theme'),
				),
			) );
			$this->add_control( 'prev_arrow', array(
				'label'     => esc_html__('Prev Arrow','designthemes-theme'),
				'type'      => Controls_Manager::ICON,
				'condition' => array( 'arrows' => 'yes' ),
				'include'   => array(
					'eicon-chevron-double-left',
					'eicon-arrow-left',
					'eicon-long-arrow-left',
					'eicon-chevron-left',
					'eicon-caret-left',
					'eicon-angle-left',
				),
				'default' => 'eicon-arrow-left',
				'skin' => 'inline',
				'label_block' => true,
			) );
			$this->add_control( 'next_arrow', array(
				'label'     => esc_html__('Next Arrow','designthemes-theme'),
				'type'      => Controls_Manager::ICON,
				'condition' => array( 'arrows' => 'yes' ),
				'include'   => array(
					'eicon-chevron-double-right',
					'eicon-arrow-right',
					'eicon-long-arrow-right',
					'eicon-chevron-right',
					'eicon-caret-right',
					'eicon-angle-right',
				),
				'default' => 'eicon-arrow-right',
				'skin' => 'inline',
				'label_block' => true,
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'dt_navigation_section', array(
			'label' => esc_html__( 'Navigation', 'designthemes-theme' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );
			$this->add_control( 'navigation', array(
				'label'              => esc_html__( 'Dot Navigation', 'designthemes-theme' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Display dot navigation", "dt-elementor" ),
			) );
			/*$this->add_control( 'dot_color', array(
				'label'     => esc_html__( 'Dot Collor', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array( 'navigation' => 'yes' ),
				'selectors' => '{{WRAPPER}}'
			) );*/
			$this->add_control( 'dot_style', array(
				'label'              => esc_html__( 'Dot Style', 'designthemes-theme' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'slick-dots style-1',
				'frontend_available' => true,
				'condition'          => array( 'navigation' => 'yes' ),
				'options'            => array(
					'slick-dots style-1' 	=> esc_html__('Style 1', 'designthemes-theme' ),
					'slick-dots style-2'    => esc_html__('Style 2', 'designthemes-theme' ),
					'slick-dots style-3'    => esc_html__('Style 3', 'designthemes-theme' ),
					'slick-dots style-4'    => esc_html__('Style 4', 'designthemes-theme' ),
					'slick-dots style-5'    => esc_html__('Style 5', 'designthemes-theme' ),
					'slick-dots style-6'    => esc_html__('Style 6', 'designthemes-theme' ),
					'slick-dots style-7'    => esc_html__('Style 7', 'designthemes-theme' ),
					'slick-dots style-8'    => esc_html__('Style 8', 'designthemes-theme' ),
				),
			) );
		$this->end_controls_section();
    }

    protected function render() {
    	$out = '';
        $settings = $this->get_settings_for_display();
        extract($settings);

        if( $slide_to_scroll == 'all' ) {
			$slide_to_scroll = $item_to_show;
			$slide_to_tab    =	$item_to_show_tablet;
			$slide_to_mob    = $item_to_show_mobile;
        } else {
			$slide_to_scroll = 1;
			$slide_to_tab =	1;
			$slide_to_mob = 1;
		}

        $carousel_settings = array(
			'adaptiveHeight'        => ( $adaptive_height == 'yes' ) ? true : false,
			'arrows'                => ( $arrows == 'yes' ) ? true : false,
			'arrows'                => ( $arrows == 'yes' ) ? true : false,
			'autoplay'              => ( $autoplay == 'yes' ) ? true : false,
			'dots'                  => ( $navigation == 'yes' ) ? true : false,
			'dotsClass'             => ( $navigation == 'yes' ) ? $dot_style : 'slick-dots',
			'draggable'             => ( $draggable == 'yes' ) ? true : false,
			'swipe'                 => ( $draggable == 'yes' ) ? true : false,
			'infinite'              => ( $infinite_loop == 'yes' ) ? true : false,
			'pauseOnDotsHover'      => true,
			'pauseOnFocus'          => false,
			'pauseOnHover'          => ( $pauseohover == 'yes' ) ? true : false,
			'slidesToScroll'        => $slide_to_scroll,
			'slidesToShow'          => $item_to_show,
			'speed'                 => $speed,
			'touchMove'             => ( $touch_move == 'yes' ) ? true : false,
			'vertical'              => ( $slider_type == 'vertical' ) ? true : false,
			'desktopSlidesToShow'   => $item_to_show,
			'desktopSlidesToScroll' => $slide_to_scroll,
			'tabletSlidesToShow'    => isset($item_to_show_tablet) ? $item_to_show_tablet : '' ,
			'tabletSlidesToScroll'  => $slide_to_tab,
			'mobileSlidesToShow'    => isset($item_to_show_mobile) ? $item_to_show_mobile : '',
			'mobileSlidesToScroll'  => $slide_to_mob,
        );

        if( $arrows == 'yes' ) {
        	$carousel_settings['nextArrow'] = '<button type="button" class="'.esc_attr( $arrow_style ).' slick-next"> <span class="'.esc_attr( $next_arrow ).'"></span> </button>';
        	$carousel_settings['prevArrow'] = '<button type="button" class="'.esc_attr( $arrow_style ).' slick-prev"> <span class="'.esc_attr( $prev_arrow ).'"></span> </button>';
        }

        if(  $autoplay == 'yes' && !empty( $$autoplay_speed ) ) {
        	$carousel_settings['autoplaySpeed'] = $autoplay_speed;
        }

        $out .= "<div class='dt-advanced-carousel-wrapper' data-settings='".wp_json_encode($carousel_settings)."'>";

			if( count( $dt_carousel_slider_content ) > 0 ) {
				foreach( $dt_carousel_slider_content as $key => $item ) {

					if ( 'icon' === $item['graphic_element_front'] ) {
						$this->add_render_attribute( 'icon-wrapper-front-'.$key, 'class', 'dtel-slick-content-icon-wrapper' );
						$this->add_render_attribute( 'icon-wrapper-front-'.$key, 'class', 'dtel-slick-content-icon-view-' . $item['icon_view_front'] );
						if ( 'default' != $item['icon_view_front'] ) {
							$this->add_render_attribute( 'icon-wrapper-front-'.$key, 'class', 'dtel-slick-content-icon-shape-' . $item['icon_shape_front'] );
						}
					}

					$out .= '<div class="dt-advanced-carousel-item-wrapper">';
						if( $item['item_type'] == 'default' ) {

							$link = $link_close = '';
							if( !empty( $item['item_link']['url'] ) ){

								$target = ( $item['item_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
								$target = ( $item['item_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';

								$link = '<a href="'.esc_url( $item['item_link']['url'] ).'"'. $target . $nofollow.'>';
								$link_close = '</a>';
							}

							$out .= '<div class="dt-slick-content-wrapper">';

								if ( 'image' === $item['graphic_element_front'] && ! empty( $item['image_front']['url'] ) ) :
									$out .= '<div class="dt-slick-content-image">';
										$image_front_setting = array ();
										$image_front_setting['image'] = $item['image_front'];
										$image_front_setting['image_size'] = $item['image_front_size'];
										$image_front_setting['image_custom_dimension'] = isset($item['image_front_custom_dimension']) ? $item['image_front_custom_dimension'] : array ();

										$out .= $link;
											$out .= Group_Control_Image_Size::get_attachment_image_html( $image_front_setting );
										$out .= $link_close;
									$out .= '</div>';

								elseif ( 'icon' === $item['graphic_element_front'] && ! empty( $item['icon_front'] ) ) :
									$out .= '<div '.$this->get_render_attribute_string( 'icon-wrapper-front-'.$key ).'>';
										$out .= '<div class="dtel-slick-content-icon">';
											ob_start();
												Icons_Manager::render_icon( $item['icon_front'], [ 'aria-hidden' => 'true' ] );
											$out .= ob_get_clean();
										$out .= '</div>';
									$out .= '</div>';
								endif;

								if( !empty( $item['item_title'] ) || !empty( $item['item_text'] ) || !empty( $item['item_button_text'] ) ) {
									$out .= '<div class="dt-slick-content">';
										if( !empty( $item['item_title'] ) ) {
											$out .= '<div class="dt-slick-content-title">';
												$out .= $link;
													$out .= esc_html( $item['item_title'] );
												$out .= $link_close;
											$out .= '</div>';
										}
										$out .= !empty( $item['item_text'] ) ? '<div class="dt-slick-content-text">'. esc_html( $item['item_text'] ) . '</div>' : '';

										if( !empty( $link ) ){
											$out .= !empty( $item['item_button_text'] ) ? '<div class="dt-slick-content-btn">'. $link . $item['item_button_text'] .'</a> </div>' : '';
										}

									$out .= '</div>';
								}

							$out .= '</div>';
						}

						if( $item['item_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
							$template_content = $frontend->get_builder_content( $item['item_template'], true );
							$out .= "{$template_content}";
						}
					$out .= '</div>';
				}
			}

        $out .= '</div>';

        echo $out;
    }
}