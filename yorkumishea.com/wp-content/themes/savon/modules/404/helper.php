<?php
add_action( 'savon_after_main_css', 'notfound_style' );
function notfound_style() {
    if( is_404() ) {
        wp_enqueue_style( 'savon-404', get_theme_file_uri('/modules/404/assets/css/404.css'), false, SAVON_THEME_VERSION, 'all');
    }
}

add_filter( 'dt_theme_plugin_add_inline_style', 'notfound_inline_style' );
function notfound_inline_style( $style ) {
    if( is_404() ) {
        $params = savon_404_page_params();

        if( isset( $params['notfound_bg_style'] ) && !empty( $params['notfound_bg_style'] ) ) {
            $style .= 'body.error404 div.wrapper {'.$params['notfound_bg_style'].'}'."\n";
        }

        if( isset( $params['notfound_bg'] ) ) {
            $bgoptions = $params['notfound_bg'];
            $css = !empty( $bgoptions['background-image'] ) ? 'background-image: url("'.$bgoptions['background-image'].'");':'';
            $css .= !empty( $bgoptions['background-attachment'] ) ? 'background-attachment:'.$bgoptions['background-attachment'].';':'';
            $css .= !empty( $bgoptions['background-position'] ) ? 'background-position:'.$bgoptions['background-position'].';':'';
            $css .= !empty( $bgoptions['background-size'] ) ? 'background-size:'.$bgoptions['background-size'].';':'';
            $css .= !empty( $bgoptions['background-repeat'] ) ? 'background-repeat:'.$bgoptions['background-repeat'].';':'';
            $css .= !empty( $bgoptions['background-color'] ) ? 'background-color:'.$bgoptions['background-color'].';':'';

            if( !empty( $css ) ) {
                $style .= 'body.error404 div.wrapper {'.$css.'}'."\n";
            }
        }

    }
    return $style;
}

function savon_404_page_params() {
    $params = array(
        'enable_404message' => 1,
        'notfound_style'    => 'type2',
        'notfound_darkbg'   => 1,
        'notfound_bg_style' => 'background-color:var(--DTBlackColor);'
    );

    return apply_filters( 'savon_404_page_params', $params );
}