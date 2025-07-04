<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesStandardFooter' ) ) {
    class DesignThemesStandardFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_footer_layouts', array( $this, 'add_standard_footer_option' ) );
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 30 );

            add_action( 'widgets_init', array( $this, 'register_footer_widgets' ) );

            $footer = dt_customizer_settings( 'site_footer' );
            $footer = apply_filters( 'savon_final_footer', $footer );
            if( $footer == 'standard-footer' ) {
                $this->frontend();
            }
        }

        function add_standard_footer_option( $options ) {
            $options['standard-footer'] = esc_html__('Standard Footer', 'designthemes-theme');
            return $options;
        }

        function default( $option ) {
            $option['standard_footer_column']     = 3;
            $option['standard_footer_background'] = array(
                'background-color'      => '#fde6e1',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );

            $option['standard_footer_title_typo']             = '';
            $option['standard_footer_title_color']            = '';
            $option['standard_footer_content_typo']           = '';
            $option['standard_footer_content_color']          = '';
            $option['standard_footer_content_a_color']        = '';
            $option['standard_footer_content_a_hover_color']  = '';

            return $option;
        }

        function register_general( $wp_customize ) {

            /**
             * Section : Standard Footer 
             */
                $wp_customize->add_section(
                    new DT_WP_Customize_Section(
                        $wp_customize,
                        'site-standard-footer-section',
                        array(
                            'title'      => esc_html__('Standard Footer', 'designthemes-theme'),
                            'dependency' => array( 'site_footer', '==', 'standard-footer' ),
                            'priority' => dt_customizer_panel_priority( 'standard-footer' )
                        )
                    )                    
                );

                /**
                 * Option : Footer Column
                 */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[standard_footer_column]', array(
                            'type'    => 'option',
                        )
                    );
                
                    $wp_customize->add_control(
                        new DT_WP_Customize_Control(
                            $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_column]', array(
                                'type'    => 'select',
                                'section' => 'site-standard-footer-section',
                                'label'   => esc_html__( 'Footer Column', 'designthemes-theme' ),
                                'choices' => array(
                                    '1' => esc_html__('One Column', 'designthemes-theme' ),
                                    '2' => esc_html__('Two Column', 'designthemes-theme' ),
                                    '3' => esc_html__('Three Column', 'designthemes-theme' ),
                                    '4' => esc_html__('Four Column', 'designthemes-theme' ),
                                    '5' => esc_html__('Five Column', 'designthemes-theme' ),
                                )
                            )
                        )
                    );
                    
                /**
                 * Option : Standard Footer Background
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_background]', array(
                        'type'    => 'option',
                    )
                );
            
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Background(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_background]', array(
                            'type'       => 'dt-background',
                            'section'    => 'site-standard-footer-section',
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'label'      => esc_html__( 'Background', 'designthemes-theme' ),
                        )
                    )		
                );
                
                /**
                 * Option :Standard Footer Title Typo
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_title_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_title_typo]', array(
                            'type'       => 'dt-typography',
                            'section'    => 'site-standard-footer-section',
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'label'      => esc_html__( 'Title Typography', 'designthemes-theme'),
                        )
                    )
                );

                /**
                 * Option : Standard Footer Title Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_title_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_title_color]', array(
                            'label'      => esc_html__( 'Color', 'designthemes-theme' ),
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'section'    => 'site-standard-footer-section',
                        )
                    )
                );


                /**
                 * Option :Standard Footer content Typo
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_content_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Typography(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_content_typo]', array(
                            'type'       => 'dt-typography',
                            'section'    => 'site-standard-footer-section',
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'label'      => esc_html__( 'Content Typography', 'designthemes-theme'),
                        )
                    )
                );

                /**
                 * Option : Standard Footer content Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_content_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_content_color]', array(
                            'label'      => esc_html__( 'Color', 'designthemes-theme' ),
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'section'    => 'site-standard-footer-section',
                        )
                    )
                );
                
                /**
                 * Option : Standard Footer content anchor Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_content_a_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_content_a_color]', array(
                            'label'      => esc_html__( 'Anchor Color', 'designthemes-theme' ),
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'section'    => 'site-standard-footer-section',
                        )
                    )
                );
                
                /**
                 * Option : Standard Footer content anchor hover Color
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[standard_footer_content_a_hover_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[standard_footer_content_a_hover_color]', array(
                            'label'      => esc_html__( 'Anchor Hover Color', 'designthemes-theme' ),
                            'dependency' => array( 'standard_footer_column', '!=', '' ),
                            'section'    => 'site-standard-footer-section',
                        )
                    )
                );                
        }

        function register_footer_widgets() {
            $count = dt_customizer_settings( 'standard_footer_column' );
            for( $i=1; $i<=$count; $i++ ) {
                register_sidebar( array(
                    'id'            => 'footer_'.$i,
                    'name'          => sprintf( esc_html__( 'Footer Widget Area - Column %s', 'designthemes-theme' ), $i ),
                    'description'   => sprintf( esc_html__( 'Widgets added here will appear in the %s column of footer area', 'designthemes-theme' ), $i ),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h3 class="widgettitle">',
                    'after_title'   => '</h3>'
                ) );
            }
        }

        function frontend() {

            add_filter( 'dt_theme_google_fonts_list', array( $this, 'fonts_list' ) );

            add_filter( 'savon_footer_get_template_part', array( $this, 'load_template' ) );
            add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );

            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'dt_theme_plugin_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );    
        }

        function fonts_list( $fonts ) {

            $title = dt_customizer_frontend_font( dt_customizer_settings('standard_footer_title_typo'), array() );
            if( count( $title ) ) {
                array_push( $fonts, $title[0] );
            }

            $content = dt_customizer_frontend_font( dt_customizer_settings('standard_footer_content_typo'), array() );           
            if( count( $content ) ) {
                array_push( $fonts, $content[0] );
            }

            return $fonts;
        }

        function load_template() {

            $count     = dt_customizer_settings( 'standard_footer_column' );
            $col_class = '';

            switch( $count ) {
                case '1':
                    $col_class = 'column dt-sc-one-column';
                break;

                case '2':
                    $col_class = 'column dt-sc-one-half';
                break;
                
                case '3':
                    $col_class = 'column dt-sc-one-third';
                break;

                case '4':
                    $col_class = 'column dt-sc-one-fourth';
                break;

                case '5':
                    $col_class = 'column dt-sc-one-fifth';
                break;                

            }

            echo dt_theme_get_template_part( 'footer/layouts/standard-footer', 'template', '', array( 'count' => $count, 'class' => $col_class ) );
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-footer', DT_THEME_DIR_URL . 'modules/footer/layouts/standard-footer/assets/css/standard-footer.css',DT_THEME_VERSION );
        }

        function base_style( $style ) {
            $bg                = dt_customizer_settings('standard_footer_background');
            $title_typo        = dt_customizer_settings('standard_footer_title_typo');
            $title_color       = dt_customizer_settings('standard_footer_title_color');
            $content_typo      = dt_customizer_settings('standard_footer_content_typo');
            $content_color     = dt_customizer_settings('standard_footer_content_color');
            $content_a_color   = dt_customizer_settings('standard_footer_content_a_color');
            $content_a_h_color = dt_customizer_settings('standard_footer_content_a_hover_color');

            $title_css  = dt_customizer_typography_settings( $title_typo );
            $title_css .= dt_customizer_color_settings( $title_color );
            if( !empty( $title_css ) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_css );
            }

            $content_css  = dt_customizer_typography_settings( $content_typo );
            $content_css .= dt_customizer_color_settings( $content_color );
            if( !empty( $content_css ) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widget, .footer-copyright', $content_css );
            }

            $content_a_css = dt_customizer_color_settings( $content_a_color );
            if( !empty( $content_a_css ) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widget a,#footer.standard-footer .widget ul li a', $content_a_css );
            }

            $content_a_h_css = dt_customizer_color_settings( $content_a_h_color );
            if( !empty( $content_a_h_css ) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widget a:hover,#footer.standard-footer .widget ul li a:hover', $content_a_h_css );
            }

            $bg_css = dt_customizer_bg_settings( $bg );
            if( !empty( $bg_css ) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer', $bg_css );
            }

            return $style;
        }

        function tablet_landscape_style( $style ) {
            $title_typo     = dt_customizer_settings('standard_footer_title_typo');
            $title_typo_css = dt_customizer_responsive_typography_settings( $title_typo, 'tablet-ls' );
            if( !empty( $title_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_typo_css );
            }

            $content_typo     = dt_customizer_settings('standard_footer_content_typo');
            $content_typo_css = dt_customizer_responsive_typography_settings( $content_typo, 'tablet-ls' );
            if( !empty( $content_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widget', $content_typo_css );
            }

            return $style;
        }

        function tablet_portrait( $style ) {
            $title_typo     = dt_customizer_settings('standard_footer_title_typo');
            $title_typo_css = dt_customizer_responsive_typography_settings( $title_typo, 'tablet' );
            if( !empty( $title_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_typo_css );
            }

            $content_typo     = dt_customizer_settings('standard_footer_content_typo');
            $content_typo_css = dt_customizer_responsive_typography_settings( $content_typo, 'tablet' );
            if( !empty( $content_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widget', $content_typo_css );
            }

            return $style;
        }

        function mobile_style( $style ) {
            $title_typo     = dt_customizer_settings('standard_footer_title_typo');
            $title_typo_css = dt_customizer_responsive_typography_settings( $title_typo, 'mobile' );
            if( !empty( $title_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_typo_css );
            }

            $content_typo     = dt_customizer_settings('standard_footer_content_typo');
            $content_typo_css = dt_customizer_responsive_typography_settings( $content_typo, 'mobile' );
            if( !empty( $content_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '#footer.standard-footer .widget', $content_typo_css );
            }

            return $style;
        }        

    }
}

DesignThemesStandardFooter::instance();