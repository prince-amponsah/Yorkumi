<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Title -->
<div class="single-entry-title"><?php if( is_sticky( $post_ID ) ) echo '<span class="sticky-post">'.esc_html__('Featured', 'designthemes-theme').'</span>'; ?><h1><?php the_title();?></h1></div><!-- Entry Title -->