<?php
if( !function_exists('savon_get_archive_post_combine_class') ) {
	function savon_get_archive_post_combine_class() {

		$combine_class[] = '';

		$post_layout = apply_filters( 'savon_archive_post_cmb_class', array( 'post-layout' => 'entry-grid' ) );
		$post_layout = $post_layout['post-layout'];
		$combine_class[] = $post_layout.'-layout';

		if( $post_layout == 'entry-cover' ) {
			$cover_style = apply_filters( 'savon_archive_post_cmb_class', array( 'post-cover-style' => 'dt-sc-boxed' ) );
			$combine_class[] = $cover_style['post-cover-style'].'-style';
		} else {
			$gridlist_style = apply_filters( 'savon_archive_post_cmb_class', array( 'post-gl-style' => 'dt-sc-boxed' ) );
			$combine_class[] = $gridlist_style['post-gl-style'].'-style';
		}

		if( $post_layout == 'entry-list' ) {
			$list_type = apply_filters( 'savon_archive_post_cmb_class', array( 'list-type' => 'entry-left-thumb' ) );
			$combine_class[] = $list_type['list-type'];
		}

		$image_hover_style = apply_filters( 'savon_archive_post_cmb_class', array( 'hover-style' => 'dt-sc-default' ) );
		$combine_class[] = $image_hover_style['hover-style'].'-hover';

		$image_overlay_style = apply_filters( 'savon_archive_post_cmb_class', array( 'overlay-style' => 'dt-sc-default' ) );
		$combine_class[] = $image_overlay_style['overlay-style'].'-overlay';

		$post_alignment = apply_filters( 'savon_archive_post_cmb_class', array( 'post-align' => 'alignnone' ) );
		if( $post_layout == 'entry-grid' || $post_layout == 'entry-cover' ) {
			$combine_class[] = $post_alignment['post-align'];
		}

		$post_columns = apply_filters( 'savon_archive_post_cmb_class', array( 'post-column' => 'one-column' ) );
		if( $post_layout == 'entry-list' ) {
			$post_columns['post-column'] = 'one-column';
		}

        switch( $post_columns['post-column'] ):

            default:
			case 'one-column':
				$post_class = "column dt-sc-one-column dt-sc-post-entry ";
            break;

            case 'one-half-column':
				$post_class = "column dt-sc-one-half dt-sc-post-entry ";
            break;

            case 'one-third-column':
				$post_class = "column dt-sc-one-third dt-sc-post-entry ";
            break;

            case 'one-fourth-column':
				$post_class = "column dt-sc-one-fourth dt-sc-post-entry ";
            break;
        endswitch;

        $combine_class[] = $post_class;

        return apply_filters( 'savon_get_archive_post_combine_class', implode( ' ', $combine_class ) );
	}
}

if( !function_exists('savon_get_archive_post_holder_class') ) {
	function savon_get_archive_post_holder_class() {

		$holder_class[] = '';

		$post_layout = apply_filters( 'savon_archive_post_cmb_class', array( 'post-layout' => 'entry-grid' ) );
		$post_layout = $post_layout['post-layout'];

		$post_equal_height = apply_filters( 'savon_archive_post_hld_class', array( 'enable-equal-height' => false ) );
		if( ( $post_layout == 'entry-grid' || $post_layout == 'entry-cover' ) && $post_equal_height['enable-equal-height'] == true ):
			$holder_class[] = 'apply-equal-height';
		elseif( $post_layout == 'entry-grid' || $post_layout == 'entry-cover' ):
			$holder_class[] = 'apply-isotope';
		elseif( $post_layout == 'entry-list' ):
			$holder_class[] = 'apply-isotope';
		endif;

		$post_no_space = apply_filters( 'savon_archive_post_hld_class', array( 'enable-no-space' => false ) );
		if( ( $post_layout == 'entry-grid' || $post_layout == 'entry-cover' ) && $post_no_space['enable-no-space'] == true ):
			$holder_class[] = 'apply-no-space';
		elseif( $post_layout == 'entry-list' ):
			$holder_class[] = '';
		endif;

        return apply_filters( 'savon_get_archive_post_holder_class', implode( ' ', $holder_class ) );
	}
}

if( !function_exists('savon_get_archive_post_style') ) {
	function savon_get_archive_post_style() {

		$post_layout = apply_filters( 'savon_archive_post_cmb_class', array( 'post-layout' => 'entry-grid' ) );
		$post_layout = $post_layout['post-layout'];

		$post_style = '';
		if( $post_layout == 'entry-cover' ) {
			$post_style = apply_filters( 'savon_archive_post_cmb_class', array( 'post-cover-style' => 'dt-sc-boxed' ) );
			$post_style = $post_style['post-cover-style'];
		} else {
			$post_style = apply_filters( 'savon_archive_post_cmb_class', array( 'post-gl-style' => 'dt-sc-boxed' ) );
			$post_style = $post_style['post-gl-style'];
		}

		$post_style = str_replace( 'dt-sc-', '', $post_style );

		return apply_filters( 'savon_get_archive_post_style', $post_style );
	}
}

if( !function_exists('savon_get_archive_post_column') ) {
	function savon_get_archive_post_column() {

		$post_columns = apply_filters( 'savon_archive_post_cmb_class', array( 'post-column' => 'one-column' ) );
		$post_columns = $post_columns['post-column'];

		$post_layout = apply_filters( 'savon_archive_post_cmb_class', array( 'post-layout' => 'entry-grid' ) );
		$post_layout = $post_layout['post-layout'];

		if( $post_layout == 'entry-list' ) {
			$post_columns = 'one-column';
		}

		return apply_filters( 'savon_get_archive_post_column', $post_columns );
	}
}

add_filter('post_class', 'savon_archive_set_post_class', 10, 3);
if( !function_exists('savon_archive_set_post_class') ) {
    function savon_archive_set_post_class( $classes, $class, $post_id ) {

        if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') || ( defined('DOING_AJAX') && DOING_AJAX ) ) {
			$post_meta = get_post_meta( $post_id, '_dt_post_settings', TRUE );
			$post_meta = is_array( $post_meta ) ? $post_meta  : array();

            $post_format = !empty( $post_meta['post-format-type'] ) ? $post_meta['post-format-type'] : get_post_format($post_id);
            $classes[] = 'blog-entry';
            $classes[] = !empty( $post_format ) ? 'format-'.$post_format : 'format-standard';

            $blog_params = savon_archive_blog_post_params();

            if( $blog_params['enable_post_format'] ) {
            	$classes[] = 'has-post-format';
            }

            if( $blog_params['enable_video_audio'] && ( $post_format === 'video' || $post_format === 'audio' ) ) {
            	$classes[] = 'has-post-media';
            }

            if( get_the_title( $post_id ) == '' ) {
                $classes[] = 'post-without-title';
            }
        }

        return $classes;
    }
}

if( !function_exists('savon_archive_blog_post_params') ) {
    function savon_archive_blog_post_params() {
        $params = array(
            'enable_post_format'   	 => 0,
            'enable_video_audio' 	 => 0,
            'enable_gallery_slider'  => 0,
            'archive_post_elements'  => array( 'feature_image', 'meta_group', 'title', 'content', 'read_more' ),
            'archive_meta_elements'  => array( 'author', 'date', 'category' ),
            'archive_readmore_text'  => esc_html__('Read More', 'savon'),
            'enable_excerpt_text'	 => 1,
            'archive_excerpt_length' => 40,
            'enable_disqus_comments' => 0,
            'post_disqus_shortname'  => '',
            'archive_blog_pagination'=> 'pagination-numbered',
        );

        return apply_filters( 'savon_archive_blog_post_params', $params );
    }
}

add_action( 'savon_after_main_css', 'savon_blog_enqueue_css', 10 );
if( !function_exists( 'savon_blog_enqueue_css' ) ) {
	function savon_blog_enqueue_css() {
		wp_enqueue_style( 'savon-blog', get_theme_file_uri('/modules/blog/assets/css/blog.css'), false, SAVON_THEME_VERSION, 'all');

		if( ! class_exists( 'DesignThemesTheme' ) ){
			$post_style = savon_get_archive_post_style();
			wp_enqueue_style( 'savon-blog-archive-'.$post_style, get_theme_file_uri('/modules/blog/templates/'.$post_style.'/assets/css/blog-archive-'.$post_style.'.css'), false, SAVON_THEME_VERSION, 'all');
		}

		wp_enqueue_style( 'jquery-bxslider', get_theme_file_uri('/modules/blog/assets/css/jquery.bxslider.min.css'), false, SAVON_THEME_VERSION, 'all' );
	}
}

add_action( 'savon_before_enqueue_js', 'savon_blog_enqueue_js' );
if( !function_exists( 'savon_blog_enqueue_js' ) ) {
	function savon_blog_enqueue_js() {

		wp_enqueue_script('isotope-pkgd', get_theme_file_uri('/modules/blog/assets/js/isotope.pkgd.min.js'), array(), false, true);
		wp_enqueue_script('matchheight', get_theme_file_uri('/modules/blog/assets/js/matchHeight.js'), array(), false, true);
		wp_enqueue_script('jquery-bxslider', get_theme_file_uri('/modules/blog/assets/js/jquery.bxslider.js'), array(), false, true);
		wp_enqueue_script('jquery-fitvids', get_theme_file_uri('/modules/blog/assets/js/jquery.fitvids.js'), array(), false, true);
		wp_enqueue_script('jquery-debouncedresize', get_theme_file_uri('/modules/blog/assets/js/jquery.debouncedresize.js'), array(), false, true);
	}
}

if( !function_exists( 'after_blog_post_content_pagination' ) ) {
    function after_blog_post_content_pagination() {

    	$pagination_template = savon_archive_blog_post_params();
    	$pagination_template = $pagination_template['archive_blog_pagination'];

        echo apply_filters( 'savon_blog_archive_pagination', savon_get_template_part( 'pagination', 'templates/'.$pagination_template ) );
    }
    add_action( 'savon_after_blog_post_content_wrap', 'after_blog_post_content_pagination' );
}

if( !function_exists( 'savon_excerpt' ) ) {
	function savon_excerpt( $limit = NULL ) {

		$limit = !empty($limit) ? $limit : 10;

		$excerpt = explode(' ', get_the_excerpt(), $limit);
		$excerpt = array_filter($excerpt);

		if (!empty($excerpt)) {
			if (count($excerpt) >= $limit) {
				array_pop($excerpt);
				$excerpt = implode(" ", $excerpt).'...';
			} else {
				$excerpt = implode(" ", $excerpt);
			}
			$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
			$excerpt = str_replace('&nbsp;', '', $excerpt);
			if(!empty ($excerpt))
				return "<p>{$excerpt}</p>";
		}
	}
}