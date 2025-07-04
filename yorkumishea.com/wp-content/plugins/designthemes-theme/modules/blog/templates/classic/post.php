<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, savon_archive_blog_post_params() );

	foreach ( $archive_post_elements as $key => $value ) {

		switch( $value ) {

			case 'title':
			case 'content':
			case 'feature_image':
			case 'read_more':
			case 'meta_group':
			case 'social':
				savon_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
				break;

			default:
				$path = savon_get_template_part( 'blog', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
				$path = !empty( $path ) ? $path : savon_get_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
				echo "{$path}";
				break;
		}

		if( 'meta_group' == $value ) :
			echo '<div class="entry-meta-group">';
				foreach ( $archive_meta_elements as $key => $value ) {

					switch( $value ) {
						case 'social':
							savon_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
							break;

						default:
							$path = savon_get_template_part( 'blog', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
							$path = !empty( $path ) ? $path : savon_get_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
							echo "{$path}";
							break;
					}
				}
			echo '</div>';
		endif;
	}

	do_action( 'savon_blog_post_entry_details_close_wrap' );