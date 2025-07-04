<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_single_post_params() ); ?>

    <?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <div class="entry-bottom-details">

    	<div class="column dt-sc-one-half first">
    		<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
    	</div>
    	<div class="column dt-sc-one-half">
			<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
			<?php savon_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>
    	</div>

    </div>

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'savon_single_post_dynamic_template_part', savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->