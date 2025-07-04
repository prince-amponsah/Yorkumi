<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxPortfolioFeature' ) ) {
    class MetaboxPortfolioFeature {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtm_layout_posts', array( $this, 'enable_theme_layouts' ), 20, 1 );
            add_filter( 'dtm_breadcrumb_posts', array( $this, 'enable_theme_breadcrumb' ), 20, 1 );

            add_filter( 'cs_metabox_options', array( $this, 'layout_settings' ) );

            add_filter( 'cs_metabox_options', array( $this, 'feature_settings' ) );
            add_filter( 'cs_metabox_options', array( $this, 'listing_settings' ) );
            add_filter( 'cs_metabox_options', array( $this, 'additional_option_settings' ) );
        }

        function enable_theme_layouts( $post_types ) {
            array_push( $post_types, 'dt_portfolios' );
            return $post_types;
        }

        function enable_theme_breadcrumb( $post_types ) {
            array_push( $post_types, 'dt_portfolios' );
            return $post_types;
        }

        function layout_settings( $options ) {

            $fields = array(
                array(
                    'id'         => 'layout',
                    'type'       => 'select',
                    'title'      => esc_html__('Post Style', 'designthemes-theme'),
                    'options'    => apply_filters( 'dtm_portfolio_styles', array() ),
                    'default'    => 'custom-template',
                    'attributes' => array(
                        'style'  => 'width: 75%;'
                    ),
                )
            );

            $extra_fields = apply_filters( '_dt_portfolio_layout_settings', array() );
            if( count($extra_fields) ) {
                foreach( $extra_fields as $extra ) {
                    $fields = array_merge( $fields, $extra );
                }
            }

            $options[] = array(
                'id'        => '_dt_portfolio_layout_settings',
                'title'     => esc_html('Post Layout Settings', 'designthemes-portfolio'),
                'post_type' => 'dt_portfolios',
                'context'   => 'side',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'single_layout_section',
                        'fields' => $fields
                    )
                )
            );

            return $options;
        }

        function feature_settings( $options ) {

            $options[] = array(
                'id'        => '_dt_feature_settings',
                'title'     => esc_html('Feature Settings', 'designthemes-portfolio'),
                'post_type' => 'dt_portfolios',
                'context'   => 'side',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'feature_section',
                        'fields' => array(
                            array(
                                'id'         => 'image',
                                'type'       => 'image',
                                'title'      => esc_html__('Featured Image', 'designthemes-theme'),
                                'add_title' => esc_html__('Set Featured Image', 'designthemes-theme')
                            ),
                            array(
                                'id'          => 'gallery_items',
                                'type'        => 'gallery',
                                'show_id'     => true,
                                'title'       => esc_html__('Gallery Items', 'designthemes-portfolio' ),
                                'add_title'   => esc_html__('Add', 'designthemes-portfolio' ),
                                'edit_title'  => esc_html__('Edit', 'designthemes-portfolio' ),
                                'clear_title' => esc_html__('Remove', 'designthemes-portfolio' )
                            ),
                            array(
                                'id'         => 'video_type',
                                'type'       => 'select',
                                'title'      => esc_html__('Video Type?', 'designthemes-theme'),
                                'options'    => array(
                                    'oembed' => esc_html__('Oembed','designthemes-theme'),
                                    'self'   => esc_html__('Self Hosted','designthemes-theme'),
                                ),
                                'default'    => 'oembed',
                                'attributes' => array( 'data-depend-id' => 'video-type' ),
                            ),
                            array(
                                'id'         => 'oembed_url',
                                'type'       => 'text',
                                'title'      => esc_html__('Video Link', 'designthemes-theme'),
                                'dependency' => array( 'video-type', '==', 'oembed' ),
                            ),
                            array(
                                'id'         => 'self_url',
                                'type'       => 'upload',
                                'title'      => esc_html__('Video Link', 'designthemes-theme'),
                                'settings'   => array(
                                    'upload_type' => 'video/x-ms-asf,video/x-ms-wmv,video/x-ms-wmx,video/x-ms-wm,video/avi,video/divx,video/x-flv,video/quicktime,video/mpeg,video/mp4,video/ogg,video/webm,video/x-matroska,video/3gpp,video/3gpp2'
                                ),
                                'dependency' => array( 'video-type', '==', 'self' ),
                            ),
                        )
                    )
                )
            );

            return $options;
        }

        function listing_settings( $options ) {

            $dtportfolio_animationtypes = array('' => 'none', 'flash' => 'flash', 'shake' => 'shake', 'bounce' => 'bounce', 'tada' => 'tada', 'swing' => 'swing', 'wobble' => 'wobble', 'pulse' => 'pulse', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipOutX' => 'flipOutX', 'flipInY' => 'flipInY', 'flipOutY' => 'flipOutY', 'fadeIn' => 'fadeIn', 'fadeInUp' => 'fadeInUp', 'fadeInDown' => 'fadeInDown', 'fadeInLeft' => 'fadeInLeft', 'fadeInRight' => 'fadeInRight', 'fadeInUpBig' => 'fadeInUpBig', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeOut' => 'fadeOut', 'fadeOutUp' => 'fadeOutUp','fadeOutDown' => 'fadeOutDown', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutRight' => 'fadeOutRight', 'fadeOutUpBig' => 'fadeOutUpBig', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeftBig' => 'fadeOutLeftBig','fadeOutRightBig' => 'fadeOutRightBig', 'bounceIn' => 'bounceIn', 'bounceInUp' => 'bounceInUp', 'bounceInDown' => 'bounceInDown', 'bounceInLeft' => 'bounceInLeft', 'bounceInRight' => 'bounceInRight', 'bounceOut' => 'bounceOut', 'bounceOutUp' => 'bounceOutUp', 'bounceOutDown' => 'bounceOutDown', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'rotateIn' => 'rotateIn', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateInDownRight' => 'rotateInDownRight', 'rotateOut' => 'rotateOut', 'rotateOutUpLeft' => 'rotateOutUpLeft','rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'rotateOutDownRight' => 'rotateOutDownRight', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut', 'lightSpeedIn' => 'lightSpeedIn', 'lightSpeedOut' => 'lightSpeedOut', 'slideDown' => 'slideDown', 'slideUp' => 'slideUp', 'slideLeft' => 'slideLeft', 'slideRight' => 'slideRight', 'slideExpandUp' => 'slideExpandUp', 'expandUp' => 'expandUp', 'expandOpen' => 'expandOpen', 'bigEntrance' => 'bigEntrance', 'hatch' => 'hatch', 'floating' => 'floating', 'tossing' => 'tossing', 'pullUp' => 'pullUp', 'pullDown' => 'pullDown', 'stretchLeft' => 'stretchLeft', 'stretchRight' => 'stretchRight', 'zoomIn' => 'zoomIn');

            $options[] = array(
                'id'        => '_dt_listing_settings',
                'title'     => esc_html('Listing Settings', 'designthemes-portfolio'),
                'post_type' => 'dt_portfolios',
                'context'   => 'side',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'listing_section',
                        'fields' => array(
                            array(
                                'id'         => 'masonry_size',
                                'type'       => 'select',
                                'title'      => esc_html__('Masonry Size', 'designthemes-theme'),
                                'options'    => array(
                                    ''                         => esc_html__('None', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-1' => esc_html__('Grid Size 1', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-2' => esc_html__('Grid Size 2', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-3' => esc_html__('Grid Size 3', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-4' => esc_html__('Grid Size 4', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-5' => esc_html__('Grid Size 5', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-6' => esc_html__('Grid Size 6', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-7' => esc_html__('Grid Size 7', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-8' => esc_html__('Grid Size 8', 'dtportfolio'),
                                    'dtportfolio-grid-sizer-9' => esc_html__('Grid Size 9', 'dtportfolio')
                                ),
                                'default'    => 'dtportfolio-grid-sizer-3',
                            ),
                            array (
                                'id'    => 'hover_background_color',
                                'type'  => 'color_picker',
                                'title' => esc_html__('Hover Background Color', 'dtportfolio'),
                            ),
                            array (
                                'id'      => 'hover_content_color',
                                'type'    => 'select',
                                'title'   => esc_html__('Hover Content Color', 'dtportfolio'),
                                'options' => array (
                                    ''                         => 'Default',
                                    'hover-content-color-dark' => 'Hover Content Color Dark',
                                    'hover-content-color-light' => 'Hover Content Color Light'
                                )
                            ),
                            array (
                                'id'    => 'hover_gradient_color',
                                'type'  => 'color_picker',
                                'title' => esc_html__('Gradient Second Color', 'dtportfolio'),
                            ),
                            array (
                                'id'    => 'hover_gradient_direction',
                                'type'  => 'select',
                                'title' => esc_html__('Gradient Direction', 'dtportfolio'),
                                'options'=> array (
                                    'lefttoright' => 'Left to Right',
                                    'toptobottom' => 'Top to Bottom',
                                    'diagonal'    => 'Diagonal'
                                )
                            ),
                            array (
                                'id'    => 'hover_state',
                                'type'  => 'switcher',
                                'title' => esc_html__('Hover State', 'dtportfolio'),
                            ),
                            array (
                                'id'    => 'animation_effect',
                                'type'  => 'select',
                                'title' => esc_html__('Animation Effect', 'dtportfolio'),
                                'options'=> $dtportfolio_animationtypes
                            ),
                            array (
                                'id'    => 'animation_delay',
                                'type'  => 'number',
                                'title' => esc_html__('Animation Delay', 'dtportfolio'),
                            ),
                        )
                    )
                )
            );

            return $options;
        }

        function additional_option_settings( $options ) {
            $custom_fields = apply_filters( 'dtm_metabox_custom_fields', array() );
            $options[]     = array(
                'id'        => '_dt_custom_fields_settings',
                'title'     => esc_html('Additional Fields', 'designthemes-portfolio'),
                'post_type' => 'dt_portfolios',
                'context'   => 'normal',
                'priority'  => 'default',
                'sections'  => array(
                    array(
                        'name'   => 'custom_fields_section',
                        'fields' => $custom_fields
                    )
                )
            );

            return $options;
        }
    }
}

MetaboxPortfolioFeature::instance();