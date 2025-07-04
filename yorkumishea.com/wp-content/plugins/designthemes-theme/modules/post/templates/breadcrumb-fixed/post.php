<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_single_post_params() ); ?>

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'savon_single_post_dynamic_template_part', savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->