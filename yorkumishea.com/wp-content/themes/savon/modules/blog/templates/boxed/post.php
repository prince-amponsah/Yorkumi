<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_archive_blog_post_params() );

	foreach ( $archive_post_elements as $key => $value ) {
		savon_template_part( 'blog', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );

		if( 'meta_group' == $value ) :
			echo '<div class="entry-meta-group">';
				foreach ( $archive_meta_elements as $key => $value ) {
					savon_template_part( 'blog', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
				}
			echo '</div>';
		endif;
	}