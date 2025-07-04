<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioMediaTop' ) ) {
    class DesignThemesPortfolioMediaTop {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtm_portfolio_styles', array( $this, 'add_meta_option' ) );
            add_filter( '_dt_portfolio_layout_settings', array( $this, 'additional_option' ) );
        }

        function add_meta_option( $options ) {
            $options['media-on-top'] = esc_html__('Media On Top', 'designthemes-theme');
            return $options;
        }

        function additional_option( $options ) {
            $options[] = array(
                array(
                    'id'         => 'media_on_top_type',
                    'type'       => 'select',
                    'title'      => esc_html__('Media Type', 'designthemes-theme'),
                    'options'    => array(
                        'image'  => esc_html__('Image', 'designthemes-theme' ),
                        'video' => esc_html__('Video', 'designthemes-theme' )
                    ),
                    'default'    => 'image',
                    'attributes' => array( 'style'  => 'width: 75%;' ),
                    'dependency' => array( 'layout', '==', 'media-on-top' )
                ),
            );

            return $options;
        }
    }
}

DesignThemesPortfolioMediaTop::instance();

/**
 * For Front end
 */
class DesignThemesPortfolioMediaOnTopFront {

    public $post_id;

    function __construct( $post_id ) {
        $this->post_id = $post_id;

        add_action( 'savon_header', array( $this, 'header' ) );
        add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
        add_action( 'savon_after_enqueue_js', array( $this, 'enqueue_js' ) );
    }

    function header() {

        $output   = '';

        $pl_settings = get_post_meta( $this->post_id, '_dt_portfolio_layout_settings', true );
        $pl_settings = is_array( $pl_settings ) ? $pl_settings : array();

        $settings = get_post_meta( $this->post_id, '_dt_feature_settings', true );
        $settings = is_array( $settings ) ? array_filter( $settings ) : array();

        if( isset( $pl_settings['media_on_top_type'] ) && $pl_settings['media_on_top_type'] == 'video' ) {
            $video_type = $settings['video_type'];
            if( $video_type == 'oembed' && !empty( $settings['oembed_url'] ) ) {
                $output .= '<section class="dtportfolio-single-mediaontop-section-holder">';
                    $output .= '<div class="dtportfolio-single-mediaontop-section">';
                        $output .= wp_oembed_get($settings['oembed_url']);
                    $output .= '</div>';
                $output .= '</section>';
                $output .= '<div class="dtportfolio-fullwidth-wrapper-fix"></div>';
            }
            if( $video_type == 'self' && !empty( $settings['self_url'] ) ) {
                $output .= '<section class="dtportfolio-single-mediaontop-section-holder">';
                    $output .= '<div class="dtportfolio-single-mediaontop-section">';
                        $output .= wp_video_shortcode( array('src' => $settings['self_url'], 'autoplay' => 'autoplay') );
                    $output .= '</div>';
                $output .= '</section>';
                $output .= '<div class="dtportfolio-fullwidth-wrapper-fix"></div>';
            }
        } else {
            if( isset( $settings['image'] ) && !empty( $settings['image'] ) ) {
                $attachment = wp_get_attachment_image_src( $settings['image'], 'full' );
                if( $attachment ) {
                    $output .= '<section class="dtportfolio-single-mediaontop-section-holder">';
                        $output .= '<div class="dtportfolio-single-mediaontop-section">';
                            $output .= '<div class="dtportfolio-single-mediaontop-item" style="background-image:url('.esc_url( $attachment[0] ).');"></div>';
                        $output .= '</div>';
                    $output .= '</section>';
                    $output .= '<div class="dtportfolio-fullwidth-wrapper-fix"></div>';
                }
            }
        }

        echo $output;

    }

    function enqueue_css() {
        wp_enqueue_style( 'dtportfolio-media-on-top', DT_PORTFOLIO_DIR_URL . 'single/templates/media-on-top/assets/css/style.css', false, DT_PORTFOLIO_VERSION, 'all');
    }

    function enqueue_js() {
        wp_enqueue_script ( 'dtportfolio-media-on-top', DT_PORTFOLIO_DIR_URL . 'single/templates/media-on-top/assets/js/scripts.js', array ('jquery'), false, true );
    }
}