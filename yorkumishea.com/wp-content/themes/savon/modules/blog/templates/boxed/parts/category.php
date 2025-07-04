<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Categories -->
<div class="entry-categories"><?php
	$cats = wp_get_object_terms($post_ID, 'category');
	if( !empty($cats) ):
		$count = count($cats);
		$out = '';
		foreach( $cats as $key => $term ) {
			$out .= '<a href="'.get_term_link( $term->slug ,'category').'">'.esc_html( $term->name ).'</a>';
			$key += 1;

			if( $key !== $count ){
				$out .= ' ';
			}
		}
		echo "<i class='dticon-folder'> </i>{$out}";
	endif; ?></div><!-- Entry Categories -->