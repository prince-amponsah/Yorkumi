<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_single_post_params() ); ?>

    <!-- Featured Image -->
    <div class="entry-thumb single-preview-img">

    	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>
    	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
    	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>

	</div><!-- Featured Image -->

	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/category', '', $template_args ); ?>
	<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/tag', '', $template_args ); ?>

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'savon_single_post_dynamic_template_part', savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->