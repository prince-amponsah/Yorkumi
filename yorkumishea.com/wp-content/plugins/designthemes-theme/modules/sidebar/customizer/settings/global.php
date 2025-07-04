<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesGlobalSibarSettings' ) ) {
    class DesignThemesGlobalSibarSettings {

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
            $option['global_sidebar_layout'] = 'content-full-width';
            $option['global_sidebar']        = '';
            return $option;
        }

        function register( $wp_customize ) {
            
            /**
             * Global Sidebar Panel
             */
            $wp_customize->add_section( 
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-global-sidebar-section',
                    array(
                        'title'    => esc_html__('Global Sidebar', 'designthemes-theme'),
                        'panel'    => 'site-widget-main-panel',
                        'priority' => 5
                    )
                )
            );

                /**
                 * Option: Global Sidebar Layout
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
                        $wp_customize, DT_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type'    => 'dt-radio-image',
                            'label'   => esc_html__( 'Global Sidebar Layout', 'designthemes-theme'),
                            'section' => 'site-global-sidebar-section',
                            'choices' => apply_filters( 'dt_global_sidebar_layouts', array(
                                'content-full-width' => array(
                                    'label' => esc_html__( 'Without Sidebar', 'designthemes-theme' ),
                                    'path'  =>  DT_THEME_DIR_URL . 'modules/sidebar/customizer/images/without-sidebar.png'
                                ),
                                'with-left-sidebar'  => array(
                                    'label' => esc_html__( 'With Left Sidebar', 'designthemes-theme' ),
                                    'path'  =>  DT_THEME_DIR_URL . 'modules/sidebar/customizer/images/left-sidebar.png'
                                ),
                                'with-right-sidebar' => array(
                                    'label' => esc_html__( 'With Right Sidebar', 'designthemes-theme' ),
                                    'path'  =>  DT_THEME_DIR_URL . 'modules/sidebar/customizer/images/right-sidebar.png'
                                ),
                            ) )
                        )
                    ) );
                    
                /**
                 * Option: Global Sidebar
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[global_sidebar]', array(
                        'type' => 'option',
                    )
                );

                $metabox = MetaboxSidebar::instance();
                $wp_customize->add_control( new DT_WP_Customize_Control(
                    $wp_customize, DT_CUSTOMISER_VAL . '[global_sidebar]', array(
                        'type'       => 'select',
                        'section'    => 'site-global-sidebar-section',
                        'label'      => esc_html__( 'Global Sidebar?', 'designthemes-theme' ),
                        'choices'    => $metabox->registered_widget_areas(),
                        'dependency' => array( 'global_sidebar_layout', 'any', 'with-left-sidebar,with-right-sidebar' ),
                    )
                ) );
        }
    }
}

DesignThemesGlobalSibarSettings::instance();