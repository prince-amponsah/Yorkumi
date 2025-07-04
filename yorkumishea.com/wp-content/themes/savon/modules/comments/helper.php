<?php
add_action( 'savon_after_main_css', 'comment_style' );
function comment_style() {
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_style( 'savon-comments', get_theme_file_uri('/modules/comments/assets/css/comments.css'), false, SAVON_THEME_VERSION, 'all');
    }
}

if( ! function_exists('include_comments_template') ) {
    function include_comments_template() {
        comments_template();
    }

    add_action( 'savon_after_single_page_content_wrap', 'include_comments_template' );    
}

if( ! function_exists( 'load_comments_template' )  ) {
	function load_comments_template() {
		savon_template_part( 'comments', 'templates/comments' );
	}

	add_action( 'savon_comments_template', 'load_comments_template' );    	
}

