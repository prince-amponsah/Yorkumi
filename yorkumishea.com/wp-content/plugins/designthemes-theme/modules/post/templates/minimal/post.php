<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_single_post_params() ); ?>

	<!-- Post Header -->
	<div class="post-header">

		<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/category', '', $template_args ); ?>
	   	<?php if( $template_args['enable_title'] ) : ?>
		        <?php savon_template_part( 'post', 'templates/post-extra/title', '', $template_args ); ?>
		<?php endif; ?>
        <?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>

	</div><!-- Post Header -->

	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Meta -->
    <div class="post-meta">

    	<!-- Meta Left -->
    	<div class="meta-left">
			<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
    	</div><!-- Meta Left -->
    	<!-- Meta Right -->
    	<div class="meta-right">
			<?php savon_template_part( 'post', 'templates/post-extra/social', '', $template_args ); ?>
			<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>
    	</div><!-- Meta Right -->

    </div><!-- Post Meta -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'savon_single_post_dynamic_template_part', savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->