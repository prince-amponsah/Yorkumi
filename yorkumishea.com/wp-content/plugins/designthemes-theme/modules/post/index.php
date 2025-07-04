<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPost' ) ) {
    class DesignThemesPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_post_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_post_layouts() {
            foreach( glob( DT_THEME_DIR_PATH. 'modules/post/templates/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/post/customizer/index.php';
            include_once DT_THEME_DIR_PATH.'modules/post/metabox/index.php';
            include_once DT_THEME_DIR_PATH.'modules/post/elementor/index.php';
        }

        function frontend() {
            add_action( 'savon_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );

            add_filter( 'savon_single_post_params', array( $this, 'register_single_post_params' ) );
            add_filter( 'savon_single_post_style', array( $this, 'load_post_style'), 10, 2 );
            add_filter( 'savon_single_post_image', array( $this, 'load_post_image' ), 10, 3 );

            add_action( 'savon_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );

            add_action( 'wp_ajax_single_post_process_like', array( $this, 'single_post_process_like' ) );
            add_action( 'wp_ajax_nopriv_single_post_process_like', array( $this, 'single_post_process_like' ) );

            $enable = dt_customizer_settings( 'enable_related_article' );
            if( !empty( $enable )  ) {
                add_action( 'savon_after_single_post_content_wrap', array( $this, 'single_post_related_article' ) );
            }
        }

        function enqueue_css_assets() {
            if( is_singular('post') ) {
                wp_enqueue_style( 'savon-dtplugin-post', DT_THEME_DIR_URL . 'modules/post/assets/css/post.css', false, DT_THEME_VERSION, 'all');

                $post_style = savon_get_single_post_style( get_the_ID() );
                wp_enqueue_style( 'savon-blog-post-'.$post_style, DT_THEME_DIR_URL . 'modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css', false, DT_THEME_VERSION, 'all');
            }
        }

        function register_single_post_params() {

            $params = array(
                'enable_title'           => dt_customizer_settings( 'enable_title' ),
                'enable_image_lightbox'  => dt_customizer_settings( 'enable_image_lightbox' ),
                'enable_disqus_comments' => dt_customizer_settings( 'enable_disqus_comments' ),
                'enable_related_article' => dt_customizer_settings( 'enable_related_article' ),
                'post_disqus_shortname'  => dt_customizer_settings( 'post_disqus_shortname' ),
                'post_dynamic_elements'  => dt_customizer_settings( 'post_dynamic_elements' ),
                'rposts_title'           => dt_customizer_settings( 'rposts_title' ),
                'rposts_column'          => dt_customizer_settings( 'rposts_column' ),
                'rposts_count'           => dt_customizer_settings( 'rposts_count' ),
                'rposts_excerpt'         => dt_customizer_settings( 'rposts_excerpt' ),
                'rposts_excerpt_length'  => dt_customizer_settings( 'rposts_excerpt_length' ),
                'rposts_carousel'        => dt_customizer_settings( 'rposts_carousel' ),
                'rposts_carousel_nav'    => dt_customizer_settings( 'rposts_carousel_nav' ),
                'post_commentlist_style' => dt_customizer_settings( 'post_commentlist_style' )
            );

            return $params;
        }

        function load_post_style( $post_style, $post_id ) {
            $post_meta = get_post_meta( $post_id, '_dt_post_settings', TRUE );
            $post_meta = is_array( $post_meta ) ? $post_meta  : array();

            $post_style = !empty( $post_meta['single_post_style'] ) ? $post_meta['single_post_style'] : $post_style;

            return $post_style;
        }

        function load_post_image( $image, $post_id, $post_meta ) {
            if( array_key_exists( 'single_post_style', $post_meta ) && $post_meta['single_post_style'] == 'split' ) :
                $entry_bg = '';
                $url = get_the_post_thumbnail_url( $post_id, 'full' );
                $entry_bg = "style=background-image:url(".$url.")";

                return '<div class="split-full-img" '.esc_attr($entry_bg).'></div>';
            else:
                return $image;
            endif;
        }

        function enqueue_js_assets() {
            if( is_singular('post') ) {
                wp_enqueue_script( 'jquery-caroufredsel', DT_THEME_DIR_URL . 'modules/post/assets/js/jquery.caroufredsel.js', array(), DT_THEME_VERSION, true );
                wp_enqueue_script( 'jquery-waypoints', DT_THEME_DIR_URL . 'modules/post/assets/js/jquery.waypoints.min.js', array(), DT_THEME_VERSION, true );
                wp_enqueue_script( 'post-likes', DT_THEME_DIR_URL . 'modules/post/assets/js/post-likes.js', array(), DT_THEME_VERSION, true );
                wp_localize_script('post-likes', 'dttheme_urls', array(
                    'ajaxurl' => esc_url( admin_url('admin-ajax.php') ),
                    'wpnonce' => wp_create_nonce('rating-nonce')
                ));
            }
        }

        function single_post_process_like() {

            $out = '';
            $postid = $_REQUEST['post_id'];
            $nonce = $_REQUEST['nonce'];
            $action = $_REQUEST['doaction'];
            $arr_pids = array();

            if ( wp_verify_nonce( $nonce, 'rating-nonce' ) && $postid > 0 ) {

                $post_meta = get_post_meta ( $postid, '_dt_post_settings', TRUE );
                $post_meta = is_array ( $post_meta ) ? $post_meta : array ();

                $var_count = ($action == 'like') ? 'like_count' : 'unlike_count';

                if( isset( $_COOKIE['arr_pids'] ) ) {

                    // article voted already...
                    if( in_array( $postid, explode(',', $_COOKIE['arr_pids']) ) ) {
                        $out = esc_html__('Already', 'designthemes-theme');
                    } else {
                        // article first vote...
                        $v = array_key_exists($var_count, $post_meta) ?  $post_meta[$var_count] : 0;
                        $v = $v + 1;
                        $post_meta[$var_count] = $v;
                        update_post_meta( $postid, '_dt_post_settings', $post_meta );

                        $out = $v;

                        $arr_pids = explode(',', $_COOKIE['arr_pids']);
                        array_push( $arr_pids, $postid);
                        setcookie( "arr_pids", implode(',', $arr_pids ), time()+1314000, "/" );
                    }
                } else {
                    // site first vote...
                    $v = array_key_exists($var_count, $post_meta) ?  $post_meta[$var_count] : 0;
                    $v = $v + 1;
                    $post_meta[$var_count] = $v;
                    update_post_meta( $postid, '_dt_post_settings', $post_meta );

                    $out = $v;

                    array_push( $arr_pids, $postid);
                    setcookie( "arr_pids", implode(',', $arr_pids ), time()+1314000, "/" );
                }
            } else {
                $out = esc_html__('Security check', 'designthemes-theme');
            }

            echo "{$out}";

            wp_die();
        }

        function single_post_related_article( $post_id ) {
            echo savon_get_template_part( 'post', 'templates/post-extra/related_article', '', array( 'post_ID' => $post_id ) );
        }
    }
}

DesignThemesPost::instance();