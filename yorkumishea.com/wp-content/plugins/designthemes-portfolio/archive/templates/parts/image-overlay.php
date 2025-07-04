<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveTemplatePartsImageOverlay' ) ) {
    class DesignThemesPortfolioArchiveTemplatePartsImageOverlay extends DesignThemesPortfolioArchiveBase {

        public $portfolio_id;

        public $portfolio_title;

        public $portfolio_permalink;

        public $settings;

        public $hover_background_color;

        public $hover_content_color;

        public $hover_gradient_color;

        public $hover_gradient_direction;

        public $hover_style;

        public function __construct($portfolio_id, $settings) {
            $this->portfolio_id        = $portfolio_id;
            $this->portfolio_title     = get_the_title($portfolio_id);
            $this->portfolio_permalink = get_permalink($portfolio_id);
            $this->settings            = $settings;
        }

        /*
        * Overlay Output
        */

            function overlay_output() {

                $this->set_variables();
                $this->filters_and_actions();
                $html = $this->html();
                $this->reset_all_filters_and_actions();

                return $html;

            }

        /*
        * Set Variables
        */

            function set_variables() {

                extract($this->settings);

                if($disable_misc_options == 'true') {

                    $this->hover_background_color   = $misc_hover_background_color;
                    $this->hover_content_color      = $misc_hover_content_color;
                    $this->hover_gradient_color     = $misc_hover_gradient_color;
                    $this->hover_gradient_direction = $misc_hover_gradient_direction;

                } else {

                    $this->hover_background_color   = ( isset($this->item_listing_settings['hover_background_color']) && !empty($this->item_listing_settings['hover_background_color']) ) ? $this->item_listing_settings['hover_background_color'] : '';
                    $this->hover_content_color      = ( isset($this->item_listing_settings['hover_content_color']) && !empty($this->item_listing_settings['hover_content_color']) ) ? $this->item_listing_settings['hover_content_color'] : '';
                    $this->hover_gradient_color     = ( isset($this->item_listing_settings['hover_gradient_color']) && !empty($this->item_listing_settings['hover_gradient_color']) ) ? $this->item_listing_settings['hover_gradient_color'] : '';
                    $this->hover_gradient_direction = ( isset($this->item_listing_settings['hover_gradient_direction']) && !empty($this->item_listing_settings['hover_gradient_direction']) ) ? $this->item_listing_settings['hover_gradient_direction'] : '';

                }

                $this->hover_style = $hover_style;

            }

        /*
        * Filters & Actions
        */

            function filters_and_actions() {

                add_filter( 'dtportfolio_image_overlay_classes', array ( $this, 'overlay_classes' ), 5, 1 );
                add_filter( 'dtportfolio_image_overlay_attributes', array ( $this, 'overlay_style_attributes' ), 5, 1 );
                add_filter( 'dtportfolio_image_overlay_attributes', array ( $this, 'overlay_ilightbox_attributes' ), 10, 1 );

            }

            function overlay_classes( $classes ) {

                if($this->hover_content_color != '') {
                    array_push( $classes, $this->hover_content_color );
                }

                return $classes;

            }

            function overlay_style_attributes( $attributes ) {

                if($this->hover_background_color != '' && $this->hover_gradient_color != '') {

                    if($this->hover_gradient_direction == 'diagonal') {

                        $style = 'style="background:-webkit-linear-gradient(60deg, '.$this->hover_background_color.', '.$this->hover_gradient_color.');background:linear-gradient(60deg, '.$this->hover_background_color.', '.$this->hover_gradient_color.');filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='.$this->hover_background_color.', endColorstr='.$this->hover_gradient_color.',GradientType=1) \0/IE9;"';
                        array_push( $attributes, $style );

                    } else if($this->hover_gradient_direction == 'toptobottom') {

                        $style = 'style="background:linear-gradient(to bottom, '.$this->hover_background_color.', '.$this->hover_gradient_color.'); background:-webkit-linear-gradient(top, '.$this->hover_background_color.', '.$this->hover_gradient_color.'); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='.$this->hover_background_color.', endColorstr='.$this->hover_gradient_color.',GradientType=0) \0/IE9;"';
                        array_push( $attributes, $style );

                    } else {

                        $style = 'style="background: linear-gradient(to left, '.$this->hover_background_color.', '.$this->hover_gradient_color.'); background:-webkit-linear-gradient(right, '.$this->hover_background_color.', '.$this->hover_gradient_color.'); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='.$this->hover_background_color.', endColorstr='.$this->hover_gradient_color.',GradientType=1) \0/IE9;"';
                        array_push( $attributes, $style );

                    }

                } else if($this->hover_background_color != '') {

                    if($this->hover_style == 'minimal-icons') {

                        $css = '.dtportfolio-item.dtportfolio-hover-minimal-icons .dtportfolio-image-overlay:before, .dtportfolio-item.dtportfolio-hover-minimal-icons .dtportfolio-image-overlay:after, .dtportfolio-item.dtportfolio-hover-minimal-icons figure::before, .dtportfolio-item.dtportfolio-hover-minimal-icons figure:after, .dtportfolio-item.dtportfolio-hover-minimal-icons .dtportfolio-image-overlay h2, .dtportfolio-item.details-below-image.dtportfolio-hover-minimal-icons .details-holder h2 { background:'.$this->hover_background_color.'; }';
                        wp_add_inline_style( 'dtportfolio-listing',  $css );

                    } else {

                        $style = 'style="background:'.$this->hover_background_color.'"';
                        array_push( $attributes, $style );

                    }

                }

                return $attributes;

            }

            function overlay_ilightbox_attributes( $attributes ) {

                if($this->hover_style == 'with-gallery-thumb' || $this->hover_style == 'with-gallery-list') {
                    $ilightbox_attr = 'data-ilightboxid="portfolio-ilightbox-'.$this->portfolio_id.'"';
                    array_push( $attributes, $ilightbox_attr );
                }

                return $attributes;

            }

        /*
        * HTML
        */

            function html() {

                extract($this->settings);

                $output = '';

                $output .= '<div class="'.implode(' ', apply_filters('dtportfolio_image_overlay_classes', array ( 'dtportfolio-image-overlay' )) ).'" '.implode(' ', apply_filters('dtportfolio_image_overlay_attributes', array ()) ).'>';

                    if($this->hover_style == 'with-gallery-list') {

                        $output .= '<div class="dtportfolio-image-overlay-container">';
                            $output .= $this->html_links();

                            $output .= '<div class="dtportfolio-image-overlay-details">';
                                $output .= $this->html_terms();
                                $output .= $this->html_title();
                            $output .= '</div>';
                            $output .= $this->html_details();
                            $output .= $this->html_gallery();
                        $output .= '</div>';

                    } else if($this->hover_style == 'with-intro') {

                        $output .= '<div class="dtportfolio-image-overlay-details">';
                            $output .= do_shortcode(get_the_excerpt($this->portfolio_id));
                        $output .= '</div>';

                    } else {

                        $output .= $this->html_links();
                        $output .= '<div class="dtportfolio-image-overlay-details">';

                            $output .= $this->html_title();
                            $output .= $this->html_terms();

                            if($this->hover_style == 'with-details') {
                                $output .= $this->html_details();
                            }

                        $output .= '</div>';

                        if($this->hover_style == 'with-gallery-thumb') {
                            $output .= $this->html_gallery();
                        }

                    }

                $output .= '</div>';

                return $output;

            }

            function html_links() {

                $image_src_url = '#';

                $feature_settings = get_post_meta( $this->portfolio_id, '_dt_feature_settings', true );
                if( isset( $feature_settings['image'] ) && !empty( $feature_settings['image'] ) ) {
                    $image_src     = wp_get_attachment_image_src( $feature_settings['image'], 'full' );
                    $image_src_url = $image_src[0];
                }

                $output = '';

                $output .= '<div class="links">';
                    $output .= '<a href="'.esc_attr($this->portfolio_permalink).'" title="'.esc_attr($this->portfolio_title).'"><span class="dticon-link"></span></a>';
                    $output .= '<a href="'.esc_url($image_src_url).'" title="'.esc_attr($this->portfolio_title).'" data-gal="prettyPhoto[dtgallery]"> <span class="dticon-search"> </span> </a>';
                $output .= '</div>';

                return $output;

            }

            function html_details() {

                $output = '';

                $output .= '<p class="dtportfolio-image-overlay-description">'.get_the_excerpt($this->portfolio_id).'</p>';
                $output .= '<a title="'.esc_attr($this->portfolio_title).'" href="'.esc_url($this->portfolio_permalink).'" class="dtportfolio-gallery-link">'.esc_html__('View Gallery', 'dtportfolio').'<span class="dticon-angle-double-right"></span></a>';

                return $output;

            }

            function html_gallery() {

                $output = '';

                $ft_settings = get_post_meta( $this->portfolio_id, '_dt_feature_settings', true );
                $ft_gallery_ids = ( isset($ft_settings['gallery_items']) && !empty($ft_settings['gallery_items']) ) ? array_filter( explode( ',', $ft_settings['gallery_items'] ) ) : array ();

                if( is_array($ft_gallery_ids) && !empty($ft_gallery_ids) ) {

                    $ilightbox_id = 'portfolio-ilightbox-'.$this->portfolio_id;

                    $output .= '<ul>';

                        $galleries = array_slice($ft_gallery_ids, 0, 3);
                        foreach( $galleries as $image_id ) {

                            $image_src     = wp_get_attachment_image_src($image_id, 'dtportfolio-450x450', false);
                            $image_src_url = $image_src[0];

                            if($image_src != '') {

                                $image_src_full     = wp_get_attachment_image_src($image_id, 'full', false);
                                $image_src_full_url = $image_src_full[0];

                                $output .= '<li><img src="'.esc_url($image_src_url).'" alt="'.esc_attr($this->portfolio_title).'" title="'.esc_attr($this->portfolio_title).'" class="'.esc_attr($ilightbox_id).'" data-ilightboximg="'.esc_url($image_src_full_url).'" /></li>';

                            }

                        }

                    $output .= '</ul>';

                }


                return $output;

            }

        /*
        * Reset All Filters & Actions
        */

            function reset_all_filters_and_actions() {

                remove_all_filters( 'dtportfolio_image_overlay_classes' );
                remove_all_filters( 'dtportfolio_image_overlay_attributes' );

            }

    }
}