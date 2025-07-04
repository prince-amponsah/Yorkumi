<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $pcats = wp_get_post_categories( $post_ID ) ):

		$args = array(
			'category__in'			=> $pcats,
			'ignore_sticky_posts'	=> true,
			'no_found_rows'			=> true,
			'post__not_in'			=> array( $post_ID ),
			'posts_per_page'		=> 1,
			'post_status'			=> 'publish');

		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ):?>
            <div class="related-article">
                <div class="arrow"></div>
                <div class="content">
                    <span><?php esc_html_e('Related Article', 'designthemes-theme');?></span><?php
					while ( $the_query->have_posts() ):
						$the_query->the_post();?>
                        <a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>">
                            <article><?php
								if( has_post_thumbnail() ) : ?>
	                                <div class="entry-thumb"><?php the_post_thumbnail('thumbnail');?></div><?php
								endif;?>
                                <div class="entry-summary">
                                    <h2><?php echo substr(get_the_title(), 0, 40).'...';?></h2>
                                    <span class="entry-date"><?php echo get_the_date('M');?> <?php echo get_the_date('d,');?> <?php echo get_the_date('Y');?></span>
                                </div>
                            </article>
                        </a><?php
					endwhile;?>
                </div>
            </div>
			<div class="related-flag"></div><?php
		endif;
		wp_reset_postdata();
	endif;