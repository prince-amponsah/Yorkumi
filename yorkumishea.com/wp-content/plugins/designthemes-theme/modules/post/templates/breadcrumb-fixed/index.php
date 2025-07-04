<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPostBreadcrumbFixed' ) ) {
    class DesignThemesPostBreadcrumbFixed extends DesignThemesPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtm_post_styles', array( $this, 'add_post_styles_option' ) );
            add_filter( 'savon_breadcrumb_get_template_part', array( $this, 'load_post_breadcrumb_part' ), 10, 2 );
        }

        function load_post_breadcrumb_part( $breadcrumb, $post_id ) {

            $post_style = $this->load_post_style( '', $post_id );
            if( $post_style == 'breadcrumb-fixed' && is_singular('post') ) :

                $post_cls = $bgimage = '';
                if( has_post_thumbnail( $post_id ) ):

                    echo '<div class="single-post-header-wrapper aligncenter has-post-thumbnail">';

                        echo '<div class="main-title-section-bg" style="background-image: url('.get_the_post_thumbnail_url( $post_id, 'full' ).');"></div>';
                else:
                    echo '<div class="single-post-header-wrapper aligncenter">';

                        echo '<div class="main-title-section-bg"></div>';
                endif;

                    echo '<div class="container">';
                        echo the_title( '<h1 class="single-post-title">', '</h1>', false );

                        $template_args['post_ID'] = $post_id;
                        $template_args['post_Style'] = $post_style;

                        echo '<div class="post-meta-data">';
                            echo '<div class="post-categories">';
                                savon_template_part( 'post', 'templates/'.$post_style.'/parts/category', '', $template_args );
                            echo '</div>';
                            echo '<div class="date">';
                                echo sprintf( esc_html__( '%s ago', 'designthemes-theme' ), human_time_diff( get_the_date('U'), current_time('timestamp') ) );
                            echo '</div>';
                        echo '</div>';

                    echo '</div>';

                echo '</div>';
            else:
                return $breadcrumb;
            endif;
        }

        function add_post_styles_option( $options ) {
            $options['breadcrumb-fixed'] = esc_html__('Breadcrumb Fixed', 'designthemes-theme');
            return $options;
        }
    }
}

DesignThemesPostBreadcrumbFixed::instance();