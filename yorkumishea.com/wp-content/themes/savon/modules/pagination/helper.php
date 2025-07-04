<?php
add_action( 'savon_after_main_css', 'pagination_style' );
function pagination_style() {
    wp_enqueue_style( 'savon-pagination', get_theme_file_uri('/modules/pagination/assets/css/pagination.css'), false, SAVON_THEME_VERSION, 'all');
}

if( !function_exists( 'after_single_page_content_wp_link_pages' ) ) {

    function after_single_page_content_wp_link_pages() {
        wp_link_pages(array(
            'before'         => '<div class="page-link">',
            'after'          => '</div>',
            'link_before'    => '<span>',
            'link_after'     => '</span>',
            'next_or_number' => 'number',
            'pagelink'       => '%',  
        ));

        edit_post_link( esc_html__( ' Edit ','savon' ) );
    }

    add_action( 'savon_after_single_page_content', 'after_single_page_content_wp_link_pages' );
}

if( !function_exists( 'savon_pagination' ) ) {
    function savon_pagination( $query = false, $load_more = false ) {

        global $wp_query;
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

        // default $wp_query
        if( $query ) {
            $custom_query = $query;
        } else {
            $custom_query = $wp_query;
        }

        $custom_query->query_vars['paged'] > 1 ? $current = $custom_query->query_vars['paged'] : $current = 1;

        if( empty( $paged ) ) $paged = 1;
        $prev = $paged - 1;
        $next = $paged + 1;

        $end_size = 1;
        $mid_size = 2;
        #$show_all = savon_get_option( 'showall-pagination' );
        $dots = false;

        if( ! $total = $custom_query->max_num_pages ) $total = 1;

        $output = '';
        if( $total > 1 )
        {
            if( $load_more ){
                // ajax load more -------------------------------------------------
                if( $paged < $total ){
                    $output .= '<div class="column one pager_wrapper pager_lm">';
                        $output .= '<a class="pager_load_more button button_js" href="'. get_pagenum_link( $next ) .'">';
                            $output .= '<span class="button_icon"><i class="icon-layout"></i></span>';
                            $output .= '<span class="button_label">'. esc_html__('Load more', 'savon') .'</span>';
                        $output .= '</a>';
                    $output .= '</div>';
                }

            } else {
                // default -------------------------------------------------------- 
                $output .= '<div class="column one pager_wrapper">';

                    $big = 999999999; // need an unlikely integer
                    $args = array(
                        'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'total'              => $custom_query->max_num_pages,
                        'current'            => max( 1, get_query_var('paged') ),
                        #'show_all'           => $show_all,
                        'end_size'           => $end_size,
                        'mid_size'           => $mid_size,
                        'prev_next'          => true,
                        'prev_text'          => '<i class="dticon-angle-double-left"></i>',
                        'next_text'          => '<i class="dticon-angle-double-right"></i>',
                        'type'               => 'list'
                    );
                    $output .= paginate_links( $args );

                $output .= '</div>'."\n";
            }
        }
        return $output;
    }
}