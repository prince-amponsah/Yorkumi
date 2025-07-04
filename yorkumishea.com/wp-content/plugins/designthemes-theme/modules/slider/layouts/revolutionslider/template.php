<?php 
    if( empty( $code ) ) {
        return;
    }?>
<div id="slider">
    <div id="dt-sc-rev-slider" class="dt-sc-main-slider"><?php
        echo do_shortcode('[rev_slider '.esc_attr( $code ).'/]');
    ?></div>
</div>