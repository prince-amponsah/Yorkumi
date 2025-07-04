<?php
add_action( 'savon_after_main_css', 'post_style' );
function post_style() {
    if( is_singular('post') ) {
        wp_enqueue_style( 'savon-post', get_theme_file_uri('/modules/post/assets/css/post.css'), false, SAVON_THEME_VERSION, 'all');

        $post_style = savon_get_single_post_style( get_the_ID() );
        wp_enqueue_style( 'savon-post-'.$post_style, get_theme_file_uri('/modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css'), false, SAVON_THEME_VERSION, 'all');
    }
}

if( !function_exists('savon_get_single_post_style') ) {
	function savon_get_single_post_style( $post_id ) {
		return apply_filters( 'savon_single_post_style', 'custom-classic', $post_id );
	}
}

if( !function_exists('savon_single_post_params') ) {
    function savon_single_post_params() {
        $params = array(
            'enable_title'   		 => 1,
            'enable_image_lightbox'  => 0,
            'enable_disqus_comments' => 0,
            'post_disqus_shortname'  => '',
            'post_dynamic_elements'  => array( 'content', 'tag', 'navigation', 'comment_box' ),
            'post_commentlist_style' => 'rounded'
        );

        return apply_filters( 'savon_single_post_params', $params );
    }
}

add_action( 'savon_after_main_css', 'savon_single_post_enqueue_css' );
if( !function_exists( 'savon_single_post_enqueue_css' ) ) {
    function savon_single_post_enqueue_css() {

        wp_enqueue_style( 'savon-magnific-popup', get_theme_file_uri('/modules/post/assets/css/magnific-popup.css'), false, SAVON_THEME_VERSION, 'all');
    }
}

add_action( 'savon_before_enqueue_js', 'savon_single_post_enqueue_js' );
if( !function_exists( 'savon_single_post_enqueue_js' ) ) {
    function savon_single_post_enqueue_js() {

        wp_enqueue_script('jquery-magnific-popup', get_theme_file_uri('/modules/post/assets/js/jquery.magnific-popup.min.js'), array(), false, true);
    }
}

add_filter('post_class', 'savon_single_set_post_class', 10, 3);
if( !function_exists('savon_single_set_post_class') ) {
    function savon_single_set_post_class( $classes, $class, $post_id ) {

        if( is_singular('post') ) {
        	$classes[] = 'blog-single-entry';
        	$classes[] = 'post-'.savon_get_single_post_style( $post_id );
        }

        return $classes;
    }
}