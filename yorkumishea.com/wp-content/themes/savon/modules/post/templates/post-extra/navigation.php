<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Navigation -->
<div class="entry-post-navigation"><?php
	if( ! is_attachment() ) :
		$prev_post = get_previous_post();
		if( !empty( $prev_post ) ):	?>

			<div class="post-prev-link"><?php
				if( has_post_thumbnail( $prev_post->ID ) ):
					$entry_bg = '';
					$url = get_the_post_thumbnail_url( $prev_post->ID, 'full' );
					$entry_bg = "style=background-image:url(".$url.")"; ?>

					<div <?php echo esc_attr($entry_bg);?> class="prev-post-bgimg"></div>
					<a href="<?php echo get_permalink( $prev_post->ID ); ?>"></a><?php
				else: ?>
					<a href="<?php echo get_permalink( $prev_post->ID ); ?>"></a><?php
				endif; ?>

				<div class="nav-title-wrap">
					<p><?php esc_html_e('Previous Story','savon'); ?></p>
					<span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>
					<h3><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php
						if( get_the_title( $prev_post->ID ) == '') {
							echo esc_html__('Previous Post', 'savon');
						} else {
							echo "{$prev_post->post_title}";
						} ?></a>
					</h3>
				</div>

			</div>  
			<?php
		else: ?>
			<div class="post-prev-link no-post">
				<div class="nav-title-wrap">
					<p><?php esc_html_e('Previous Story','savon'); ?></p>
					<span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>
					<h3><a href="#"><?php echo esc_html__('No story to show!', 'savon'); ?></a></h3>
				</div>
			</div>
			<?php
		endif;

		$next_post = get_next_post();
		if( !empty( $next_post ) ):	?>
			<div class="post-next-link"><?php

				if( has_post_thumbnail( $next_post->ID ) ):
					$entry_bg = '';
					$url = get_the_post_thumbnail_url( $next_post->ID, 'full' );
					$entry_bg = "style=background-image:url(".$url.")"; ?>

					<div <?php echo esc_attr($entry_bg);?> class="next-post-bgimg"></div>
					<a href="<?php echo get_permalink( $next_post->ID ); ?>"></a><?php
				else: ?>
					<a href="<?php echo get_permalink( $next_post->ID ); ?>"></a><?php
				endif; ?>

				<div class="nav-title-wrap">
					<p><?php esc_html_e('Next Story','savon'); ?></p>
					<span class="zmdi zmdi-long-arrow-right zmdi-hc-fw"></span>
					<h3><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php 
						if(get_the_title( $next_post->ID ) == '') {
							echo esc_html__('Next Post', 'savon');
						} else {
							echo "{$next_post->post_title}";
						} ?></a>
					</h3>
				</div>

			</div>
			<?php
		else: ?>
			<div class="post-next-link no-post">
				<div class="nav-title-wrap">
					<p><?php esc_html_e('Next Story','savon'); ?></p>
					<span class="zmdi zmdi-long-arrow-right zmdi-hc-fw"></span>
					<h3><a href="#"><?php echo esc_html__('No story to show!', 'savon'); ?></a></h3>
				</div>
			</div>
			<?php
		endif;
	endif; ?></div><!-- Entry Navigation -->