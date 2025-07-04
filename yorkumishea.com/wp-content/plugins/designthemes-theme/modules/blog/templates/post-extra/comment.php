<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $enable_disqus_comments && $post_disqus_shortname != '' ) : ?>
		<!-- Entry Comment -->
		<div class="entry-comments">
			<?php echo '<i class="dticon-comment"> </i><a href="'.get_permalink($post_ID).'#disqus_thread"></a>'; ?>
			<script id="dsq-count-scr" src='//<?php echo "{$post_disqus_shortname}";?>.disqus.com/count.js' async></script>
		</div><!-- Entry Comment --><?php
	else :
		if( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
		<!-- Entry Comment -->
		<div class="entry-comments"><?php        
			comments_popup_link('<i class="dticon-comment"> </i> 0', '<i class="dticon-comment"> </i> 1', '<i class="dticon-comment"> </i> %', '', '<i class="dticon-comment"> </i> 0'); ?>
        </div><!-- Entry Comment --><?php
		}
	endif; ?>