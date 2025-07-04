<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
 	$disqus_sname  = ( $enable_disqus_comments ) ? $post_disqus_shortname : '';

    if( $enable_disqus_comments && $disqus_sname != '' ) {
	 	if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
			<!-- Entry Comment -->
			<div class="entry-comments">
		 		<div class="comment-wrap"><a href="<?php echo get_permalink($post_ID); ?>#disqus_thread"></a></div>
				<script id="dsq-count-scr" src='//<?php echo "$disqus_sname";?>.disqus.com/count.js' async></script>
			</div><!-- Entry Comment --><?php
		}
    } else {
	 	if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	 		<!-- Entry Comment -->
			<div class="entry-comments">
				<div class="comment-wrap"><?php
					comments_popup_link(
						'0',
						'1',
						'%',
						'',
						'<span class="comment-off">'.__( 'Comments Off','designthemes-theme' ).'</span>'
					); ?>
				</div>
			</div><!-- Entry Comment --><?php
		}
	}?>