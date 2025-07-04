<?php 
    if( empty( $code ) ) {
        return;
    }?>
	<div id="slider">
	    <div id="dt-sc-custom-slider" class="dt-sc-main-slider"><?php
	        echo do_shortcode( $code );
	    ?></div>
	</div>