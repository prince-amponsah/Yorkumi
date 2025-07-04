<?php 
    if( empty( $code ) ) {
        return;
    }?>
<div id="slider">
    <div id="dt-sc-layer-slider" class="dt-sc-main-slider"><?php
        echo do_shortcode('[layerslider id="'.esc_attr( $code ).'"/]');
    ?></div>
</div>