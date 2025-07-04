<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSiteBlog' ) ) {
    class CustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $option['blog-post-layout']          = 'entry-grid';
            $option['blog-post-grid-list-style'] = 'dt-sc-boxed';
            $option['blog-post-cover-style']     = 'dt-sc-boxed';
            $option['blog-post-columns']         = 'one-half-column';
            $option['blog-list-thumb']           = 'entry-left-thumb';
            $option['blog-alignment']            = 'alignnone';
            $option['enable-equal-height']       = '0';
            $option['enable-no-space']           = '0';
            $option['enable-gallery-slider']     = '0';
            $option['blog-elements-position']    = array( 'feature_image', 'category', 'title', 'date', 'read_more' );
            $option['blog-meta-position']        = array( 'author', 'date' );
            $option['enable-post-format']        = '1';
            $option['enable-excerpt-text']       = '1';
            $option['blog-excerpt-length']       = '20';
            $option['enable-video-audio']        = '0';
            $option['blog-readmore-text']        = esc_html__('Read More', 'designthemes-theme');
            $option['blog-image-hover-style']    = 'dt-sc-default';
            $option['blog-image-overlay-style']  = 'dt-sc-default';
            $option['blog-pagination']           = 'pagination-numbered';

            return $option;
        }

        function register( $wp_customize ) {
            /**
             * Panel
             */
            $wp_customize->add_panel( 
                new DT_WP_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'designthemes-theme'),
                        'priority' => dt_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section( 
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'designthemes-theme'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );

            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'dt-radio-image',
                    'label' => esc_html__( 'Post Layout', 'designthemes-theme'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'savon_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        ),
                        'entry-cover' => array(
                            'label' => esc_html__( 'Cover', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/entry-cover.png'
                        ),
                    ))
                )
            ));

            /**
             * Option : Post Grid, List Style
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'designthemes-theme' ),
                    'choices' => array(
                        'dt-sc-boxed'           => esc_html__('Boxed', 'designthemes-theme'),
                        'dt-sc-simple'          => esc_html__('Simple', 'designthemes-theme'),
                        'dt-sc-overlap'         => esc_html__('Overlap', 'designthemes-theme'),
                        'dt-sc-content-overlay' => esc_html__('Content Overlay', 'designthemes-theme'),
                        'dt-sc-simple-withbg'   => esc_html__('Simple with Background', 'designthemes-theme'),
                        'dt-sc-overlay'         => esc_html__('Overlay', 'designthemes-theme'),
                        'dt-sc-overlay-ii'      => esc_html__('Overlay II', 'designthemes-theme'),              
                        'dt-sc-overlay-iii'     => esc_html__('Overlay III', 'designthemes-theme'),             
                        'dt-sc-alternate'       => esc_html__('Alternate', 'designthemes-theme'),
                        'dt-sc-minimal'         => esc_html__('Minimal', 'designthemes-theme'),
                        'dt-sc-modern'          => esc_html__('Modern', 'designthemes-theme'),
                        'dt-sc-classic'         => esc_html__('Classic', 'designthemes-theme'),
                        'dt-sc-classic-ii'      => esc_html__('Classic II', 'designthemes-theme'),
                        'dt-sc-classic-overlay' => esc_html__('Classic Overlay', 'designthemes-theme'),
                        'dt-sc-grungy-boxed'    => esc_html__('Grungy Boxed', 'designthemes-theme'),
                        'dt-sc-title-overlap'   => esc_html__('Title Overlap', 'designthemes-theme'),
                    ),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' )
                )
            ));

            /**
             * Option : Post Cover Style
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'designthemes-theme' ),
                    'choices' => array(
                        'dt-sc-boxed'           => esc_html__('Boxed', 'designthemes-theme'),
                        'dt-sc-canvas'          => esc_html__('Canvas', 'designthemes-theme'),
                        'dt-sc-content-overlay' => esc_html__('Content Overlay', 'designthemes-theme'),
                        'dt-sc-overlay'         => esc_html__('Overlay', 'designthemes-theme'),
                        'dt-sc-overlay-ii'      => esc_html__('Overlay II', 'designthemes-theme'),
                        'dt-sc-overlay-iii'     => esc_html__('Overlay III', 'designthemes-theme'),
                        'dt-sc-trendy'          => esc_html__('Trendy', 'designthemes-theme'),
                        'dt-sc-mobilephone'     => esc_html__('Mobile Phone', 'designthemes-theme'),
                    ),
                    'dependency'   => array( 'blog-post-layout', '==', 'entry-cover' )
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'dt-radio-image',
                    'label' => esc_html__( 'Columns', 'designthemes-theme'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'savon_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'dt-radio-image',
                    'label' => esc_html__( 'List Type', 'designthemes-theme'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'savon_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'designthemes-theme' ),
                            'path' => DT_THEME_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'designthemes-theme' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'designthemes-theme'),
                      'alignleft'   => esc_html__('Align Left', 'designthemes-theme'),
                      'aligncenter' => esc_html__('Align Center', 'designthemes-theme'),
                      'alignright'  => esc_html__('Align Right', 'designthemes-theme'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Switch(
                    $wp_customize, DT_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'dt-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'designthemes-theme'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                            'off' => esc_attr__( 'No', 'designthemes-theme' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            /*$wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Switch(
                    $wp_customize, DT_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'dt-switch',
                        'label'   => esc_html__( 'Enable No Space', 'designthemes-theme'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                            'off' => esc_attr__( 'No', 'designthemes-theme' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );*/

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Switch(
                    $wp_customize, DT_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'dt-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'designthemes-theme'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                            'off' => esc_attr__( 'No', 'designthemes-theme' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new DT_WP_Customize_Control_Separator(
                    $wp_customize, DT_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'dt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control_Sortable(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'dt-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'designthemes-theme'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'savon_archive_post_elements_options', array(
                        'feature_image' => esc_html__('Feature Image', 'designthemes-theme'),
                        'title'         => esc_html__('Title', 'designthemes-theme'),
                        'content'       => esc_html__('Content', 'designthemes-theme'),
                        'read_more'     => esc_html__('Read More', 'designthemes-theme'),
                        'meta_group'    => esc_html__('Meta Group', 'designthemes-theme'),
                        'author'        => esc_html__('Author', 'designthemes-theme'),
                        'date'          => esc_html__('Date', 'designthemes-theme'),
                        'comment'       => esc_html__('Comments', 'designthemes-theme'),
                        'category'      => esc_html__('Categories', 'designthemes-theme'),
                        'tag'           => esc_html__('Tags', 'designthemes-theme'),
                        'social'        => esc_html__('Social Share', 'designthemes-theme'),
                        'likes_views'   => esc_html__('Likes & Views', 'designthemes-theme'),
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control_Sortable(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'dt-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'designthemes-theme'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'savon_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'designthemes-theme'),
                        'date'          => esc_html__('Date', 'designthemes-theme'),
                        'comment'       => esc_html__('Comments', 'designthemes-theme'),
                        'category'      => esc_html__('Categories', 'designthemes-theme'),
                        'tag'           => esc_html__('Tags', 'designthemes-theme'),
                        'social'        => esc_html__('Social Share', 'designthemes-theme'),
                        'likes_views'   => esc_html__('Likes & Views', 'designthemes-theme'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'designthemes-theme'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new DT_WP_Customize_Control_Separator(
                    $wp_customize, DT_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'dt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Post Format
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[enable-post-format]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Switch(
                    $wp_customize, DT_CUSTOMISER_VAL . '[enable-post-format]', array(
                        'type'    => 'dt-switch',
                        'label'   => esc_html__( 'Enable Post Format', 'designthemes-theme'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                            'off' => esc_attr__( 'No', 'designthemes-theme' )
                        )
                    )
                )
            );

            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Switch(
                    $wp_customize, DT_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'dt-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'designthemes-theme'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                            'off' => esc_attr__( 'No', 'designthemes-theme' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control(
                    $wp_customize, DT_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'designthemes-theme' ),
                        'description' => esc_html__('Put Excerpt Length', 'designthemes-theme'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control_Switch(
                    $wp_customize, DT_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'dt-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'designthemes-theme'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'designthemes-theme'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                            'off' => esc_attr__( 'No', 'designthemes-theme' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new DT_WP_Customize_Control(
                    $wp_customize, DT_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'designthemes-theme' ),
                        'description' => esc_html__('Put the read more text here', 'designthemes-theme'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'designthemes-theme'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'designthemes-theme' ),
                    'choices' => array(
                      'dt-sc-default'     => esc_html__('Default', 'designthemes-theme'),
                      'dt-sc-blur'        => esc_html__('Blur', 'designthemes-theme'),
                      'dt-sc-bw'          => esc_html__('Black and White', 'designthemes-theme'),
                      'dt-sc-brightness'  => esc_html__('Brightness', 'designthemes-theme'),
                      'dt-sc-fadeinleft'  => esc_html__('Fade InLeft', 'designthemes-theme'),
                      'dt-sc-fadeinright' => esc_html__('Fade InRight', 'designthemes-theme'),
                      'dt-sc-hue-rotate'  => esc_html__('Hue-Rotate', 'designthemes-theme'),
                      'dt-sc-invert'      => esc_html__('Invert', 'designthemes-theme'),
                      'dt-sc-opacity'     => esc_html__('Opacity', 'designthemes-theme'),
                      'dt-sc-rotate'      => esc_html__('Rotate', 'designthemes-theme'),
                      'dt-sc-rotate-alt'  => esc_html__('Rotate Alt', 'designthemes-theme'),
                      'dt-sc-scalein'     => esc_html__('Scale In', 'designthemes-theme'),
                      'dt-sc-scaleout'    => esc_html__('Scale Out', 'designthemes-theme'),
                      'dt-sc-sepia'       => esc_html__('Sepia', 'designthemes-theme'),
                      'dt-sc-tint'        => esc_html__('Tint', 'designthemes-theme'),
                    ),
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'designthemes-theme'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'designthemes-theme' ),
                    'choices' => array(
                      'dt-sc-default'           => esc_html__('None', 'designthemes-theme'),
                      'dt-sc-fixed'             => esc_html__('Fixed', 'designthemes-theme'),
                      'dt-sc-tb'                => esc_html__('Top to Bottom', 'designthemes-theme'),
                      'dt-sc-bt'                => esc_html__('Bottom to Top', 'designthemes-theme'),
                      'dt-sc-rl'                => esc_html__('Right to Left', 'designthemes-theme'),
                      'dt-sc-lr'                => esc_html__('Left to Right', 'designthemes-theme'),
                      'dt-sc-middle'            => esc_html__('Middle', 'designthemes-theme'),
                      'dt-sc-middle-radial'     => esc_html__('Middle Radial', 'designthemes-theme'),
                      'dt-sc-tb-gradient'       => esc_html__('Gradient - Top to Bottom', 'designthemes-theme'),
                      'dt-sc-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'designthemes-theme'),
                      'dt-sc-rl-gradient'       => esc_html__('Gradient - Right to Left', 'designthemes-theme'),
                      'dt-sc-lr-gradient'       => esc_html__('Gradient - Left to Right', 'designthemes-theme'),
                      'dt-sc-radial-gradient'   => esc_html__('Gradient - Radial', 'designthemes-theme'),
                      'dt-sc-flash'             => esc_html__('Flash', 'designthemes-theme'),
                      'dt-sc-circle'            => esc_html__('Circle', 'designthemes-theme'),
                      'dt-sc-hm-elastic'        => esc_html__('Horizontal Elastic', 'designthemes-theme'),
                      'dt-sc-vm-elastic'        => esc_html__('Vertical Elastic', 'designthemes-theme'),
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'designthemes-theme'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new DT_WP_Customize_Control(
                $wp_customize, DT_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'designthemes-theme' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'designthemes-theme'),
                      'pagination-numbered'       => esc_html__('Numbered', 'designthemes-theme'),
                      'pagination-loadmore'       => esc_html__('Load More', 'designthemes-theme'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'designthemes-theme'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'designthemes-theme')
                )
            ));

            do_action('dt_blog_cutomizer_options', $wp_customize );
        }
    }
}

CustomizerSiteBlog::instance();