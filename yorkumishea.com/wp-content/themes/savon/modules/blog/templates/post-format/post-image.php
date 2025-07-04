<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$img_size = array(
		'one-column' => 'full',
		'one-half-column' => 'savon-blog-ii-column',
		'one-third-column' => 'savon-blog-iii-column',
		'one-fourth-column' => 'savon-blog-iv-column'
	);

	$post_column = savon_get_archive_post_column();

	if( has_post_thumbnail( $post_ID ) ) : ?>
		<a href="<?php echo get_permalink($post_ID);?>" title="<?php printf(esc_attr__('Permalink to %s','savon'), the_title_attribute('echo=0'));?>">
			<?php echo get_the_post_thumbnail( $post_ID, $img_size[$post_column] );?>
		</a><?php
	endif;
?>