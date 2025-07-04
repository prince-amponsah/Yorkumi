<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPostBreadcrumbParallax' ) ) {
    class DesignThemesPostBreadcrumbParallax extends DesignThemesPost {

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
            add_action( 'savon_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );
        }

        function load_post_breadcrumb_part( $breadcrumb, $post_id ) {

            $post_style = $this->load_post_style( '', $post_id );
            if( $post_style == 'breadcrumb-parallax' && is_singular('post') ) :

                $post_cls = $bgimage = '';
                if( has_post_thumbnail( $post_id ) ):

                    echo '<div class="single-post-header-wrapper dt-parallax-bg aligncenter has-post-thumbnail">';

                        echo '<div class="main-title-section-bg" style="background-image: url('.get_the_post_thumbnail_url( $post_id, 'full' ).');"></div>';
                else:
                    echo '<div class="single-post-header-wrapper aligncenter">';

                        echo '<div class="main-title-section-bg"></div>';
                endif;

                    echo '<div class="container">';

                        $template_args['post_ID'] = $post_id;
                        $template_args['post_Style'] = $post_style;

                        echo '<div class="post-categories">';
                            savon_template_part( 'post', 'templates/'.$post_style.'/parts/category', '', $template_args );
                        echo '</div>';

                        echo the_title( '<h1 class="single-post-title">', '</h1>', false );

                        echo '<div class="post-meta">';
                            echo '<div class="post-author">';
                                $auth = get_post( $post_id );
                                $authid = $auth->post_author;
                                echo '<span>'.esc_html__('By ', 'designthemes-theme').'</span>';
                                echo '<a href="'.get_author_posts_url( $authid ).'" title="'.esc_attr__('View all posts by ', 'designthemes-theme').get_the_author_meta('display_name', $authid).'">'.get_the_author_meta('display_name', $authid).'</a>';
                            echo '</div>';

                            echo '<div class="post-date">';
                                savon_template_part( 'post', 'templates/'.$post_style.'/parts/date', '', $template_args );
                            echo '</div>';

                            $template_args = array_merge( $template_args, savon_single_post_params() );
                            echo '<div class="post-comments">';
                                savon_template_part( 'post', 'templates/'.$post_style.'/parts/comment', '', $template_args );
                            echo '</div>';
                        echo '</div>';

                    echo '</div>';

                echo '</div>';
            else:
                return $breadcrumb;
            endif;
        }

        function enqueue_js_assets() {
            if( is_singular('post') ) {
                wp_enqueue_script( 'jquery-inview', DT_THEME_DIR_URL . 'modules/post/templates/breadcrumb-parallax/assets/js/jquery.inview.js', array(), DT_THEME_VERSION, true );
                wp_enqueue_script( 'jquery-parallax', DT_THEME_DIR_URL . 'modules/post/templates/breadcrumb-parallax/assets/js/jquery.parallax.js', array(), DT_THEME_VERSION, true );
                wp_enqueue_script( 'post-parallax', DT_THEME_DIR_URL . 'modules/post/templates/breadcrumb-parallax/assets/js/post-parallax.js', array(), DT_THEME_VERSION, true );
            }
        }

        function add_post_styles_option( $options ) {
            $options['breadcrumb-parallax'] = esc_html__('Breadcrumb Parallax', 'designthemes-theme');
            return $options;
        }
    }
}

DesignThemesPostBreadcrumbParallax::instance();