<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSitePortfolio' ) ) {
    class CustomizerSitePortfolio {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function default( $option ) {

            $option['portfolio_archive_layout']       = 'content-full-width';
            $option['portfolio_archive_sidebar']      = '';
            $option['portfolio_post_layout']          = 4;
            $option['portfolio_hover_style']          = '';
            $option['portfolio_cursor_hover_style']   = '';
            $option['portfolio_grid_space']           = '0';
            $option['portfolio_full_width']           = '0';
            $option['portfolio_disable_item_options'] = '1';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Portfolio Page
             */
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-portfolio-section',
                    array(
                        'title'    => esc_html__('DesignThemes - Portfolio - Archive', 'designthemes-portfolio'),
                        'priority' => 160
                    )
                )
            );

                /**
                 * Option: Archive Layout
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_archive_layout]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                    $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_archive_layout]', array(
                        'type'    => 'dt-radio-image',
                        'label'   => esc_html__( 'Sidebar Layout', 'designthemes-portfolio'),
                        'section' => 'site-portfolio-section',
                        'choices' => apply_filters( 'dt_portfolio_archive_layouts', array(
                            'content-full-width' => array(
                                'label' => esc_html__( 'Without Sidebar', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/without-sidebar.png'
                            ),
                            'with-left-sidebar'  => array(
                                'label' => esc_html__( 'With Left Sidebar', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/left-sidebar.png'
                            ),
                            'with-right-sidebar' => array(
                                'label' => esc_html__( 'With Right Sidebar', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/right-sidebar.png'
                            ),
                        ) )
                    )
                ) );

                if( class_exists('MetaboxSidebar') ) {

                    $metabox = MetaboxSidebar::instance();

                    /**
                     * Option: Archive Sidebar
                     */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[portfolio_archive_sidebar]', array(
                            'type' => 'option',
                        )
                    );


                    $wp_customize->add_control( new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_archive_sidebar]', array(
                            'type'       => 'select',
                            'section' => 'site-portfolio-section',
                            'label'      => esc_html__( 'Sidebar?', 'designthemes-portfolio' ),
                            'choices'    => $metabox->registered_widget_areas(),
                            'dependency' => array( 'portfolio_archive_layout', 'any', 'with-left-sidebar,with-right-sidebar' ),
                        )
                    ) );
                }


                /**
                 * Option: Post Layout
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_post_layout]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                    $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_post_layout]', array(
                        'type'    => 'dt-radio-image',
                        'label'   => esc_html__( 'Post Layout', 'designthemes-portfolio'),
                        'section' => 'site-portfolio-section',
                        'choices' => apply_filters( 'dt_portfolio_posts_layouts', array(
                            1 => array(
                                'label' => esc_html__( 'One Column', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/one-column.png'
                            ),
                            2  => array(
                                'label' => esc_html__( 'Two Columns', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/one-half-column.png'
                            ),
                            3 => array(
                                'label' => esc_html__( 'Three Columns', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/one-third-column.png'
                            ),
                            4 => array(
                                'label' => esc_html__( 'Four Columns', 'designthemes-portfolio' ),
                                'path'  =>  DT_PORTFOLIO_DIR_URL . 'customizer/assets/images/one-fourth-column.png'
                            ),
                        ) )
                    )
                ) );

                /**
                 * Option : Hover Style
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_hover_style]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_hover_style]', array(
                            'type'    => 'select',
                            'section' => 'site-portfolio-section',
                            'label'   => esc_html__( 'Hover Style', 'designthemes-portfolio' ),
                            'choices' => apply_filters( 'dt_portfolio_hover_styles', array(
                                ''                    => esc_html__('Default','designthemes-portfolio'),
                                'modern-title'        => esc_html__('Modern Title','designthemes-portfolio'),
                                'title-icons-overlay' => esc_html__('Title & Icons Overlay','designthemes-portfolio'),
                                'title-overlay'       => esc_html__('Title Overlay','designthemes-portfolio'),
                                'icons-only'          => esc_html__('Icons Only','designthemes-portfolio'),
                                'classic'             => esc_html__('Classic','designthemes-portfolio'),
                                'minimal-icons'       => esc_html__('Minimal Icons','designthemes-portfolio'),
                                'presentation'        => esc_html__('Presentation','designthemes-portfolio'),
                                'girly'               => esc_html__('Girly','designthemes-portfolio'),
                                'art'                 => esc_html__('Art','designthemes-portfolio'),
                                'extended'            => esc_html__('Extended','designthemes-portfolio'),
                                'boxed'               => esc_html__('Boxed','designthemes-portfolio'),
                                'centered-box'        => esc_html__('Centered Box','designthemes-portfolio'),
                                'with-gallery-thumb'  => esc_html__('With Gallery Thumb','designthemes-portfolio'),
                                'with-gallery-list'   => esc_html__('With Gallery List','designthemes-portfolio'),
                                'grayscale'           => esc_html__('Grayscale','designthemes-portfolio'),
                                'highlighter'         => esc_html__('Highlighter','designthemes-portfolio'),
                                'with-details'        => esc_html__('With Details','designthemes-portfolio'),
                                'bottom-border'       => esc_html__('Bottom Border','designthemes-portfolio'),
                                'with-intro'          => esc_html__('With Intro','designthemes-portfolio')
                            ) ),
                            'description' => esc_html__('Choose the hover style.', 'designthemes-portfolio'),
                        )
                    )
                );

                /**
                 * Option : Cursor Hover Style
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_cursor_hover_style]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_cursor_hover_style]', array(
                            'type'    => 'select',
                            'section' => 'site-portfolio-section',
                            'label'   => esc_html__( 'Cursor Hover Style', 'designthemes-portfolio' ),
                            'choices' => apply_filters( 'dt_portfolio_cursor_hover_styles', array(
                                ''                    => esc_html__('Default', 'designthemes-portfolio'),
                                'cursor-hover-style1' => esc_html__('Style 1', 'designthemes-portfolio'),
                                'cursor-hover-style2' => esc_html__('Style 2', 'designthemes-portfolio') ,
                                'cursor-hover-style3' => esc_html__('Style 3', 'designthemes-portfolio'),
                                'cursor-hover-style4' => esc_html__('Style 4', 'designthemes-portfolio'),
                                'cursor-hover-style5' => esc_html__('Style 5', 'designthemes-portfolio'),
                                'cursor-hover-style6' => esc_html__('Style 6', 'designthemes-portfolio'),
                            ) ),
                            'description' => esc_html__('Choose the cursor hover style.', 'designthemes-portfolio'),
                        )
                    )
                );

                /**
                 * Option : Grid Space
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_grid_space]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_grid_space]', array(
                            'type'        => 'dt-switch',
                            'label'       => esc_html__( 'Grid Space', 'designthemes-portfolio'),
                            'description' => esc_html__('YES! to use grid space between items.', 'designthemes-portfolio'),
                            'section'     => 'site-portfolio-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-portfolio' ),
                                'off' => esc_attr__( 'No', 'designthemes-portfolio' )
                            )
                        )
                    )
                );

                /**
                 * Option : Allow Full Width
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_full_width]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_full_width]', array(
                            'type'        => 'dt-switch',
                            'label'       => esc_html__( 'Full Width', 'designthemes-portfolio'),
                            'description' => esc_html__('YES! to allow full width display.', 'designthemes-portfolio'),
                            'section'     => 'site-portfolio-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-portfolio' ),
                                'off' => esc_attr__( 'No', 'designthemes-portfolio' )
                            )
                        )
                    )
                );


                /**
                 * Option : Disable Individual Portfolio Item Options
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[portfolio_disable_item_options]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[portfolio_disable_item_options]', array(
                            'type'        => 'dt-switch',
                            'label'       => esc_html__( 'Individual Item Option', 'designthemes-portfolio'),
                            'description' => esc_html__('YES! to disable individual item options.', 'designthemes-portfolio'),
                            'section'     => 'site-portfolio-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-portfolio' ),
                                'off' => esc_attr__( 'No', 'designthemes-portfolio' )
                            )
                        )
                    )
                );


        }
    }
}

CustomizerSitePortfolio::instance();