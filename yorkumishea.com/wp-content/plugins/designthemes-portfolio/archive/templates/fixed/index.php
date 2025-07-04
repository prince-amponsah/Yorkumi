<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveFixedTemplate' ) ) {
    class DesignThemesPortfolioArchiveFixedTemplate extends DesignThemesPortfolioArchiveBase {

        /*
        * Container - Filters & Actions
        */

            function container_filters_and_actions() {

                add_filter( 'dtportfolio_container_classes', array ( $this, 'tpl_container_classes' ), 5, 1 );

            }

            function tpl_container_classes( $classes ) {

                extract($this->settings);

                // Default Class
                    array_push( $classes, 'dtportfolio-container' );

                // Post Style 
                    array_push( $classes, 'dtportfolio-container-fixed' );

                // Ajax Load
                    if( in_array($pagination_type, array ('load-more', 'lazy-load')) ) {
                        array_push( $classes, 'dtportfolio-infinite-portfolio-container' );
                    }

                // Display Style
                    if( $listing_display_style == 'carousel' ) {
                        array_push( $classes, 'swiper-wrapper' );
                    } else  {
                        array_push( $classes, 'apply-portfolio-isotope' );
                    }

                return $classes;

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
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_column_class' ), 10, 1 );
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_common_class' ), 15, 1 );
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_misc_hover_state_class' ), 20, 1 );
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_misc_animation_class' ), 25, 1 );

                add_filter( 'dtportfolio_item_attributes', array ( $this, 'item_misc_animation_attributes' ), 5, 1 );

            }

            function item_post_style_class( $classes ) {

                extract($this->settings);

                array_push( $classes, 'dtportfolio-fixed' );

                return $classes;

            }

        /*
        * Item - Loop
        */

            function item_loop($current_post) {

                extract($this->settings);

                $output = '';

                $output .= '<div class="'.implode(' ', apply_filters('dtportfolio_item_classes', array ( 'dtportfolio-item' )) ).'" '.implode(' ', apply_filters('dtportfolio_item_attributes', array ()) ).'>';

                    $output .= '<figure>';

                        $image_settings = array (
                            'image_size' => 'full',
                            'image_type' => 'bg'
                        );
                        ob_start();
                        include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/featured-image.php';
                        $output .= ob_get_clean();

                        include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/image-overlay.php';
                        $patp_io = new \DesignThemesPortfolioArchiveTemplatePartsImageOverlay($this->portfolio_id, $this->settings);
                        $output .= $patp_io->overlay_output();

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