<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( has_post_thumbnail( $post_ID ) ) :
		if( $enable_image_lightbox ):

            $img_url = get_the_post_thumbnail_url( $post_ID, 'full' );

			if( get_option('elementor_global_image_lightbox') ) : ?>
            	<a href="<?php echo esc_url($img_url); ?>" title="<?php the_title_attribute();?>"><?php
            else: ?>
            	<a href="<?php echo esc_url($img_url); ?>" title="<?php the_title_attribute();?>" class="mag-pop"><?php
            endif;
            	echo apply_filters( 'savon_single_post_image', get_the_post_thumbnail( $post_ID, 'full' ), $post_ID, $meta ); ?>
            </a><?php
		else:
    		echo apply_filters( 'savon_single_post_image', get_the_post_thumbnail( $post_ID, 'full' ), $post_ID, $meta );
		endif;
	endif;
?>