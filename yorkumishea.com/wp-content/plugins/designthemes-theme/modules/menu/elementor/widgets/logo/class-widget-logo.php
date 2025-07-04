<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;

class Elementor_Logo extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-logo';
    }

    public function get_title() {
        return esc_html__('Logo', 'designthemes-theme');
    }

    public function get_style_depends() {
        return array( 'dt-logo' );
    }

    public function get_icon() {
		return 'far fa-image';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'designthemes-theme'),
        ) );

            $this->add_control( 'logo_type', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Logo Type', 'designthemes-theme'),
                'default' => 'theme-logo',
                'options' => array(
                    'theme-logo'  => esc_html__('Logo', 'designthemes-theme'),
                    'custom-image'  => esc_html__('Custom Image', 'designthemes-theme'),
                    'text' => esc_html__('Title', 'designthemes-theme'),
                    'text-desc' => esc_html__('Title and Description', 'designthemes-theme'),
                )
            ) );

                $this->add_control( 'theme_logo_type', array(
                    'type'    => Controls_Manager::SELECT,
    				'label'   => esc_html__('Logo', 'designthemes-theme'),
                    'default' => 'logo',
                    'options' => array(
                        'logo'  => esc_html__('Logo', 'designthemes-theme'),
                        'light-logo'  => esc_html__('Light Logo', 'designthemes-theme'),
                    ),
                    'condition' => array( 'logo_type' => 'theme-logo' )
                ) );

    			$this->add_control( 'image', array(
    				'type'      => Controls_Manager::MEDIA,
    				'label'     => esc_html__( 'Image', 'designthemes-theme' ),
    				'default'   => array( 'url' => Utils::get_placeholder_image_src(), ),
    				'condition' => array( 'logo_type' => 'custom-image' )
    			) );

    			$this->add_responsive_control( 'image_width', array(
    				'label'           => esc_html__( 'Image Width (px)', 'designthemes-theme' ),
    				'type'            => Controls_Manager::NUMBER,
    				'min'             => 10,
    				'max'             => 500,
    				'step'            => 1,
    				'desktop_default' => 150,
    				'tablet_default'  => 100,
    				'mobile_default'  => 100,
    				'condition' => array( 'logo_type' => array( 'theme-logo', 'custom-image' ) )
    			) );

    			$this->add_control( 'logo_text', array(
    				'label'     => esc_html__( 'Site Title', 'designthemes-theme' ),
    				'type'      => Controls_Manager::TEXT,
    				'default'   => get_bloginfo ( 'name' ),
    				'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
    			) );

    			$this->add_control( 'logo_tagline', array(
    				'label'     => esc_html__( 'Site Tagline', 'designthemes-theme' ),
    				'type'      => Controls_Manager::TEXT,
    				'default'   => get_bloginfo ( 'description' ),
    				'condition' => array( 'logo_type' => array( 'text-desc' ) )
    			) );

            $this->add_responsive_control( 'item_align', array(
                'label'        => esc_html__( 'Alignment?', 'designthemes-theme' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','designthemes-theme'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','designthemes-theme'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','designthemes-theme'), 'icon' => 'eicon-h-align-right' ),
                )
            ) );

            $this->add_control( 'breakpoint', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Mobile Breakpoint (px)', 'designthemes-theme'),
                'default'     => '767',
                'description' => esc_html__( 'Apply different style if resolution less than the input value.', 'designthemes-theme' ),
            ) );

            $this->add_control( 'class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'designthemes-theme'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'designthemes-theme')
            ) );

        $this->end_controls_section();

        $this->start_controls_section( 'dt_section_color', array(
            'label' => esc_html__( 'Color', 'designthemes-theme'),
        	'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
        ) );

			$this->add_control( 'site_title_color_info', array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Site Title Color', 'designthemes-theme' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			));

            $this->add_control( 'default_item_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Item Color', 'designthemes-theme'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'designthemes-theme'),
                    'secondary_color' => esc_html__('Theme Secondary', 'designthemes-theme'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'designthemes-theme'),
                    'custom'		  => esc_html__('Custom Color', 'designthemes-theme'),
                    'none'			  => esc_html__('None', 'designthemes-theme')
                ),
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

            $this->add_control( 'default_bg_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('BG Color', 'designthemes-theme'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'designthemes-theme'),
                    'secondary_color' => esc_html__('Theme Secondary', 'designthemes-theme'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'designthemes-theme'),
                    'custom'		  => esc_html__('Custom Color', 'designthemes-theme'),
                    'none'			  => esc_html__('None', 'designthemes-theme')
                ),
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

            $this->add_control( 'default_border_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Border Color', 'designthemes-theme'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'designthemes-theme'),
                    'secondary_color' => esc_html__('Theme Secondary', 'designthemes-theme'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'designthemes-theme'),
                    'custom'		  => esc_html__('Custom Color', 'designthemes-theme'),
                    'none'			  => esc_html__('None', 'designthemes-theme')
                ),
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

			$this->add_control( 'default_custom_item_color', array(
				'label'     => esc_html__( 'Item Color', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-title' => 'color: {{VALUE}}' ),
				'condition' => array( 'default_item_color' => array( 'custom' ) )
			) );

			$this->add_control( 'default_custom_bg_color', array(
				'label'     => esc_html__( 'BG Color', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-title' => 'background-color: {{VALUE}}' ),
				'condition' => array( 'default_bg_color' => array( 'custom' ) )
			) );

			$this->add_control( 'default_custom_border_color', array(
				'label'     => esc_html__( 'Border Color', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#c50000',
				'selectors' => array( '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-title' => 'border-color: {{VALUE}}' ),
				'condition' => array( 'default_border_color' => array( 'custom' ) )
			) );

			$this->add_control( 'site_desc_color_info', array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Site Description Color', 'designthemes-theme' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => array( 'logo_type' => array( 'text-desc' ) )
			));

            $this->add_control( 'desc_default_item_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Item Color', 'designthemes-theme'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'designthemes-theme'),
                    'secondary_color' => esc_html__('Theme Secondary', 'designthemes-theme'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'designthemes-theme'),
                    'custom'		  => esc_html__('Custom Color', 'designthemes-theme'),
                    'none'			  => esc_html__('None', 'designthemes-theme')
                ),
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

            $this->add_control( 'desc_default_bg_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('BG Color', 'designthemes-theme'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'designthemes-theme'),
                    'secondary_color' => esc_html__('Theme Secondary', 'designthemes-theme'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'designthemes-theme'),
                    'custom'		  => esc_html__('Custom Color', 'designthemes-theme'),
                    'none'			  => esc_html__('None', 'designthemes-theme')
                ),
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

            $this->add_control( 'desc_default_border_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Border Color', 'designthemes-theme'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'designthemes-theme'),
                    'secondary_color' => esc_html__('Theme Secondary', 'designthemes-theme'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'designthemes-theme'),
                    'custom'		  => esc_html__('Custom Color', 'designthemes-theme'),
                    'none'			  => esc_html__('None', 'designthemes-theme')
                ),
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

			$this->add_control( 'desc_default_custom_item_color', array(
				'label'     => esc_html__( 'Item Color', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-description' => 'color: {{VALUE}}' ),
				'condition' => array( 'desc_default_item_color' => array( 'custom' ), 'logo_type' => array( 'text-desc' ) )
			) );

			$this->add_control( 'desc_default_custom_bg_color', array(
				'label'     => esc_html__( 'BG Color', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-description' => 'background-color: {{VALUE}}' ),
				'condition' => array( 'desc_default_bg_color' => array( 'custom' ), 'logo_type' => array( 'text-desc' ) )
			) );

			$this->add_control( 'desc_default_custom_border_color', array(
				'label'     => esc_html__( 'Border Color', 'designthemes-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#c50000',
				'selectors' => array( '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-description' => 'border-color: {{VALUE}}' ),
				'condition' => array( 'desc_default_border_color' => array( 'custom' ), 'logo_type' => array( 'text-desc' ) )
			) );

        $this->end_controls_section();

        $this->start_controls_section( 'dt_section_typhography', array(
            'label' => esc_html__( 'Typography', 'designthemes-theme'),
        	'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
        ) );

            $this->add_control( 'use_theme_fonts', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Use theme default font family?', 'designthemes-theme'),
                'label_on'     => esc_html__( 'Yes', 'designthemes-theme' ),
                'label_off'    => esc_html__( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

 			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'     => esc_html__('Site Title', 'designthemes-theme'),
				'name'      => 'site_title_typo',
				'selector'  => '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-title',
				'condition' => array( 'use_theme_fonts!' => 'yes' )
			) );

            $this->add_control( 'use_theme_fonts_desc', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Use theme default font family?', 'designthemes-theme'),
                'label_on'     => esc_html__( 'Yes', 'designthemes-theme' ),
                'label_off'    => esc_html__( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

 			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'     => esc_html__('Site Description', 'designthemes-theme'),
				'name'      => 'site_desc_typo',
				'selector'  => '{{WRAPPER}} div#'.'dt-'.$this->get_id().' .site-description',
				'condition' => array( 'use_theme_fonts_desc!' => 'yes', 'logo_type' => array( 'text-desc' ) )
			) );

		$this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        extract($settings);

		$output = '';

        if($_element_id != '') {
            $el_id = 'dt-'.$_element_id;
        } else {
        	$el_id = 'dt-'.$this->get_id();
        }

        $css_classes = array(
            'dt-logo-container',
            $class
        );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

        # CUSTOM CSS
        $custom_css = '';
        $custom_css .= $this->dt_generate_css( $settings );

        # OUTPUT
        $logo = '';

        if( ( $logo_type == 'text' || $logo_type == 'text-desc' ) && !empty( $logo_text ) ) {
            $logo .= !empty( $logo_text ) ?  '<span class="site-title">'. $logo_text .'</span>' : '';
        }

        if( $logo_type == 'text-desc' && !empty( $logo_tagline ) ) {
            $logo .= !empty( $logo_tagline ) ?  '<i class="site-description">' . $logo_tagline . '</i>' : '';
        }

        if( $logo_type == 'theme-logo' ) {
            if( $theme_logo_type == 'logo' ) {
                $logo = get_theme_mod( 'custom_logo' );
                $url  = wp_get_attachment_image_url( $logo, 'full' );

                if( empty( $url ) ) {
                    $url = SAVON_ROOT_URI.'/assets/images/logo.png';
                }
            } elseif( $theme_logo_type == 'light-logo' ) {
                $alogo = dt_customizer_settings( 'custom_alt_logo' );
                $url = wp_get_attachment_image_url( $alogo, 'full' );
            }

            $logo = '<img src="'.esc_url( $url ).'" alt="'.esc_attr( get_bloginfo('name') ).'"/>';
        }

        if( $logo_type == 'custom-image' ) {
            $logo = wp_get_attachment_image($image['id'], 'full');
        }

        $output .= '<div id="' . esc_attr($el_id) . '" class="' . esc_attr($css_class) . '">';
        $output .= '  <a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.$logo.'</a>';
        $output .= '</div>';

        if( !empty( $custom_css ) ) {
            $this->dt_print_css( $custom_css );
        }

        echo $output;
	}

	function dt_generate_css( $attrs ) {

        $css = $breakpoint_css = '';

        if(isset( $attrs['_element_id'] ) && $attrs['_element_id'] != '') {
            $attrs['el_id'] = 'dt-'.$attrs['_element_id'];
        } else {
        	$attrs['el_id'] = 'dt-'.$this->get_id();
        }

        if( ( $attrs['logo_type'] == 'text' || $attrs['logo_type'] == 'text-desc' ) && !empty( $attrs['logo_text'] ) ) {

            $font_style = '';

            # Color
            $t_color = '';
            if( $attrs['default_item_color'] == 'custom' &&  !empty( $attrs['default_custom_item_color'] ) ) {
                $t_color = $attrs['default_custom_item_color'];
            } else {
                $t_color = $this->dt_current_skin( $attrs['default_item_color'] );
            }
            $font_style .= ( !empty( $t_color ) ) ? 'color:'.$t_color.';' : '';

            # BG Color
            $t_bg_color = '';
            if( $attrs['default_bg_color'] == 'custom' &&  !empty( $attrs['default_custom_bg_color'] ) ) {
                $t_bg_color = $attrs['default_custom_bg_color'];
            } else {
                $t_bg_color = $this->dt_current_skin( $attrs['default_bg_color'] );
            }
            $font_style .= ( !empty( $t_bg_color ) ) ? 'background-color:'.$t_bg_color.'; padding:4px;' : '';

            # Border Color
            $t_border_color = '';
            if( $attrs['default_border_color'] == 'custom' &&  !empty( $attrs['default_custom_border_color'] ) ) {
                $t_border_color = $attrs['default_custom_border_color'];
            } else {
                $t_border_color = $this->dt_current_skin( $attrs['default_border_color'] );
            }
            $font_style .= ( !empty( $t_border_color ) ) ? 'border-style:solid; border-width:1px; border-color:'.$t_border_color.'; ' : '';

            $css .= !empty( $font_style ) ? "\n".'div#'.esc_attr( $attrs['el_id'] ).' .site-title {'.$font_style.'}' : '';
        }

        if( $attrs['logo_type'] == 'text-desc' && !empty( $attrs['logo_tagline'] ) ) {

            $font_style = '';

            # Color
            $t_color = '';
            if( $attrs['desc_default_item_color'] == 'custom' &&  !empty( $attrs['desc_default_custom_item_color'] ) ) {
                $t_color = $attrs['desc_default_custom_item_color'];
            } else {
                $t_color = $this->dt_current_skin( $attrs['desc_default_item_color'] );
            }
            $font_style .= ( !empty( $t_color ) ) ? 'color:'.$t_color.';' : '';

            # BG Color
            $t_bg_color = '';
            if( $attrs['desc_default_bg_color'] == 'custom' &&  !empty( $attrs['desc_default_custom_bg_color'] ) ) {
                $t_bg_color = $attrs['desc_default_custom_bg_color'];
            } else {
                $t_bg_color = $this->dt_current_skin( $attrs['desc_default_bg_color'] );
            }
            $font_style .= ( !empty( $t_bg_color ) ) ? 'background-color:'.$t_bg_color.'; padding:4px;' : '';

            # Border Color
            $t_border_color = '';
            if( $attrs['desc_default_border_color'] == 'custom' &&  !empty( $attrs['desc_default_custom_border_color'] ) ) {
                $t_border_color = $attrs['desc_default_custom_border_color'];
            } else {
                $t_border_color = $this->dt_current_skin( $attrs['desc_default_border_color'] );
            }
            $font_style .= ( !empty( $t_border_color ) ) ? 'border-style:solid; border-width:1px; border-color:'.$t_border_color.'; ' : '';

            $css .= !empty( $font_style ) ? "\n".'div#'.esc_attr( $attrs['el_id'] ).' .site-description {'.$font_style.'}' : '';
        }

        if( $attrs['logo_type'] == 'theme-logo' || $attrs['logo_type'] == 'custom-image' ) {

            $css .= !empty( $attrs['image_width'] ) ? "\n".'div#'.esc_attr( $attrs['el_id'] ).' img { width:'.$attrs['image_width'].'px;}' : '';
            if( !empty( $attrs['breakpoint'] ) && !empty( $attrs['image_width_mobile'] ) ) {
                $breakpoint_css .= "\n".'div#'.esc_attr( $attrs['el_id'] ).' img { width:'.$attrs['image_width_mobile'].'px; }';
            }
        }

        if( !empty( $attrs['breakpoint'] ) && !empty( $breakpoint_css ) ) {
           $css .= "\n".'@media only screen and (max-width: '.$attrs['breakpoint'].'px) {' . $breakpoint_css."\n".'}';
        }

        return $css;
    }

    function dt_print_css( $css ) {

        if( !empty( $css ) ) {
            wp_register_style( '_prefix_handler-elementor-logo-inline', '', array (), SAVON_THEME_VERSION, 'all' );
            wp_enqueue_style( '_prefix_handler-elementor-logo-inline' );
            wp_add_inline_style( '_prefix_handler-elementor-logo-inline', $css );
        }
    }

    function dt_current_skin( $code = 'primary_color' ) {

        $color = '';
        $mode  = dt_customizer_settings( 'use_predefined_skin' );

        if( $mode ) {
            $skin  = dt_customizer_settings( 'predefined_skin' );
            $skin  = dt_customizer_settings( $skin );
            $color = $skin[$code];
        } else {
            $color = dt_customizer_settings( $code );
        }

        return $color;
    }

    protected function content_template() {
    }
}