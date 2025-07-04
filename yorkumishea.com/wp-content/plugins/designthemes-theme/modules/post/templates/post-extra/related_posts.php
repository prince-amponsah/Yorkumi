<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$obj  = new DesignThemesSiteRelatedBlog();
	$args = array_merge( $obj->register_archive_post_cmb_class(), $obj->register_archive_post_hld_class() );

	$postlayout        = $args['post-layout'];
	$postglstyle       = $args['post-gl-style'];
	$postcostyle       = $args['post-cover-style'];
	$postlistthumb     = $args['list-type'];
	$postalignment     = $args['post-align'];
	$postequalheight   = $args['enable-equal-height'];
	$postnospace       = $args['enable-no-space'];
	$img_hover_style   = $args['hover-style'];
	$img_overlay_style = $args['overlay-style'];

	$targs = savon_archive_blog_post_params();
	extract( $targs );

	$count_opt = isset( $rposts_count ) ? $rposts_count : '';
	$count     = isset( $related_Count ) ? $related_Count : $count_opt;

	$title_opt = isset ( $rposts_title ) ? $rposts_title : '';
	$title     = isset( $related_Title ) ? $related_Title : $title_opt;

	$column_opt = isset( $rposts_column ) ? $rposts_column : '';
	$column     = isset( $related_Column ) ? $related_Column : $column_opt;
	$column     = ( $postlayout == 'entry-list' ) ? 'one-column' : $column;

	$col_arr    = array( 'one-column' => 1, 'one-half-column' => 2, 'one-third-column' => 3, 'one-fourth-column' => 4 );
	$data_items = ( $postlayout != 'entry-list' ) ? $col_arr[$column] : 1;

	$ele_pos = $archive_post_elements;
	foreach( $ele_pos as $ep ) {
		$elementspos[] = array( 'element_value' => $ep );
	}

	$meta_pos = $archive_meta_elements;
	foreach( $meta_pos as $mp ) {
		$metaspos[] = array( 'element_value' => $mp );
	}

	$enable_except_opt = isset( $rposts_excerpt ) ? $rposts_excerpt : '';
	$enable_except     = isset( $related_Excerpt ) ? $related_Excerpt : $enable_except_opt;

	$except_length_opt = isset( $rposts_excerpt_length ) ? $rposts_excerpt_length : '';
	$except_length     = isset( $related_Excerpt_Length ) ? $related_Excerpt_Length : $except_length_opt;

	$enable_carousel_opt = isset( $rposts_carousel ) ? $rposts_carousel : '';
	$enable_carousel     = isset( $related_Carousel ) ? $related_Carousel : $enable_carousel_opt;

	$enable_carousel = !empty( $enable_carousel ) ? 'dt-related-carousel' : '';
	$postequalheight = !empty( $enable_carousel ) ? true : $postequalheight;
	$postequalheight = false;

	$navs_style_opt = isset( $rposts_carousel_nav ) ? $rposts_carousel_nav : '';
	$navs_style     = isset( $related_Nav_Style ) ? $related_Nav_Style : $navs_style_opt;

    $post_cats = wp_get_post_categories( $post_ID );
	if( !empty( $post_cats ) && class_exists( '\Elementor\Plugin' ) ): ?>
    	<h4 class="related-post-title"><?php echo esc_html($title); ?></h4>

        <div class="dt-sc-related-posts <?php echo esc_attr($enable_carousel); ?>" data-items="<?php echo esc_attr($data_items); ?>"><?php

			$recent_posts = \Elementor\Plugin::instance()->elements_manager->create_element_instance( 
				array(
					'elType'     => 'widget',
					'widgetType' => 'dt-blog-posts',
					'id'         => 'dt-sc-related-posts',
					'settings'   => array(
						'count'                     => $count,
						'blog_post_layout'        	=> $postlayout,
						'blog_post_grid_list_style' => $postglstyle,
						'blog_post_cover_style'     => $postcostyle,
						'blog_post_columns'         => $column,
						'blog_list_thumb'         	=> $postlistthumb,
						'blog_alignment'            => $postalignment,
						'enable_equal_height'       => $postequalheight,
						'enable_no_space'           => $postnospace,
						'enable_gallery_slider'     => $enable_gallery_slider,
						'blog_elements_position'    => $elementspos,
						'blog_meta_position'        => $metaspos,
						'enable_post_format'        => $enable_post_format,
						'enable_video_audio'        => $enable_video_audio,						
						'enable_excerpt_text'       => $enable_except,
						'blog_excerpt_length'       => $except_length,
						'blog_readmore_text'     	=> $archive_readmore_text,
						'blog_image_hover_style'    => $img_hover_style,
						'blog_image_overlay_style'  => $img_overlay_style,
						'blog_pagination'			=> '',
						'_post_not_in'              => $post_ID,
						'_post_categories'          => $post_cats
					),
				)
			);
			$recent_posts->print_element();

			if( $enable_carousel != '' && $navs_style == 'navigation' ): ?>
                <div class="carousel-navigation">
                    <div class="prev-arrow"><i class="dticon-angle-left"></i></div>
                    <div class="next-arrow"><i class="dticon-angle-right"></i></div>
                </div><?php
			elseif( $enable_carousel != '' && $navs_style == 'pager' ): ?>
            	<div class="carousel-pager"></div><?php
			endif; ?>
        </div><?php
	endif; ?>