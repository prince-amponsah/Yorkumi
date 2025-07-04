<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSideNav' ) ) {
    class DesignThemesSideNav {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->load_module();
            $this->frontend();
        }

        function load_module() {
            include_once DT_THEME_DIR_PATH.'modules/side-nav/metabox/index.php';
            add_filter( 'theme_page_templates', array( $this, 'add_sidenav_template' ) );
            #add_filter( 'template_include', array( $this, 'sidenav_template' ) );
        }

        function add_sidenav_template( $templates ) {
            $templates = array_merge( $templates, array( 'tpl-side-nav.php' => esc_html__('Side Navigation', 'designthemes-theme' ) ) );
            return $templates;
        }

        function sidenav_template( $template ) {
            if( is_singular('page') ) {
                $page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
                if( $page_template == 'tpl-side-nav.php' ) {
                    return DT_THEME_DIR_PATH . 'modules/side-nav/template/tpl-side-nav.php';
                }
            }
            return $template;
        }

        function frontend() {
            add_filter( 'savon_primary_classes', array( $this, 'primary_classes' ), 20 );
            add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );
            add_action( 'savon_before_single_page_content_wrap', array( $this, 'before_content_wrap' ) );
            add_action( 'savon_after_single_page_content_wrap', array( $this, 'after_content_wrap' ), 9999999 );
        }

        function primary_classes( $classes ) {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                $settings = get_post_meta( get_the_ID(), '_dt_sidenav_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['style'] ) ) {
                    $classes .= ' '.$settings['style'];
                }

                if( isset( $settings['align'] ) ) {
                    $classes .= " sidenav-alignright";
                }

                if( isset( $settings['sticky'] ) ) {
                    $classes .= " sidenav-sticky";
                }                
            }

            return $classes;
        }

        function enqueue_assets() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                wp_enqueue_style( 'sidenav', DT_THEME_DIR_URL . 'modules/side-nav/assets/css/dt-sidenav.css', false, DT_THEME_VERSION, 'all' );
                wp_enqueue_script( 'theia-sticky-sidebar', DT_THEME_DIR_URL . 'assets/js/theia-sticky-sidebar.min.js', array('jquery'), DT_THEME_VERSION, true );
                wp_enqueue_script( 'sidenav-sticky', DT_THEME_DIR_URL . 'modules/side-nav/assets/js/side-nav.js', array('theia-sticky-sidebar'), DT_THEME_VERSION, true );
            }
        }

        function before_content_wrap() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                $id       = get_the_ID();
                $settings = get_post_meta( $id, '_dt_sidenav_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                $show_content = isset( $settings['show_content'] ) ? $settings['show_content'] : '';
                $content_id = isset( $settings['content'] ) ? $settings['content'] : '';

                echo dt_theme_get_template_part( 'side-nav/template/', 'tpl-side-nav', '', array( 'id' => $id, 'show_content' => $show_content, 'content_id' => $content_id ) );
                echo '<div class="side-navigation-content">';
            }
        }
        function after_content_wrap() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                echo "</div>";
            }
        }

        function get_page_template() {
            if( is_singular('page') ) {
                return get_post_meta( get_the_ID(), '_wp_page_template', true );
            }
        }
    }
}

DesignThemesSideNav::instance();