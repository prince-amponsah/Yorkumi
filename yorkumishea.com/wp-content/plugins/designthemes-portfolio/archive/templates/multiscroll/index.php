<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveMultiscrollTemplate' ) ) {
    class DesignThemesPortfolioArchiveMultiscrollTemplate extends DesignThemesPortfolioArchiveBase {

        /*
        * Container - Filters & Actions
        */

            function container_filters_and_actions() {

                add_filter( 'dtportfolio_container_classes', array ( $this, 'tpl_container_classes' ), 5, 1 );
                add_action( 'dtportfolio_listings_after_container_div', array ( $this, 'tpl_multiscroll_pagination' ), 5 );

            }

            function tpl_container_classes( $classes ) {

                array_push( $classes, 'dtportfolio-container-multiscroll' );

                return $classes;

            }

            function tpl_multiscroll_pagination() {

                extract($this->settings);

                $output = '';

                if( $post_style == 'multiscroll' && $multiscroll_enable_arrows == 'true' ) {

                    $output .= '<div class="multiscroll-button-holder">';
                        $output .= '<div class="multiscroll-button down">Up</div>';
                        $output .= '<div class="multiscroll-button up">Down</div>';
                    $output .= '</div>';

                }

                echo $output;

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

            }

            function item_post_style_class( $classes ) {

                extract($this->settings);

                array_push( $classes, 'dtportfolio-multiscroll' );
                array_push( $classes, 'ms-section' );

                return $classes;

            }

        /*
        * Item - Loop
        */

            function item_loop($current_post) {

                extract($this->settings);

                $output = '';

                $half_count = ($total_count/2)-1;

                if($current_post == 0) {
                    $output .= '<div class="ms-left">';
                }

                    $output .= '<div class="'.implode(' ', apply_filters('dtportfolio_item_classes', array ( 'dtportfolio-item' )) ).'" '.implode(' ', apply_filters('dtportfolio_item_attributes', array ()) ).'>';

                        $output .= '<figure>';

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

                            include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/image-overlay.php';
                            $patp_io = new \DesignThemesPortfolioArchiveTemplatePartsImageOverlay($this->portfolio_id, $this->settings);
                            $output .= $patp_io->overlay_output();

                        $output .= '</figure>';

                    $output .= '</div>';

                if($current_post == $half_count) {
                    $output .= '</div>';
                    $output .= '<div class="ms-right">';
                }

                if($current_post == ($total_count-1)) {
                    $output .= '</div>';
                }

                return $output;

            }

    }
}