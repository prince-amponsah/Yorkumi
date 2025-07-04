<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if($image_settings['image_type'] == 'bg') {
    echo '<div class="dtportfolio-image-holder" style="background-image:url('.esc_url($this->html_featured_image( $image_settings['image_size'] )).');"></div>';
} else {
    echo '<img src="'.esc_url($this->html_featured_image( $image_settings['image_size'] )).'" alt="'.esc_attr($this->portfolio_title).'" title="'.esc_attr($this->portfolio_title).'" />';
}