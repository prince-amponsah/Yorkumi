<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesBCTemplate' ) ) {
    class DesignThemesBCTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_frontend();
        }

        function load_frontend() {
            add_filter( 'savon_breadcrumb_params', array( $this, 'register_breadcrumb_params' ) );            
            add_filter( 'savon_breadcrumb_get_template_part', array( $this, 'register_template' ), 10, 2 );

            add_filter( 'dt_theme_google_fonts_list', array( $this, 'fonts_list' ) );

            add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );

            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'dt_theme_plugin_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'dt_theme_plugin_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );

            add_filter( 'savon_header_wrapper_classes', array( $this, 'register_header_class' ) );
        }

        function register_header_class() {

            $header_cls = dt_customizer_settings('breadcrumb_position');

            if( is_singular() ) {

                $post_id = get_the_ID();
                $bc_meta       = $this->register_meta_params( $post_id );

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {
                    $header_cls = $bc_meta['position'];
                }
                return $header_cls;
            } else {
                return $header_cls;
            }
        }

        function fonts_list( $fonts ) {
            $title = dt_customizer_frontend_font( dt_customizer_settings('breadcrumb_title_typo'), array() );
            if( count( $title ) ) {
                array_push( $fonts, $title[0] );
            }

            $content = dt_customizer_frontend_font( dt_customizer_settings('breadcrumb_typo'), array() );           
            if( count( $content ) ) {
                array_push( $fonts, $content[0] );
            }

            return $fonts;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-breadcrumb', DT_THEME_DIR_URL . 'modules/breadcrumb/assets/css/dt-breadcrumb.css', DT_THEME_VERSION );
        }

        function base_style( $style ) {
            $bg                = dt_customizer_settings('breadcrumb_background');
            $enable_overlay    = dt_customizer_settings('breadcrumb_overlay_bg_color');
            $title_typo        = dt_customizer_settings('breadcrumb_title_typo');
            $title_color       = dt_customizer_settings('breadcrumb_title_color');
            $content_typo      = dt_customizer_settings('breadcrumb_typo');
            $content_color     = dt_customizer_settings('breadcrumb_text_color');
            $content_a_color   = dt_customizer_settings('breadcrumb_link_color');
            $content_a_h_color = dt_customizer_settings('breadcrumb_link_hover_color');

            $title_css  = dt_customizer_typography_settings( $title_typo );
            $title_css .= dt_customizer_color_settings( $title_color );
            if( !empty( $title_css ) ) {
                $style .= dt_customizer_dynamic_style( '.main-title-section h1', $title_css );
            }

            $content_css  = dt_customizer_typography_settings( $content_typo );
            $content_css .= dt_customizer_color_settings( $content_color );
            if( !empty( $content_css ) ) {
                $style .= dt_customizer_dynamic_style( '.breadcrumb', $content_css );
            }

            $content_a_css = dt_customizer_color_settings( $content_a_color );
            if( !empty( $content_a_css ) ) {
                $style .= dt_customizer_dynamic_style( '.breadcrumb a', $content_a_css );
            }

            $content_a_h_css = dt_customizer_color_settings( $content_a_h_color );
            if( !empty( $content_a_h_css ) ) {
                $style .= dt_customizer_dynamic_style( '.breadcrumb a:hover', $content_a_h_css );
            }

            $bg_css = dt_customizer_bg_settings( $bg );

            if( !empty( $bg_css ) && empty( $enable_overlay ) ) {

                $style .= dt_customizer_dynamic_style( '.main-title-section-wrapper > .main-title-section-bg', $bg_css );

            } elseif( !empty( $enable_overlay ) ) {

                $overlay_color = array_key_exists( 'background-color', $bg ) ? $bg['background-color'] : '';
                $bg['background-color'] = '';

                $bg_css = dt_customizer_bg_settings( $bg );

                if( !empty( $bg_css ) ) {
                    $style .= dt_customizer_dynamic_style( '.main-title-section-wrapper > .main-title-section-bg', $bg_css );
                }

                if( !empty( $overlay_color ) ) {
                    $bg_css = dt_customizer_bg_settings( array( 'background-color' => $overlay_color ) );
                    $style .= dt_customizer_dynamic_style( '.main-title-section-wrapper > .main-title-section-bg:after', $bg_css );
                }
            }

            return $style;
        }

        function tablet_landscape_style( $style ) {
            $title_typo     = dt_customizer_settings('breadcrumb_title_typo');
            $title_typo_css = dt_customizer_responsive_typography_settings( $title_typo, 'tablet-ls' );
            if( !empty( $title_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '.main-title-section h1', $title_typo_css );
            }

            $content_typo     = dt_customizer_settings('breadcrumb_typo');
            $content_typo_css = dt_customizer_responsive_typography_settings( $content_typo, 'tablet-ls' );
            if( !empty( $content_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '.breadcrumb', $content_typo_css );
            }

            return $style;
        }

        function tablet_portrait( $style ) {
            $title_typo     = dt_customizer_settings('breadcrumb_title_typo');
            $title_typo_css = dt_customizer_responsive_typography_settings( $title_typo, 'tablet' );
            if( !empty( $title_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '.main-title-section h1', $title_typo_css );
            }

            $content_typo     = dt_customizer_settings('breadcrumb_typo');
            $content_typo_css = dt_customizer_responsive_typography_settings( $content_typo, 'tablet' );
            if( !empty( $content_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '.breadcrumb', $content_typo_css );
            }

            return $style;
        }

        function mobile_style( $style ) {
            $title_typo     = dt_customizer_settings('breadcrumb_title_typo');
            $title_typo_css = dt_customizer_responsive_typography_settings( $title_typo, 'mobile' );
            if( !empty( $title_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '.main-title-section h1', $title_typo_css );
            }

            $content_typo     = dt_customizer_settings('breadcrumb_typo');
            $content_typo_css = dt_customizer_responsive_typography_settings( $content_typo, 'mobile' );
            if( !empty( $content_typo_css) ) {
                $style .= dt_customizer_dynamic_style( '.breadcrumb', $content_typo_css );
            }

            return $style;
        }

        function base_meta_style( $meta ) {

            $meta = array_key_exists( 'background', $meta ) ? $meta['background'] : array();

            $style = '';
            $bg = array();

            $bg['background-image']      = array_key_exists( 'image' , $meta ) ? $meta['image'] : '';
            $bg['background-repeat']     = array_key_exists( 'repeat' , $meta ) ? $meta['repeat'] : '';
            $bg['background-position']   = array_key_exists( 'position' , $meta ) ? $meta['position'] : '';
            $bg['background-attachment'] = array_key_exists( 'attachment' , $meta ) ? $meta['attachment'] : '';
            $bg['background-size']       = array_key_exists( 'size' , $meta ) ? $meta['size'] : '';
            $bg['background-color']      = array_key_exists( 'color' , $meta ) ? $meta['color'] : '';

            $bg_css         = dt_customizer_bg_settings( $bg );
            $enable_overlay = dt_customizer_settings('breadcrumb_overlay_bg_color');

            if( !empty( $bg_css ) && empty( $enable_overlay ) ) {

                $style .= dt_customizer_dynamic_style( '.main-title-section-wrapper > .main-title-section-bg', $bg_css );

            } elseif( !empty( $enable_overlay ) ) {

                $overlay_color = array_key_exists( 'background-color', $bg ) ? $bg['background-color'] : '';
                $bg['background-color'] = '';

                $bg_css = dt_customizer_bg_settings( $bg );

                if( !empty( $bg_css ) ) {
                    $style .= dt_customizer_dynamic_style( '.main-title-section-wrapper > .main-title-section-bg', $bg_css );
                }

                if( !empty( $overlay_color ) ) {
                    $bg_css = dt_customizer_bg_settings( array( 'background-color' => $overlay_color ) );
                    $style .= dt_customizer_dynamic_style( '.main-title-section-wrapper > .main-title-section-bg:after', $bg_css );
                }
            }

            if( !empty( $style ) ){
                wp_register_style( 'savon-bc', '', array (), DT_THEME_VERSION, 'all' );
                wp_enqueue_style( 'savon-bc' );
                wp_add_inline_style( 'savon-bc', $style );
            }
        }

        function register_breadcrumb_params() {

            $enable_delimiter = dt_customizer_settings( 'change_breadcrumb_delimiter' );
            $delimiter        = dt_customizer_settings( 'breadcrumb_delimiter' );

            $delimiter = ( $enable_delimiter ) ? '<span class="'.$delimiter.'"></span>' : '<span class="breadcrumb-default-delimiter"></span>';

            $wrapper_class    = array();
            $enable_darkbg    = dt_customizer_settings( 'enable_dark_bg_breadcrumb' );
            $breadcrumb_style = dt_customizer_settings( 'breadcrumb_style' );
            $enable_parallax  = dt_customizer_settings( 'breadcrumb_parallax' );

            if( $enable_darkbg ) {
                $wrapper_class[] = 'dark-bg-breadcrumb';
            }

            $wrapper_class[] = $breadcrumb_style;

            if( $enable_parallax ) {
                $wrapper_class[] = 'dt-parallax-bg';
            }

            $params = array(
                'home'             => esc_html__( 'Home', 'designthemes-theme' ),
                'home_link'        => home_url('/'),
                'delimiter'        => $delimiter,
                'wrapper_classes'  => implode( ' ', $wrapper_class )
            );

            return $params;
        }

        function register_meta_params( $post_id ) {

            $post_meta = get_post_meta( $post_id, '_dt_breadcrumb_settings', true );
            $post_meta = is_array( $post_meta ) ? $post_meta : array();

            return $post_meta;
        }

        function register_template( $args, $post_id ) {

            $style         = '';
            $enable_bc     = dt_customizer_settings( 'enable_breadcrumb' );

            if( ! $enable_bc ) {
                return;
            }

            $template_args = $this->register_breadcrumb_params();
            $bc_meta       = $this->register_meta_params( $post_id );

            if( empty($bc_meta) || ( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] != 'disable' ) ) {

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {

                    $wrapper_class    = array();
                    $enable_darkbg    = array_key_exists( 'enable_dark_bg', $bc_meta ) ? $bc_meta['enable_dark_bg'] : '';
                    $breadcrumb_style = dt_customizer_settings( 'breadcrumb_style' );
                    $enable_parallax  = dt_customizer_settings( 'breadcrumb_parallax' );

                    if( $enable_darkbg ) {
                        $wrapper_class[] = 'dark-bg-breadcrumb';
                    }

                    $wrapper_class[] = $breadcrumb_style;

                    if( $enable_parallax ) {
                        $wrapper_class[] = 'dt-parallax-bg';
                    }

                    $template_args['wrapper_classes'] = implode( ' ', $wrapper_class );
                    $this->base_meta_style( $bc_meta );
                }

                $bc_source = dt_customizer_settings( 'breadcrumb_source' );

                switch( $bc_source ):

                    case 'default':
                    default:
                        savon_template_part( 'breadcrumb', 'templates/default/title-content', '', $template_args );
                    break;

                endswitch;
            }
        }
    }
}

DesignThemesBCTemplate::instance();