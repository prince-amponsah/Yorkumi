<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Content -->
<div class="single-entry-body">
	<?php the_content();?>
	<?php wp_link_pages( array( 'before'=>'<div class="page-link">', 'after'=>'</div>', 'link_before'=>'<span>', 'link_after'=>'</span>', 'next_or_number'=>'number', 'pagelink' => '%', 'echo' => 1 ) );?>
	<?php edit_post_link( esc_html__( ' Edit ','designthemes-theme' ) ); ?>
</div><!-- Entry Content -->