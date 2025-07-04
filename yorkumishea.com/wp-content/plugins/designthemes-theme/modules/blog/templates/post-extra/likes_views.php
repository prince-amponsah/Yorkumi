<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Likes Views -->
<div class="entry-likes-views"><?php

	$post_meta = get_post_meta( $post_ID, '_dt_post_settings', TRUE );
	$post_meta = is_array( $post_meta ) ? $post_meta  : array(); ?>

    <div class="dt-sc-like-views">
        <div class="likes dt_like_btn"><?php
        	$lcount = !empty( $post_meta['like_count'] ) ? $post_meta['like_count'] : 0; ?>
			<i class="dticon-heart"></i>
            <span><?php echo esc_html($lcount); ?></span>
        </div>

        <div class="views">
            <?php $vcount = !empty( $post_meta['view_count'] ) ? $post_meta['view_count'] : 0; ?>
			<i class="dticon-eye"></i>
            <span><?php echo esc_html($vcount); ?></span>
        </div>
    </div>
</div><!-- Entry Likes Views -->