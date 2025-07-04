<?php
$sidebar_class   = savon_get_secondary_classes();
$active_sidebars = savon_get_active_sidebars();

if( $sidebar_class == 'content-full-width' ) {
    return;
}

if( empty( $active_sidebars ) ) {
    return;
}?>
<!-- Secondary -->
<section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>"><?php
    do_action( 'savon_before_single_sidebar_wrap' );

    get_sidebar();

    do_action( 'savon_after_single_sidebar_wrap' );?>
</section><!-- Secondary End -->