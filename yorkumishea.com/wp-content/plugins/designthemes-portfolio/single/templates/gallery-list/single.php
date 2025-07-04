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
							'gallery_position' => 'left',
						);
					}
					$settings = array_filter( $settings );


					$ft_settings = get_post_meta( get_queried_object_id(), '_dt_feature_settings', true );
					$ft_gallery_ids = ( isset($ft_settings['gallery_items']) && !empty($ft_settings['gallery_items']) ) ? array_filter( explode( ",", $ft_settings['gallery_items'] ) ) : array ();
					?>

					<div class="dtportfolio-single-layout-container gallery-list dtportfolio-fullwidth-wrapper <?php echo esc_attr($settings['gallery_position']); ?>">

						<?php
						if ( ! post_password_required() && !empty( $ft_gallery_ids ) ) {

							ob_start();
							do_action( 'dtportfolio_single_gallery_listing', apply_filters( 'dtportfolio_single_gallery_listing_attr', array(
								'images'           => $ft_gallery_ids,
								'column'           => 1,// 1,2,3, ... 10
								'grid_space'       => 'no-space',// with-space | no-space
								'animation_effect' => 'fadeInUp',
								'animation_delay'  => '400'
							) ) );
							$slider = ob_get_clean();

							if( $settings['gallery_position'] == 'left' ) {
								echo '<div class="dtportfolio-column dtportfolio-one-half no-space first">';
									echo $slider;
								echo '</div>';
								echo '<div class="dtportfolio-column dtportfolio-one-half no-space with-content-right">';
									echo '<div class="dtportfolio-details dtportfolio-fixed-content">';
										the_content();
									echo '</div>';
								echo '</div>';
							} else {
								echo '<div class="dtportfolio-column dtportfolio-one-half no-space first with-content-left">';
									echo '<div class="dtportfolio-details dtportfolio-fixed-content">';
										the_content();
									echo '</div>';
								echo '</div>';
								echo '<div class="dtportfolio-column dtportfolio-one-half no-space">';
									echo $slider;
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