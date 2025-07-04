<?php get_header(); ?>
	<!-- Primary -->
	<section id="primary" class="content-full-width">
		<?php
		    do_action( 'savon_before_single_portfolio_content_wrap' );

		    if( have_posts() ) {
        		while( have_posts() ) {
					the_post();

					$settings = get_post_meta( get_queried_object_id(), '_dt_portfolio_layout_settings', true );
					if( !is_array( $settings ) ) {
						$settings = array(
							'fixed_image_position' => 'left',
						);
					}

					$settings = array_filter( $settings );?>

            		<div class="dtportfolio-single-layout-container fixed-featured-image dtportfolio-fullwidth-wrapper <?php echo esc_attr($settings['fixed_image_position']); ?>">
            			<?php
							if ( ! post_password_required() ) {

								$feature = get_post_meta( get_queried_object_id(), '_dt_feature_settings', true );
								$feature = array_filter( $feature );

								if( isset( $feature['image'] ) ) {
									$image = wp_get_attachment_image_src( $feature['image'], 'full', false );

									if( $settings['fixed_image_position'] == 'left' ) {
										echo '<div class="dtportfolio-column dtportfolio-one-third no-space first">';
											echo '<div class="dtportfolio-fixed-content" style="background-image:url('.esc_url( $image[0] ).');"></div>';
										echo '</div>';
										echo '<div class="dtportfolio-column dtportfolio-two-third no-space">';
											echo '<div class="dtportfolio-details">';
												the_content();
											echo '</div>';
										echo '</div>';
									} else {
										echo '<div class="dtportfolio-column dtportfolio-two-third no-space first">';
											echo '<div class="dtportfolio-details">';
												the_content();
											echo '</div>';
										echo '</div>';
										echo '<div class="dtportfolio-column dtportfolio-one-third no-space">';
											echo '<div class="dtportfolio-fixed-content" style="background-image:url('.$image[0].');"></div>';
										echo '</div>';
									}
								} else {
									echo '<div class="dtportfolio-details">';
									the_content();
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
<?php get_footer(); ?>