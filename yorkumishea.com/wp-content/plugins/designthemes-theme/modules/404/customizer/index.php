<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerSite404' ) ) {
    class CustomizerSite404 {

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

            $option['enable_404message']   = '1';
            $option['notfound_style']      = 'type2';
            $option['notfound_darkbg']     = '1';
            $option['notfound_pageid']     = '';
            $option['notfound_background'] = array(
                'background-color'      => 'rgb(0,0,0)',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );
            $option['notfound_bg_style'] = '';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * 404 Page
             */
            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-404-page-section',
                    array(
                        'title'    => esc_html__('404 Page', 'designthemes-theme'),
                        'priority' => dt_customizer_panel_priority( '404' )
                    )
                )
            );

                /**
                 * Option : 404 Meaage
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[enable_404message]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[enable_404message]', array(
                                'type'        => 'dt-switch',
                                'label'       => esc_html__( 'Enable Message', 'designthemes-theme'),
                                'description' => esc_html__('YES! to enable not-found page message.', 'designthemes-theme'),
                                'section'     => 'site-404-page-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );
                    
                /**
                 * Option : Template Style
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[notfound_style]', array(
                            'default' => 'type2',
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control( 
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[notfound_style]', array(
                                'type'    => 'select',
                                'section' => 'site-404-page-section',
                                'label'   => esc_html__( 'Template Style', 'designthemes-theme' ),
                                'choices' => array(
                                    'type1'  => esc_html__('Modern', 'designthemes-theme'),
                                    'type2'  => esc_html__('Classic', 'designthemes-theme'),
                                    'type4'  => esc_html__('Diamond', 'designthemes-theme'),
                                    'type5'  => esc_html__('Shadow', 'designthemes-theme'),
                                    'type6'  => esc_html__('Diamond Alt', 'designthemes-theme'),
                                    'type7'  => esc_html__('Stack', 'designthemes-theme'),
                                    'type8'  => esc_html__('Minimal', 'designthemes-theme'),
                                ),
                                'description' => esc_html__('Choose the style of not-found template page.', 'designthemes-theme'),
                            )
                        )
                    );

                /**
                 * Option : Notfound Dark BG
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[notfound_darkbg]', array(
                            'default' => '',
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[notfound_darkbg]', array(
                                'type'        => 'dt-switch',
                                'label'       => esc_html__( '404 Dark BG', 'designthemes-theme'),
                                'description' => esc_html__('YES! to use dark bg notfound page for this site.', 'designthemes-theme'),
                                'section'     => 'site-404-page-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );
                    
                /**
                 * Option : Custom Page
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[notfound_pageid]', array(
                            'default' => '',
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[notfound_pageid]', array(
                                'type'        => 'select',
                                'section'     => 'site-404-page-section',
                                'label'       => esc_html__( 'Custom Page', 'designthemes-theme' ),
                                'choices'     => dt_pages_list(),
                                'description' => esc_html__('Choose the page for not-found content.', 'designthemes-theme'),
                            )
                        )
                    );
                    
                /**
                 * Option : 404 Background
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[notfound_background]', array(
                            'type'    => 'option',
                        )
                    );
                
                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Background(
                            $wp_customize, DT_CUSTOMISER_VAL . '[notfound_background]', array(
                                'type'    => 'dt-background',
                                'section' => 'site-404-page-section',
                                'label'   => esc_html__( 'Background', 'designthemes-theme' ),
                            )
                        )		
                    );

                /**
                 * Option : Custom Styles
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[notfound_bg_style]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[notfound_bg_style]', array(
                            'type'    	  => 'textarea',
                            'section'     => 'site-404-page-section',
                            'label'       => esc_html__( 'Custom Inline Styles', 'designthemes-theme' ),
                            'description' => esc_html__('Paste custom CSS styles for not found page.', 'designthemes-theme'),
                            'input_attrs' => array(
                                'placeholder' => esc_html__( 'color:#ff00bb; text-align:left;', 'designthemes-theme' ),
                            ),
                        )
                    )
                );                    

        }

    }
}

CustomizerSite404::instance();