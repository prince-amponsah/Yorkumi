<?php
if( !function_exists( 'dtportfolio_img_tag' ) ) {
    function dtportfolio_img_tag( $thumb_id, $size='full', $class='' ) {
        $output = '';

        if( !empty( $thumb_id ) ) {
            $attachment = wp_get_attachment_image_src( $thumb_id, $size );
            if( $attachment ) {
                $alt    = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
                $title  = get_the_title( $thumb_id );
                $output = '<img src="'.esc_url( $attachment[0] ).'" alt="'.esc_attr( $alt ).'" title="'.esc_attr( $title ).'"/>';
            }
        }

        return $output;
    }
}