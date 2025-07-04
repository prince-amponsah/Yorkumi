<?php
add_action( 'savon_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'savon-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, SAVON_THEME_VERSION, 'all');
}

add_action( 'savon_footer', 'footer_content' );
function footer_content() {
    savon_template_part( 'content', 'content', 'footer' );
}