<?php get_header(); ?>
	<!-- Primary -->
	<section id="primary" class="<?php echo esc_attr( savon_get_primary_classes() ); ?>">
		<?php
		    do_action( 'savon_before_single_portfolio_content_wrap' );

		    if( have_posts() ) {
        		while( have_posts() ) {
					the_post();

					$settings = get_post_meta( get_queried_object_id(), '_dt_portfolio_layout_settings', true );
					if( !is_array( $settings ) ) {
						$settings = array(
							'fixed_gallery_position' => 'left',
						);
					}

					$ft_settings = get_post_meta( get_queried_object_id(), '_dt_feature_settings', true );
					$ft_gallery_ids = ( isset($ft_settings['gallery_items']) && !empty($ft_settings['gallery_items']) ) ? array_filter( explode( ",", $ft_settings['gallery_items'] ) ) : array ();

					$settings = array_filter( $settings );?>
            		<div class="dtportfolio-single-layout-container fixed-gallery dtportfolio-fullwidth-wrapper <?php echo esc_attr($settings['fixed_gallery_position']); ?>">
            			<?php
							if ( ! post_password_required() && !empty( $ft_gallery_ids ) ) {

								ob_start();
								do_action( 'dtportfolio_single_images_swiper_slider', apply_filters( 'dtportfolio_single_images_swiper_slider_attr', array(
									'use_as_bg'              => true,
									'include_featured_image' => true,
									'pagination'             => 'bullets',
									'slides_per_view'        => 1,
									'images'                 => $ft_gallery_ids
								) ) );
								$slider = ob_get_clean();

								if( $settings['fixed_gallery_position'] == 'left' ) {
									echo '<div class="dtportfolio-column dtportfolio-one-half no-space first">';
										echo '<div class="dtportfolio-fixed-content">';
											echo $slider;
										echo '</div>';
									echo '</div>';
									echo '<div class="dtportfolio-column dtportfolio-one-half no-space">';
										echo '<div class="dtportfolio-details">';
											the_content();
										echo '</div>';
									echo '</div>';
								} else {
									echo '<div class="dtportfolio-column dtportfolio-one-half no-space first">';
										echo '<div class="dtportfolio-details">';
											the_content();
										echo '</div>';
									echo '</div>';
									echo '<div class="dtportfolio-column dtportfolio-one-half no-space">';
										echo '<div class="dtportfolio-fixed-content">';
											echo $slider;
										echo '</div>';
									echo '</div>';
								}

							} else {
								echo '<div class="dtportfolio-details">';
									the_content();
								echo '</div>';
							}
            			?>
					</div>
					<div class="dtportfolio-fullwidth-wrapper-fix"></div><?php
            	}
            }

            do_action( 'savon_after_single_portfolio_content_wrap' );?>
	</section>
	<?php savon_template_part( 'sidebar', 'templates/sidebar' ); ?>
<?php get_footer(); ?>