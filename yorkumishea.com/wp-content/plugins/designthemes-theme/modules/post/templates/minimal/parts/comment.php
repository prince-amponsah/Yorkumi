<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
 	$disqus_sname  = ( $enable_disqus_comments ) ? $post_disqus_shortname : '';

    if( $enable_disqus_comments && $disqus_sname != '' ) {
	 	if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
			<!-- Entry Comment -->
			<div class="single-entry-comments">
		 		<div class="comment-wrap"><a href="<?php echo get_permalink($post_ID); ?>#disqus_thread"></a></div>
				<script id="dsq-count-scr" src='//<?php echo "$post_disqus_shortname";?>.disqus.com/count.js' async></script>
			</div><!-- Entry Comment --><?php
		}
    } else {
	 	if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	 		<!-- Entry Comment -->
			<div class="single-entry-comments">
				<div class="comment-wrap"><?php
					comments_popup_link(
						esc_html__('No Comments', 'designthemes-theme'),
						esc_html__('1 Comment', 'designthemes-theme'),
						esc_html__('% Comments', 'designthemes-theme'),
						'',
						esc_html__('Comments Off', 'designthemes-theme')
					); ?>
				</div>
			</div><!-- Entry Comment --><?php
		}
	}?>