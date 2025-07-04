<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Likes Views -->
<div class="single-entry-likes-views">
	<div class="dt-sc-like-views">
        <div class="likes dt_like_btn">
            <i class="dticon-heart"></i>
            <a href="#" data-postid="<?php echo esc_attr($post_ID); ?>" data-action="like">
                <span><?php
					$post_meta = get_post_meta ( $post_ID, '_dt_post_settings', TRUE );
					$post_meta = is_array ( $post_meta ) ? $post_meta : array ();

					$lc = array_key_exists( 'like_count', $post_meta ) && !empty( $post_meta['like_count'] ) ?  $post_meta['like_count'] : '0';
					echo "{$lc}";
                ?></span>
            </a>
        </div>

        <div class="views">
            <i class="dticon-eye"></i>
            	<span><?php
					$v = array_key_exists( 'view_count', $post_meta ) && !empty( $post_meta['view_count'] ) ?  $post_meta['view_count'] : 0;
					$v = $v + 1;
					$post_meta['view_count'] = $v;

					update_post_meta( $post_ID, '_dt_post_settings', $post_meta );
					echo "{$v}";
            	?></span>
        </div>
	</div>
</div><!-- Entry Likes Views -->