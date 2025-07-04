<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Author -->
<div class="entry-author">
	<span>
		<?php esc_html_e('Posted by: ', 'designthemes-theme'); ?>
	    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>" title="<?php esc_attr_e('View all posts by ', 'designthemes-theme'); echo get_the_author();?>">
	        <?php echo get_the_author();?>
	    </a>
	</span>
</div><!-- Entry Author -->