<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveParallaxTemplate' ) ) {
    class DesignThemesPortfolioArchiveParallaxTemplate extends DesignThemesPortfolioArchiveBase {

        /*
        * Container - Filters & Actions
        */

            function container_filters_and_actions() {

                add_filter( 'dtportfolio_container_classes', array ( $this, 'tpl_container_classes' ), 5, 1 );

            }

            function tpl_container_classes( $classes ) {

                array_push( $classes, 'dtportfolio-container-parallax' );

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
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_common_class' ), 10, 1 );
                add_filter( 'dtportfolio_item_classes', array ( $this, 'item_misc_hover_state_class' ), 15, 1 );

                add_filter( 'dtportfolio_item_attributes', array ( $this, 'item_bg_image_attributes' ), 5, 1 );

            }

            function item_post_style_class( $classes ) {

                extract($this->settings);

                array_push( $classes, 'dtportfolio-parallax' );

                return $classes;

            }

            function item_bg_image_attributes( $attributes ) {

                extract($this->settings);

                array_push( $attributes, 'style="background-image:url('.esc_url($this->html_featured_image( 'full' )).');"' );

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

                        include DT_PORTFOLIO_DIR_PATH . 'archive/templates/parts/image-overlay.php';
                        $patp_io = new \DesignThemesPortfolioArchiveTemplatePartsImageOverlay($this->portfolio_id, $this->settings);
                        $output .= $patp_io->overlay_output();

                    $output .= '</figure>';

                $output .= '</div>';

                return $output;

            }

    }
}