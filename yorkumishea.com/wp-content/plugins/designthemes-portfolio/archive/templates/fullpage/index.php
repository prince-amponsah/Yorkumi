<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveFullpageTemplate' ) ) {
    class DesignThemesPortfolioArchiveFullpageTemplate extends DesignThemesPortfolioArchiveBase {

        /*
        * Container - Filters & Actions
        */

            function container_filters_and_actions() {

                add_filter( 'dtportfolio_container_classes', array ( $this, 'tpl_container_classes' ), 5, 1 );
                add_filter( 'dtportfolio_container_attributes', array ( $this, 'tpl_container_attributes' ), 5, 1 );

            }

            function tpl_container_classes( $classes ) {

                extract($this->settings);

                array_push( $classes, 'dtportfolio-container-fullpage' );

                if($fullpage_type == 'splitted-section') {
                    array_push( $classes, 'fullpage-'.$fullpage_type );
                    array_push( $classes, $fullpage_splitted_sections );
                } else {
                    array_push( $classes, 'fullpage-default' );
                }

                return $classes;

            }

            function tpl_container_attributes( $attributes ) {

                extract($this->settings);

                if(is_array($this->settings) && !empty($this->settings)) {

                    $filtered_settings = array_filter(
                        $this->settings,
                        function($k) {
                            return preg_match('#fullpage_#', $k);
                        },
                        ARRAY_FILTER_USE_KEY
                    );

                    array_push( $attributes, 'data-settings="'.esc_js(json_encode($filtered_settings)).'"' );

                }

                return $attributes;

            }

        /*
        * Item - Setup Loop
        */

            function item_setup_loop($current_post) {

                $this->item_filters_and_actions();
                $loop = $this->item_loop($current_post);
                $this->reset_all_item_filters_and_actions();

                return $loop;

            }

        /*
        * Item - Filters and Actions
        */

            function item_filters_and_actions() {

                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_post_style_class' ), 5, 1 );
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_common_class' ), 10, 1 );
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_misc_hover_state_class' ), 15, 1 );

                add_filter( 'dtportfolio_item_attributes', array ( $this, 'item_bg_image_attributes' ), 5, 1 );

            }

            function item_post_style_class( $classes ) {

                extract($this->settings);

                array_push( $classes, 'dtportfolio-fullpage' );
                array_push( $classes, 'section' );
                array_push( $classes, 'dtportfolio-column dtportfolio-one-column' );
                array_push( $classes, 'no-space' );

                if($fullpage_type == 'splitted-section') {
                    array_push( $classes, 'dtportfolio-fullpage-splitted-section' );
                }


                return $classes;

            }

            function item_bg_image_attributes( $attributes ) {

                extract($this->settings);

                if($fullpage_type != 'splitted-section' && $featured_display == 'image') {
                    array_push( $attributes, 'style="background-image:url('.esc_url($this->html_featured_image( 'full' )).');"' );
                }

                return $attributes;

            }

        /*
        * Item - Loop
        */

            function item_loop($current_post) {

                extract($this->settings);

                $output = '';

                $output .= '<div class="'.implode(' ', apply_filters('dtportfolio_item_classes', array ( 'dtportfolio-item' )) ).'" '.implode(' ', apply_filters('dtportfolio_item_attributes', array ()) ).'>';

                    $output .= '<figure>';

                        if(($fullpage_type == 'splitted-section' && $fullpage_splitted_sections == 'leftside-image') || ($fullpage_type == 'splitted-section' && $fullpage_splitted_sections == 'alternate-content' && $current_post%2 == 0)):

                            $output .= '<div class="dtportfolio-column dtportfolio-one-half no-space first">';

                                if($featured_display == 'video') {

                                    ob_start();
                                    include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/featured-video.php';
                                    $output .= ob_get_clean();

                                } else {

                                    $image_settings = array (
                                        'image_size' => 'full',
                                        'image_type' => ''
                                    );
                                    ob_start();
                                    include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/featured-image.php';
                                    $output .= ob_get_clean();

                                }

                            $output .= '</div>';
                            $output .= '<div class="dtportfolio-column dtportfolio-one-half no-space">';

                                include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/image-overlay.php';
                                $patp_io = new \DesignThemesPortfolioArchiveTemplatePartsImageOverlay($this->portfolio_id, $this->settings);
                                $output .= $patp_io->overlay_output();

                            $output .= '</div>';

                        elseif(($fullpage_type == 'splitted-section' && $fullpage_splitted_sections == 'rightside-image') || ($fullpage_type == 'splitted-section' && $fullpage_splitted_sections == 'alternate-content' && $current_post%2 != 0)):

                            $output .= '<div class="dtportfolio-column dtportfolio-one-half no-space first">';

                                include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/image-overlay.php';
                                $patp_io = new \DesignThemesPortfolioArchiveTemplatePartsImageOverlay($this->portfolio_id, $this->settings);
                                $output .= $patp_io->overlay_output();

                            $output .= '</div>';
                            $output .= '<div class="dtportfolio-column dtportfolio-one-half no-space">';

                                if($featured_display == 'video') {

                                    ob_start();
                                    include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/featured-video.php';
                                    $output .= ob_get_clean();

                                } else {

                                    $image_settings = array (
                                        'image_size' => 'full',
                                        'image_type' => ''
                                    );
                                    ob_start();
                                    include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/featured-image.php';
                                    $output .= ob_get_clean();

                                }

                            $output .= '</div>';

                        else:

                            if($fullpage_type != 'splitted-section' && $featured_display == 'video') {

                                ob_start();
                                include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/featured-video.php';
                                $output .= ob_get_clean();

                            }

                            include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/image-overlay.php';
                            $patp_io = new \DesignThemesPortfolioArchiveTemplatePartsImageOverlay($this->portfolio_id, $this->settings);
                            $output .= $patp_io->overlay_output();

                        endif;

                    $output .= '</figure>';

                    if($details_position == 'details-below-image') {
                        $output .= '<div class="details-holder">';
                            $output .= $this->html_title();
                            $output .= $this->html_terms();
                        $output .= '</div>';
                    }

                $output .= '</div>';

                return $output;

            }

    }
}