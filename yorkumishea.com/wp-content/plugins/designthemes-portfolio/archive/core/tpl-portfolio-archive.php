<?php get_header(); ?>
	<!-- Primary -->
	<section id="primary" class="<?php echo esc_attr( savon_get_primary_classes() ); ?>">
		<?php

		do_action( 'savon_before_archive_portfolio_content_wrap' );


		$posts_per_page                 = get_option( 'posts_per_page' );
		$posts_per_page                 = ($posts_per_page != '') ? $posts_per_page: -1;

		$portfolio_post_layout          = dt_customizer_settings('portfolio_post_layout');
		$column                         = ( $portfolio_post_layout ) ? $portfolio_post_layout              : 4;

		$portfolio_hover_style          = dt_customizer_settings('portfolio_hover_style');
		$hover_style                    = ( $portfolio_hover_style ) ? $portfolio_hover_style              : '';

		$portfolio_cursor_hover_style   = dt_customizer_settings('portfolio_cursor_hover_style');
		$cursor_hover_style             = ( $portfolio_cursor_hover_style ) ? $portfolio_cursor_hover_style: '';

		$portfolio_grid_space           = dt_customizer_settings('portfolio_grid_space');
		$grid_space                     = ( $portfolio_grid_space ) ? 'true'                               : 'false';

		$portfolio_full_width           = dt_customizer_settings('portfolio_full_width');
		$enable_fullwidth               = ( $portfolio_full_width ) ? 'true'                               : 'false';

		$portfolio_disable_item_options = dt_customizer_settings('portfolio_disable_item_options');
		$disable_misc_options           = ( $portfolio_disable_item_options ) ? 'true'                     : '';

		$queried_object_id              = get_queried_object_id();

		# General
			$settings['portfolio_ids']                    = '';
			$settings['posts_per_page']                   = $posts_per_page;
			$settings['hover_style']                      = $hover_style;
			$settings['cursor_hover_style']               = $cursor_hover_style;
			$settings['featured_display']                 = 'image';
			$settings['masonry_size']                     = 'false';

			if( is_tax('dt_portfolio_cats') ) {
				$settings['categories']                      = array ( $queried_object_id );
				$settings['tags']                            = array ();
			} else if( is_tax('dt_portfolio_tags') ) {
				$settings['categories']                      = array ();
				$settings['tags']                            = array ( $queried_object_id );
			}

			$settings['details_position']                 = '';
			$settings['pagination_type']                  = 'numbered-pagination';
			$settings['enable_fullwidth']                 = $enable_fullwidth;
			$settings['class']                            = '';

		# Post Style
			$settings['post_style']                       = 'default';
			$settings['column']                           = $column;
			$settings['grid_space']                       = $grid_space;
			$settings['filter']                           = 'false';
			$settings['filter_design_type']               = '';

		# Miscellaneous
			$settings['disable_misc_options']             = $disable_misc_options;
			$settings['misc_hover_background_color']      = '';
			$settings['misc_hover_content_color']         = '';
			$settings['misc_hover_gradient_color']        = '';
			$settings['misc_hover_gradient_direction']    = '';
			$settings['misc_hover_state']                 = '';
			$settings['misc_animation_effect']            = '';
			$settings['misc_animation_delay']             = '';
			$settings['misc_repeat_animation']            = '';

		# Carousel
			$settings['listing_display_style']            = '';
			$settings['carousel_effect']                  = '';
			$settings['carousel_number_of_rows']          = 1;
			$settings['carousel_auto_play']               = '';
			$settings['carousel_slides_per_view']         = 3;
			$settings['carousel_loop_mode']               = 'false';
			$settings['carousel_mousewheel_control']      = 'false';
			$settings['carousel_center_mode']             = 'false';
			$settings['carousel_vertical_direction']      = 'false';
			$settings['carousel_pagination_type']         = '';
			$settings['carousel_thumbnail_pagination']    = 'false';
			$settings['carousel_arrow_pagination']        = 'false';
			$settings['carousel_arrow_pagination_type']   = '';
			$settings['carousel_scrollbar']               = 'false';
			$settings['carousel_arrow_for_mouse_pointer'] = 'false';
			$settings['carousel_pagination_color_scheme'] = '';
			$settings['carousel_play_pause_button']       = 'false';
			$settings['carousel_space_between']           = '';
			$settings['carousel_pagination_design_type']  = '';
			$settings['content_over_slider']              = '';

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
												'prev_text' => '<i class = "fas fa-angle-double-left"></i>',
												'next_text' => '<i class = "dticon-angle-double-right"></i>',
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


		do_action( 'savon_after_archive_portfolio_content_wrap' );

		?>
	</section>
	<?php savon_template_part( 'sidebar', 'templates/sidebar' ); ?>
<?php get_footer(); ?>