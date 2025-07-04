<?php
if( !function_exists( 'dt_customizer_panel_priority' ) ) {
    /**
     *  Get : Customizer Panel Priority based on panel name.
     */
    function dt_customizer_panel_priority( $panel ) {
        $priority = 10;

        switch( $panel ) {

            case 'general':
                $priority = 10;
            break;

            case 'idenity':
                $priority = 15;
            break;

            case 'breadcrumb':
                $priority = 20;
                break;

            case 'header':
                $priority = 40;
            break;

            case 'typography':
                $priority = 50;
            break;

            case 'blog':
                $priority = 52;
            break;

            case 'hooks':
                $priority = 55;
            break;

            case 'layout':
                $priority = 65;
            break;

            case '404':
                $priority = 60;
            break;

            case 'skin':
                $priority = 70;
            break;

            case 'sidebar':
                $priority = 100;
            break;

            case 'standard-footer':
                $priority = 130;
            break;

            case 'js':
                $priority = 150;
            break;

            case 'woocommerce':
                $priority = 160;
            break;


        }

        return apply_filters( 'dt_customizer_panel_priority', $priority, $panel );
    }
}

if( !function_exists( 'dt_customizer_settings' ) ) {
    /**
     * Get : Customizer settings value
     */
    function dt_customizer_settings( $option ) {
        $settings = get_option( DT_CUSTOMISER_VAL, array() );
        $settings = isset( $settings[ $option ] ) ? $settings[ $option ] : false;
        return $settings;
    }
}

if( !function_exists( 'dt_customizer_typography_settings' ) ) {
    /**
     * Get : Typography CSS based on option.
     */
    function dt_customizer_typography_settings( $option ) {
        $option = is_array( $option ) ? array_filter( $option ) : array();

        $css = '';

        if( isset( $option['font-family'] ) && !empty( $option['font-family'] ) ) {

            $css .= 'font-family:'.$option['font-family'];

            if( isset( $option['font-fallback'] ) && !empty( $option['font-fallback'] ) ) {
                $css .= ','.$option['font-fallback'].';';
            }
        }

        if( isset( $option['font-weight'] ) && !empty( $option['font-weight'] ) ) {
            $css .= 'font-weight:'.$option['font-weight'].';';
        }

        if( isset( $option['font-style'] ) && !empty( $option['font-style'] ) ) {
            $css .= 'font-style:'.$option['font-style'].';';
        }

        if( isset( $option['text-transform'] ) && !empty( $option['text-transform'] ) ) {
            $css .= 'text-transform:'.$option['text-transform'].';';
        }

        if( isset( $option['text-align'] ) && !empty( $option['text-align'] ) ) {
            $css .= 'text-align:'.$option['text-align'].';';
        }

        if( isset( $option['text-decoration'] ) && !empty( $option['text-decoration'] ) ) {
            $css .= 'text-decoration:'.$option['text-decoration'].';';
        }

        if( isset( $option['fs-desktop'] ) && !empty( $option['fs-desktop'] ) ) {
            $css .= 'font-size:'.$option['fs-desktop'].$option['fs-desktop-unit'].';';
        }

        if( isset( $option['lh-desktop'] ) && !empty( $option['lh-desktop'] ) ) {
            $css .= 'line-height:'.$option['lh-desktop'].$option['lh-desktop-unit'].';';
        }

        if( isset( $option['ls-desktop'] ) && !empty( $option['ls-desktop'] ) ) {
            $css .= 'letter-spacing:'.$option['ls-desktop'].$option['ls-desktop-unit'].';';
        }

        return $css;
    }
}

if( !function_exists( 'dt_customizer_responsive_typography_settings' ) ) {

    /**
     * Get : Typography Responsive CSS based on option and responsive mode.
     */
    function dt_customizer_responsive_typography_settings( $option, $mode = 'tablet' ) {
        $css = '';

        $font_size      = 'fs-'.$mode;
        $line_height    = 'lh-'.$mode;
        $letter_spacing = 'ls-'.$mode;

        if( isset( $option[ $font_size ] ) && !empty( $option[ $font_size ] ) ) {
            $css .= 'font-size:'.$option[$font_size].$option[$font_size.'-unit'].';';
        }

        if( isset( $option[ $line_height ] ) && !empty( $option[ $line_height ] ) ) {
            $css .= 'line-height:'.$option[$line_height].$option[$line_height.'-unit'].';';
        }

        if( isset( $option[ $letter_spacing ] ) && !empty( $option[ $letter_spacing ] ) ) {
            $css .= 'letter-spacing:'.$option[$letter_spacing].$option[$letter_spacing.'-unit'].';';
        }

        return $css;
    }
}

if( !function_exists( 'dt_customizer_frontend_font' ) ) {

    /**
     * Load fonts using dt_theme_google_fonts_list in frontend
     */
    function dt_customizer_frontend_font( $settings, $fonts ) {
        $font = '';

        if( isset( $settings['font-family'] ) ){
            $font = $settings['font-family'];
            $font .= isset( $settings['font-weight'] ) && ( $settings['font-weight'] !== 'inherit' )  ? ':'.$settings['font-weight'] : '';
        }

        if( !empty( $font ) ) {
            array_push( $fonts, $font );
        }

        return $fonts;
    }
}

if( !function_exists( 'dt_customizer_color_settings' ) ) {
    function dt_customizer_color_settings( $color ) {
        $css = '';

        if( !empty( $color ) ) {
            $css .= 'color:'.$color.';';
        }

        return $css;
    }
}

if( !function_exists( 'dt_customizer_bg_color_settings' ) ) {
    function dt_customizer_bg_color_settings( $color ) {
        $css = '';

        if( !empty( $color ) ) {
            $css .= 'background-color:'.$color.';';
        }

        return $css;
    }
}

if( !function_exists( 'dt_customizer_bg_settings' ) ) {
    function dt_customizer_bg_settings( $bg ) {
        $css = '';

        $css .= !empty( $bg['background-image'] ) ? 'background-image: url("'.$bg['background-image'].'");':'';
        $css .= !empty( $bg['background-attachment'] ) ? 'background-attachment:'.$bg['background-attachment'].';':'';
        $css .= !empty( $bg['background-position'] ) ? 'background-position:'.$bg['background-position'].';':'';
        $css .= !empty( $bg['background-size'] ) ? 'background-size:'.$bg['background-size'].';':'';
        $css .= !empty( $bg['background-repeat'] ) ? 'background-repeat:'.$bg['background-repeat'].';':'';
        $css .= !empty( $bg['background-color'] ) ? 'background-color:'.$bg['background-color'].';':'';

        return $css;
    }
}


if( !function_exists( 'dt_customizer_dynamic_style') ) {
    /**
     * Get : Generate style based on selector and property
     */
    function dt_customizer_dynamic_style( $selectors, $properties ) {
        $output = '';
        if( !empty( $selectors ) && !empty( $properties ) ) {
            if( is_array( $selectors ) ) {
                $output .= implode( ', ', $selectors );
            }else {
                $output .= $selectors;
            }

            $output .= ' { ' . $properties . ' } ' . "\n";
        }
        return $output;
    }
}

if( !function_exists( 'dt_pages_list' ) ) {
    function dt_pages_list() {
        $choices = array();

		$args = array( 'post_type' => 'page', 'post_status' => 'publish' );
		$pages = get_pages($args);

		$choices[''] = esc_html__('Choose the page', 'designthemes-theme');
		foreach( $pages as $page ):
			$choices[$page->ID]	= $page->post_title;
		endforeach;

		return $choices;
    }
}

if( !function_exists( 'dt_header_template_list' ) ) {
    function dt_header_template_list() {

		$choices = array();
		$choices[''] = esc_html__('Select Header Template', 'designthemes-theme' );

		$args = array( 'post_type' => 'dt_headers', 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => -1, 'post_status' => 'publish' );
		$pages = get_posts($args);

		if ( ! is_wp_error( $pages ) && ! empty( $pages ) ) {

			foreach( $pages as $page ):
				$choices[$page->ID]	= $page->post_title;
			endforeach;
        }

		return $choices;
    }
}

if( !function_exists( 'dt_footer_template_list' ) ) {
    function dt_footer_template_list() {

		$choices = array();
		$choices[''] = esc_html__('Select Footer Template', 'designthemes-theme' );

		$args = array( 'post_type' => 'dt_footers', 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => -1, 'post_status' => 'publish' );
		$pages = get_posts($args);

		if ( ! is_wp_error( $pages ) && ! empty( $pages ) ) {

			foreach( $pages as $page ):
				$choices[$page->ID]	= $page->post_title;
			endforeach;
        }

		return $choices;
    }
}

if( !function_exists( 'dt_elementor_library_list' ) ) {
    function dt_elementor_library_list() {
        $pagelist = get_posts( array(
			'post_type' => 'elementor_library',
			'showposts' => -1,
        ));

        if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ) {

			foreach ( $pagelist as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}

			$options[0] = esc_html__('Select Elementor Library', 'designthemes-theme');
			asort($options);

            return $options;
        }
    }
}

if( !function_exists('dt_theme_get_template_part') ) {

    function dt_theme_get_template_part( $module, $template, $slug = '', $params = array() ) {

        $root = DT_THEME_DIR_PATH . 'modules';
        return dt_framework_get_template_part( $root, $module, $template, $slug, $params );
    }
}

if( !function_exists('savon_get_template_plugin_part') ) {

    function savon_get_template_plugin_part( $plugin_template = '', $module = '', $template = '', $slug = '' ) {

        $html          = '';
        $template_path = DT_THEME_DIR_PATH . 'modules/' . $module;

        $temp = $template_path . '/' . $template;

        $template = '';

        if ( ! empty( $temp ) ) {
            if ( ! empty( $slug ) ) {
                $template = "{$temp}-{$slug}.php";

                if ( ! file_exists( $template ) ) {
                    $template = $temp . '.php';
                }
            } else {
                $template = $temp . '.php';
            }
        }

        if ( $template && file_exists( $template ) ) {
            return $template;
        } else {
            return '';
        }
    }
    add_filter( 'savon_get_template_plugin_part', 'savon_get_template_plugin_part', 10, 4 );
}

if( !function_exists('savon_before_after_widget') ) {

    function savon_before_after_widget ( $content ) {
        $allowed_html = array(
            'aside' => array(
                'id'    => array(),
                'class' => array()
            ),
            'div' => array(
                'id'    => array(),
                'class' => array(),
            )
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

if( !function_exists('savon_widget_title') ) {

    function savon_widget_title( $content ) {

        $allowed_html = array(
            'div' => array(
                'id'    => array(),
                'class' => array()
            ),
            'h2' => array(
                'class' => array()
            ),
            'h3' => array(
                'class' => array()
            ),
            'h4' => array(
                'class' => array()
            ),
            'h5' => array(
                'class' => array()
            ),
            'h6' => array(
                'class' => array()
            ),
            'span' => array(
                'id'    => array(),
                'class' => array()
            ),
            'p' => array(
                'id'    => array(),
                'class' => array()
            ),
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}