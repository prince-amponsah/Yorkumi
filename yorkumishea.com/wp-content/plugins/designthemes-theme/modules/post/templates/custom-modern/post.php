<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_single_post_params() ); ?>

	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
   	<?php if( $template_args['enable_title'] ) : ?>
	        <?php savon_template_part( 'post', 'templates/post-extra/title', '', $template_args ); ?>
	<?php endif; ?>

	<!-- Meta Group -->
	<div class="dt-sc-posts-meta-group metagroup-horizontal-separator">

		<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
		<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>
		<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/category', '', $template_args ); ?>
		<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/tag', '', $template_args ); ?>
		<?php savon_template_part( 'post', 'templates/post-extra/likes_views', '', $template_args ); ?>

	</div><!-- Meta Group -->

	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'savon_single_post_dynamic_template_part', savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->