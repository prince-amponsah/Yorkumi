<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesBreadCrumbGeneral' ) ) {
    class DesignThemesBreadCrumbGeneral {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

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
            $option['enable_breadcrumb']           = 1;
            $option['breadcrumb_source']           = 'default';
            $option['enable_dark_bg_breadcrumb']   = 0;
            $option['breadcrumb_style']            = '';
            $option['breadcrumb_position']         = 'header-top-absolute';
            $option['change_breadcrumb_delimiter'] = 0;
            $option['breadcrumb_delimiter']        = 'dticon-angle-right';

            return $option;
        }

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-general-section',
                    array(
                        'title'    => esc_html__('General', 'designthemes-theme'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 5,
                    )
                )
            );

                /**
                 * Option : Enable Breadcrumb
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[enable_breadcrumb]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[enable_breadcrumb]', array(
                                'type'        => 'dt-switch',
                                'label'       => esc_html__( 'Enable Breadcrumb', 'designthemes-theme'),
                                'description' => esc_html__('YES! to enable Breadcrumb.', 'designthemes-theme'),
                                'section'     => 'site-breadcrumb-general-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Breadcrumb Source
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[breadcrumb_source]', array(
                        'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_source]', array(
                                'type'    => 'select',
                                'section' => 'site-breadcrumb-general-section',
                                'label'   => esc_html__( 'Breadcrumb Source?', 'designthemes-theme' ),
                                'choices' => apply_filters( 'savon_breadcrumb_source', array(
                                    'default' => esc_html__('Default','designthemes-theme'),
                                ) )
                            )
                        )
                    );

                /**
                 * Option : Enable Dark BG for Breadcrumb
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[enable_dark_bg_breadcrumb]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[enable_dark_bg_breadcrumb]', array(
                                'type'        => 'dt-switch',
                                'label'       => esc_html__( 'Enable Dark Breadcrumb', 'designthemes-theme'),
                                'description' => esc_html__('YES! to enable dark Breadcrumb.', 'designthemes-theme'),
                                'section'     => 'site-breadcrumb-general-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                $breadcrumb_layouts = apply_filters( 'dt_breadcrumb_layouts', array( 'default' => esc_html__('Default', 'designthemes-theme') ) );
                if( count( $breadcrumb_layouts ) > 1 ) {
                    /**
                     * Option : Breadcrumb Style
                     */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[breadcrumb_style]', array(
                        'type' => 'option',
                        )
                    );
                
                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_style]', array(
                                'type'    => 'select',
                                'section' => 'site-breadcrumb-general-section',
                                'label'   => esc_html__( 'Style?', 'designthemes-theme' ),
                                'choices' => $breadcrumb_layouts
                            )
                        )
                    );
                }

                /**
                 * Option : Breadcrumb Position
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[breadcrumb_position]', array(
                        'type' => 'option',
                        )
                    );
                
                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_position]', array(
                                'type'    => 'select',
                                'section' => 'site-breadcrumb-general-section',
                                'label'   => esc_html__( 'Position?', 'designthemes-theme' ),
                                'choices' => array(
                                    'header-top-absolute' => esc_html__('Behind the Header','designthemes-theme'),
                                    'header-top-relative' => esc_html__('Default','designthemes-theme'),
                                )
                            )
                        )
                    );


                /**
                 * Option : Change Breadcrumb Delimiter
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[change_breadcrumb_delimiter]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[change_breadcrumb_delimiter]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Change Breadcrumb Delimiter', 'designthemes-theme'),
                                'section' => 'site-breadcrumb-general-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                ),
                                'dependency'   => array( 'breadcrumb_source', '==', 'default' )
                            )
                        )
                    );

                /**
                 * Option : Breadcrumb Delimiter
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[breadcrumb_delimiter]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Fontawesome(
                            $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_delimiter]', array(
                                'type'       => 'dt-fontawesome',
                                'section'    => 'site-breadcrumb-general-section',
                                'label'      => esc_html__( 'Breadcrumb Delimiter', 'designthemes-theme'),
                                'dependency' => array ( 'change_breadcrumb_delimiter', '==', '1' )              
                            )
                        )
                    );                
        }
    }
}

DesignThemesBreadCrumbGeneral::instance();