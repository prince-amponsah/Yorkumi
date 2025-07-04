<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$img_size = array(
		'one-column' => 'full',
		'one-half-column' => 'savon-blog-ii-column',
		'one-third-column' => 'savon-blog-iii-column',
		'one-fourth-column' => 'savon-blog-iv-column'
	);

	$post_column = savon_get_archive_post_column();

	if( has_post_thumbnail( $post_ID ) ) :
		do_action( 'savon_blog_archive_post_thumbnail', $post_ID, $img_size, $post_column );
	endif;
?>