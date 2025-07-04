<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $enable_disqus_comments && $post_disqus_shortname != '' ) : ?>
		<!-- Entry Comment -->
		<div class="entry-comments">
			<?php echo '<i class="pe-icon pe-chat"> </i><a href="'.get_permalink($post_ID).'#disqus_thread"></a>'; ?>
			<script id="dsq-count-scr" src='//<?php echo "{$disqus_name}";?>.disqus.com/count.js' async></script>
		</div><!-- Entry Comment --><?php
	else :
		if( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			comments_popup_link('<i class="pe-icon pe-chat"> </i> 0', '<i class="pe-icon pe-chat"> </i> 1', '<i class="pe-icon pe-chat"> </i> %', '', '<i class="pe-icon pe-chat"> </i> 0');
		}
	endif; ?>