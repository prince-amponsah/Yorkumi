<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesCustomFont' ) ) {
    class DesignThemesCustomFont {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            $this->load_modules();
            $this->load_customizer();
            $this->load_elementor();
            $this->load_frontend();
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/custom-font/taxonomy/index.php';
        }

        function load_customizer(){
            add_filter( 'dt_customizer_custom_fonts', array( $this, 'fonts_list' ), 20 );
        }

        function load_elementor() {
			add_filter( 'elementor/fonts/groups', array( $this, 'elementor_group' ) );
			add_filter( 'elementor/fonts/additional_fonts', array( $this, 'add_elementor_fonts' ) );
        }

        function elementor_group( $font_groups ) {
            $fonts = $this->get_fonts();
            if( count( $fonts ) > 0 ) {
                $new_group[ 'dt_custom_fonts' ] = __( 'Custom Font', 'designthemes-theme' );
                $font_groups = $new_group + $font_groups;
            }

            return $font_groups;
        }

        function add_elementor_fonts( $fonts ) {
            $fonts = $this->get_fonts();
            $fonts = array_keys( $fonts );
            
            if( count( $fonts ) > 0 ) {
                foreach( $fonts as $key => $name ) {
                    $fonts[$name]   = 'dt_custom_fonts';
                }
            }

            return $fonts;
        }

        function fonts_list() {
            $fonts_list = array();

            $fonts = $this->get_fonts();
            if( count( $fonts ) > 0 ) {
                foreach( $fonts as $font => $data ) {
                    $font = array(
                        $font => array(
                            'fallback' => $font,
                            'variants' => array("", "100","200","300","400", "500", "600", "700", "800", "900", "normal","bold")
                        )
                    );

                    $fonts_list = array_merge( $fonts_list, $font );                    
                }
            }

            return $fonts_list;
        }

        function load_frontend() {
            add_filter( 'dt_theme_plugin_add_inline_style', array( $this, 'custom_font_style' ) );
        }

        function custom_font_style( $style ) {
            $fonts = $this->get_fonts();
            if( count( $fonts ) > 0 ) {
                $css = '';
                foreach( $fonts as $font => $data ) {
                    $data = array_filter( $data );
                    $css .= '@font-face { font-family:' . esc_attr( $font ) . ';';
                        $css .= 'src:';

                        $attr = array();
                        if( isset( $data['woff']) ) {
                            $attr[] = 'url(' . esc_url( $data['woff'] ) . ") format('woff')";
                        }

                        if( isset( $data['woff2']) ) {
                            $attr[] = 'url(' . esc_url( $data['woff2'] ) . ") format('woff2')";
                        }

                        if( isset( $data['ttf']) ) {
                            $attr[] = 'url(' . esc_url( $data['woff2'] ) . ") format('truetype')";
                        }

                        if( isset( $data['svg']) ) {
                            $arr[] = 'url(' . esc_url( $data['svg'] ) . '#' . esc_attr( strtolower( str_replace( ' ', '_', $font ) ) ) . ") format('svg')";
                        }

                        if( isset( $data['otf']) ) {
                            $attr[] = 'url(' . esc_url( $data['otf'] ) . ") format('opentype')";
                        }

                        $css .= join( ', ', $attr );
                        $css .= ';';
                        $css .= 'font-display: ' . esc_attr( $data['display'] ) . ';';
                    $css .= '}'."\n";
                }
                $style .= $css;
            }
            return $style;
        }

        function get_fonts() {
           
            $fonts = array();
            $terms = get_terms( 'dt_custom_fonts', array( 'hide_empty' => false ) );

            if ( ! empty( $terms ) ) {
                foreach ( $terms as $term ) {
                    $fonts[$term->name] = $this->get_font_links( $term->term_id );
                }
            }

            return $fonts;
        }

        function get_font_links( $id ) {
            $meta = get_term_meta( $id, '_dt_custom_font_options', true );

            $woff    = isset( $meta['woff'] ) ? $meta['woff'] : '';
            $woff2   = isset( $meta['woff2'] ) ? $meta['woff2'] : '';
            $ttf     = isset( $meta['ttf'] ) ? $meta['ttf'] : '';
            $svg     = isset( $meta['svg'] ) ? $meta['svg'] : '';
            $eot     = isset( $meta['eot'] ) ? $meta['eot'] : '';
            $otf     = isset( $meta['otf'] ) ? $meta['otf'] : '';
            $display = isset( $meta['display'] ) ? $meta['display'] : 'swap';

            return array(
                'woff'    => $woff,
                'woff2'   => $woff2,
                'ttf'     => $ttf,
                'svg'     => $svg,
                'eot'     => $eot,
                'otf'     => $otf,
                'display' => $display,

            );
        }

    }
}

DesignThemesCustomFont::instance();