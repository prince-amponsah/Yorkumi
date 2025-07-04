<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_single_post_params() ); ?>

<?php savon_template_part( 'post', 'templates/post-extra/content', '', $template_args ); ?>