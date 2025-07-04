<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
 	$disqus_sname  = ( $enable_disqus_comments ) ? $post_disqus_shortname : '';

    if( $enable_disqus_comments && $disqus_sname != '' ) {
	 	if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
			<!-- Entry Comment -->
			<div class="entry-comments">
		 		<i class="dticon-comment"> </i><a href="<?php echo get_permalink($post_ID); ?>#disqus_thread"></a>
				<script id="dsq-count-scr" src='//<?php echo "$disqus_sname";?>.disqus.com/count.js' async></script>
			</div><!-- Entry Comment --><?php
		}
    } else {
	 	if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	 		<!-- Entry Comment -->
			<div class="entry-comments"><?php
				comments_popup_link(
					esc_html__('No Comments', 'designthemes-theme'),
					esc_html__('1 Comment', 'designthemes-theme'),
					esc_html__('% Comments', 'designthemes-theme'),
					'',
					esc_html__('Comments Off', 'designthemes-theme')
				); ?>
			</div><!-- Entry Comment --><?php
		}
	}?>