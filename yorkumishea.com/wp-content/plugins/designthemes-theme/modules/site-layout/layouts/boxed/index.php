<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSiteBoxedLayout' ) ) {
    class DesignThemesSiteBoxedLayout {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
        	$this->backend();
            $this->frontend();
        }

        function backend() {
            add_filter( 'dt_site_layouts', array( $this, 'add_boxed_layout_option' ) );
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'dt_site_layout_cutomizer_options', array( $this, 'register_site_layout' ) );        	
        }

        function frontend() {
            $enable = dt_customizer_settings( 'customize_boxed_layout' );
            if( isset( $enable ) && ( $enable == true )  ) {
	            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
	            add_filter( 'body_class', array( $this, 'body_class' ) );
	        }
        }

        function add_boxed_layout_option( $options ) {
            $options['layout-boxed'] = esc_html__('Boxed', 'designthemes-theme');
            return $options;
        }

        function default( $option ) {
            $option['customize_boxed_layout']  = false;
            $option['boxed_layout_background'] = array(
                'background-color'      => 'rgb(0,0,0)',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );

            return $option;
        }

        function register_site_layout( $wp_customize ) {

                /**
                 * Option : Customize Site Boxed Layout
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[customize_boxed_layout]', array(
                        'type'    => 'option',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[customize_boxed_layout]', array(
                            'type'        => 'dt-switch',
                            'section'     => 'site-layout-main-section',
                            'label'       => esc_html__( 'Customize Boxed Layout?', 'designthemes-theme' ),
                            'description' => esc_html__('YES! to customize boxed layout.', 'designthemes-theme'),
                            'dependency'  => array( 'site_layout', '==', 'layout-boxed' ),
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            )
                        )
                    )
                );

                /**
                 * Option : Boxed Layout BG
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[boxed_layout_background]', array(
                        'type'    => 'option',
                    )
                );
            
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Background(
                        $wp_customize, DT_CUSTOMISER_VAL . '[boxed_layout_background]', array(
                            'type'    => 'dt-background',
                            'section' => 'site-layout-main-section',
                            'label'   => esc_html__( 'Background', 'designthemes-theme' ),
                            'dependency' => array( 'site_layout|customize_boxed_layout', '==|==', 'layout-boxed|true' ),
                        )
                    )		
                );                

        }

        function base_style( $style ) {

            $css    = '';
            $bgoptions = dt_customizer_settings('boxed_layout_background');

            if( !empty( $bgoptions ) ) {
                $css = !empty( $bgoptions['background-image'] ) ? 'background-image: url("'.$bgoptions['background-image'].'");':'';
                $css .= !empty( $bgoptions['background-attachment'] ) ? 'background-attachment:'.$bgoptions['background-attachment'].';':'';
                $css .= !empty( $bgoptions['background-position'] ) ? 'background-position:'.$bgoptions['background-position'].';':'';
                $css .= !empty( $bgoptions['background-size'] ) ? 'background-size:'.$bgoptions['background-size'].';':'';
                $css .= !empty( $bgoptions['background-repeat'] ) ? 'background-repeat:'.$bgoptions['background-repeat'].';':'';
                $css .= !empty( $bgoptions['background-color'] ) ? 'background-color:'.$bgoptions['background-color'].';':'';    
            }

            if( !empty( $css ) ) {
                $style .= 'body.layout-boxed {'.$css.'}'."\n";
            }

            return $style;
        }

        function body_class( $classes ) {

        	$classes[] = 'layout-boxed';
        	return $classes;
        }
    }
}

DesignThemesSiteBoxedLayout::instance();