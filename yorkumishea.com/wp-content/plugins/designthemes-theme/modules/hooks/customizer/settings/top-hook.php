<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesTopHookSettings' ) ) {
    class DesignThemesTopHookSettings {
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

            /**
             * Load Top Hook Content in theme.
             */
            add_action( 'savon_hook_top', array( $this, 'hook_top_content' ) );
        }

        function default( $option ) {
            $option['enable_top_hook'] = 0;
            $option['top_hook']        = '';
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-top-hook-section',
                    array(
                        'title'    => esc_html__('Top Hook', 'designthemes-theme'),
                        'panel'    => 'site-hook-main-panel',
                        'priority' => 5,
                    )
                )
            );

                /**
                 * Option : Enable Top Hook
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[enable_top_hook]', array(
                        'type'    => 'option',
                        'default' => '',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[enable_top_hook]', array(
                            'type'        => 'dt-switch',
                            'section'     => 'site-top-hook-section',
                            'label'       => esc_html__( 'Enable Top Hook', 'designthemes-theme' ),
                            'description' => esc_html__('YES! to enable top hook.', 'designthemes-theme'),
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            )
                        )
                    )
                );

                /**
                 * Option : Top Hook
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[top_hook]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[top_hook]', array(
                            'type'        => 'textarea',
                            'section'     => 'site-top-hook-section',
                            'label'       => esc_html__( 'Top Hook', 'designthemes-theme' ),
                            'dependency'  => array( 'enable_top_hook', '!=', '' ),
                            'description' => esc_html__('Paste your top hook, Executes after the opening &lt;body&gt; tag.', 'designthemes-theme'),
                        )
                    )
                );

        }

        function hook_top_content() {
            $enable_top_hook = dt_customizer_settings( 'enable_top_hook' );
            $top_hook        = dt_customizer_settings( 'top_hook' );

            if( $enable_top_hook && !empty( $top_hook ) ) {
                echo do_shortcode( stripslashes( $top_hook ) );
            }
        }

    }
}

DesignThemesTopHookSettings::instance();