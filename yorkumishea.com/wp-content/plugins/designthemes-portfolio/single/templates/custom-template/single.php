<?php get_header(); ?>
	<!-- Primary -->
	<section id="primary" class="<?php echo esc_attr( savon_get_primary_classes() ); ?>">
		<?php
		    do_action( 'savon_before_single_portfolio_content_wrap' );

		    if( have_posts() ) {
        		while( have_posts() ) {
            		the_post();?>
            		<div class="dtportfolio-single-layout-container custom-layout">
            			<?php
            				do_action( 'savon_before_single_portfolio_content' );

            				the_content();

            				do_action( 'savon_after_single_portfolio_content' );
            			?>
				</div><?php
            	}
            }

            do_action( 'savon_after_single_portfolio_content_wrap' );?>
	</section>
	<?php savon_template_part( 'sidebar', 'templates/sidebar' ); ?>
<?php get_footer(); ?>