<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesBreadCrumbColor' ) ) {
    class DesignThemesBreadCrumbColor {

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
            $option['breadcrumb_title_color']      = '';
            $option['breadcrumb_text_color']       = '';
            $option['breadcrumb_link_color']       = '';
            $option['breadcrumb_link_hover_color'] = '';
            $option['breadcrumb_background']       = array(
                'background-color'      => 'rgba(var(--DTPrimary_RGB), 0.05)',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );

            return $option;
        }        

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-color-section',
                    array(
                        'title'    => esc_html__('Colors & Background', 'designthemes-theme'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 10,
                    )
                )
            );

                /**
                 * Option : Breadcrumb Title Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_title_color]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_title_color]', array(
                            'label'   => esc_html__( 'Title Color', 'designthemes-theme' ),
                            'section' => 'site-breadcrumb-color-section',
                        )
                    )
                );

                /**
                 * Option : Breadcrumb Text Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_text_color]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_text_color]', array(
                            'label'   => esc_html__( 'Text Color', 'designthemes-theme' ),
                            'section' => 'site-breadcrumb-color-section',
                        )
                    )
                );

                /**
                 * Option : Breadcrumb Link Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_link_color]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_link_color]', array(
                            'label'   => esc_html__( 'Link Color', 'designthemes-theme' ),
                            'section' => 'site-breadcrumb-color-section',
                        )
                    )
                );

                /**
                 * Option : Breadcrumb Link Hover Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_link_hover_color]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_link_hover_color]', array(
                            'label'   => esc_html__( 'Link Color', 'designthemes-theme' ),
                            'section' => 'site-breadcrumb-color-section',
                        )
                    )
                );

                /**
                 * Option : Breadcrumb Background
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_background]', array(
                        'type'    => 'option',
                    )
                );
            
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Background(
                        $wp_customize, DT_CUSTOMISER_VAL . '[breadcrumb_background]', array(
                            'type'    => 'dt-background',
                            'section' => 'site-breadcrumb-color-section',
                            'label'   => esc_html__( 'Background', 'designthemes-theme' ),
                        )
                    )
                );

                /**
                 * Option : Overlay Background Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_overlay_bg_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[breadcrumb_overlay_bg_color]', array(
                        'type'    => 'checkbox',
                        'section' => 'site-breadcrumb-color-section',
                        'label'   => esc_html__( 'Overlay Background Color', 'designthemes-theme' ),
                    )
                );

                /**
                 * Option : Parallax Breadcrumb Background
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[breadcrumb_parallax]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    DT_CUSTOMISER_VAL . '[breadcrumb_parallax]', array(
                        'type'    => 'checkbox',
                        'section' => 'site-breadcrumb-color-section',
                        'label'   => esc_html__( 'Parallax Background', 'designthemes-theme' ),
                    )
                );                

        }
    }
}

DesignThemesBreadCrumbColor::instance();