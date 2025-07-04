<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="pagination blog-pagination"><?php 
    if( get_previous_posts_link() ) {?><div class="newer-posts"><?php
        echo get_previous_posts_link( '<i class="dticon-angle-left"></i>'.esc_html__(' Newer Posts', 'designthemes-theme') ); ?></div><?php
    }

    if( get_next_posts_link() ){?><div class="older-posts"><?php
        echo get_next_posts_link( esc_html__('Older Posts ', 'designthemes-theme').'<i class="dticon-angle-right"></i>' );?></div><?php
    }
?></div>