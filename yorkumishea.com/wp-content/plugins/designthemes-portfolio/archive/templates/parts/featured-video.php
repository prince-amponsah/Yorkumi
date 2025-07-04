<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$feature_settings = get_post_meta( $this->portfolio_id, '_dt_feature_settings', true );
$feature_settings = is_array( $feature_settings ) ? array_filter( $feature_settings ): array();
$video_type       = isset( $feature_settings['video_type'] ) ? $feature_settings['video_type']: '';

$popup_url = '';

if( $video_type == 'oembed' && !empty( $feature_settings['oembed_url'] ) ) {
    $popup_url = wp_oembed_get($feature_settings['oembed_url']);
    ?>
    <div class="dtportfolio-featured-video-holder">
        <div class="dtportfolio-featured-video-item">
            <?php echo $popup_url; ?>
        </div>
    </div>
    <?php
} else if( $video_type == 'self' && !empty( $feature_settings['self_url'] ) ) {
    $popup_url = wp_video_shortcode( array('src' => $feature_settings['self_url'], 'autoplay' => 'autoplay') );
    ?>
    <div class="dtportfolio-featured-video-holder">
        <div class="dtportfolio-featured-video-item">
            <?php echo $popup_url ?>
        </div>
    </div>
    <?php
} else {
    echo '<img src="'.esc_url($this->html_featured_image( 'full' )).'" alt="'.esc_attr($this->portfolio_title).'" title="'.esc_attr($this->portfolio_title).'" />';
}