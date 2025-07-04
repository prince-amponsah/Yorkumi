<?php
/**
 * 
 */
if( !class_exists( 'Savon_Loader' ) ) {

    class Savon_Loader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->define_constants();
            $this->load_helpers();

            add_action( 'after_setup_theme', array( $this, 'set_theme_support' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_js' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'add_inline_style' ) );

            add_action( 'savon_before_main_css', array( $this, 'add_google_fonts' ) );

            add_action( 'after_setup_theme', array( $this, 'include_module_helpers' ) );

            add_action( 'wp_head', array( $this, 'savon_wp_head' ),999 );

            add_action( 'wp_footer', array( $this, 'savon_wp_footer' ), 999 );
        }

        function define_constants() {
            define( 'SAVON_ROOT_DIR', get_template_directory() );
            define( 'SAVON_ROOT_URI', get_template_directory_uri() );
            define( 'SAVON_MODULE_DIR', SAVON_ROOT_DIR.'/modules'  );
            define( 'SAVON_MODULE_URI', SAVON_ROOT_URI.'/modules' );
            define( 'SAVON_LANG_DIR', SAVON_ROOT_DIR.'/languages' );

            $theme = wp_get_theme();
            define( 'SAVON_THEME_NAME', $theme->get('Name'));
            define( 'SAVON_THEME_VERSION', $theme->get('Version'));
        }

        function load_helpers() {
            include_once SAVON_ROOT_DIR . '/helpers/helper.php';
        }

        function set_theme_support() {
            load_theme_textdomain( 'savon', SAVON_LANG_DIR );
            add_theme_support( 'automatic-feed-links' );
            add_theme_support( 'title-tag' );
            add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
            add_theme_support( 'post-formats', array('status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat'));
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'custom-logo' );
            $GLOBALS['content_width'] = apply_filters( 'savon_set_content_width', 1230 );
            register_nav_menus( array(
                'main-menu' => esc_html__('Main Menu', 'savon'),
            ) );
        }

        function enqueue_js() {

            wp_enqueue_script('jquery-select2', get_theme_file_uri('/assets/lib/select2/select2.full.min.js'), array('jquery'), false, true);

            /**
             * Before Hook
             */
            do_action( 'savon_before_enqueue_js' );
                
                wp_enqueue_script('savon-jqcustom', get_theme_file_uri('/assets/js/custom.js'), array('jquery'), false, true);

                if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				    wp_enqueue_script( 'comment-reply' );
			    }

            /**
             * After Hook
             */
            do_action( 'savon_after_enqueue_js' );

        }

        function enqueue_css() {
            /**
             * Before Hook
             */
            do_action( 'savon_before_main_css' );

                wp_enqueue_style( 'savon', get_stylesheet_uri(), false, SAVON_THEME_VERSION, 'all' );
                wp_enqueue_style( 'savon-icons', get_theme_file_uri('/assets/css/icons.css'), false, SAVON_THEME_VERSION, 'all');

                $css = '';
                $css .= apply_filters( 'dt_theme_plugin_primary_color_css_var',  '--DTPrimaryColor: #EBBAA9;' );
                $css .= apply_filters( 'dt_theme_plugin_secondary_color_css_var',  '--DTSecondaryColor: #b9d1db;' );
                $css .= apply_filters( 'dt_theme_plugin_tertiary_color_css_var',  '--DTTertiaryColor: #f9ce98;' );
                $css .= apply_filters( 'dt_theme_plugin_body_bg_color_css_var',  '--DTBodyBGColor: #ffffff;' ); 
                $css .= apply_filters( 'dt_theme_plugin_body_text_color_css_var',  '--DTBodyTxtColor: #6a6a6a;' );
                $css .= apply_filters( 'dt_theme_plugin_link_color_css_var',  '--DTLinkColor: #000000;' );
                $css .= apply_filters( 'dt_theme_plugin_link_hover_color_css_var',  '--DTLinkHoverColor: #EBBAA9;' );

                if( !empty( $css ) ) {
                    wp_add_inline_style( 'savon', ':root {'.$css.'}' );
                }
                
                wp_enqueue_style( 'savon-base', get_theme_file_uri('/assets/css/base.css'), false, SAVON_THEME_VERSION, 'all');
                wp_enqueue_style( 'savon-grid', get_theme_file_uri('/assets/css/grid.css'), false, SAVON_THEME_VERSION, 'all');
                wp_enqueue_style( 'savon-layout', get_theme_file_uri('/assets/css/layout.css'), false, SAVON_THEME_VERSION, 'all');
                wp_enqueue_style( 'savon-widget', get_theme_file_uri('/assets/css/widget.css'), false, SAVON_THEME_VERSION, 'all');

            /**
             * After Hook
             */
            do_action( 'savon_after_main_css' );

            wp_enqueue_style( 'jquery-select2', get_theme_file_uri('/assets/lib/select2/select2.min.css'), false, SAVON_THEME_VERSION, 'all');

            wp_enqueue_style( 'savon-theme', get_theme_file_uri('/assets/css/theme.css'), false, SAVON_THEME_VERSION, 'all');
        }

        function add_inline_style() {

            wp_register_style( 'savon-admin', '', array(), SAVON_THEME_VERSION, 'all' );
            wp_enqueue_style( 'savon-admin' );

            $css = apply_filters( 'dt_theme_plugin_add_inline_style', $css = '' );

            if( !empty( $css ) ) {
                wp_add_inline_style( 'savon-admin', $css );
            }

            /**
             * Responsive CSS
             */

            # Tablet Landscape
                $tablet_landscape = apply_filters( 'dt_theme_plugin_add_tablet_landscape_inline_style', $tablet_landscape = '' );
                if( !empty( $tablet_landscape ) ) {
                    $tablet_landscape = '@media only screen and (min-width:1025px) and (max-width:1280px) {'."\n".$tablet_landscape."\n".'}';
                    wp_add_inline_style( 'savon-admin', $tablet_landscape );
                }         

            # Tablet Portrait
                $tablet_portrait = apply_filters( 'dt_theme_plugin_add_tablet_portrait_inline_style', $tablet_portrait = '' );
                if( !empty( $tablet_portrait ) ) {
                    $tablet_portrait = '@media only screen and (min-width:768px) and (max-width:1024px) {'."\n".$tablet_portrait."\n".'}';
                    wp_add_inline_style( 'savon-admin', $tablet_portrait );
                }                

            # Mobile
                $mobile_res = apply_filters( 'dt_theme_plugin_add_mobile_res_inline_style', $mobile_res = '' );
                if( !empty( $mobile_res ) ) {
                    $mobile_res = '@media (max-width: 767px) {'."\n".$mobile_res."\n".'}';
                    wp_add_inline_style( 'savon-admin', $mobile_res );
                }
        }

        function add_google_fonts() {
            $subset = apply_filters( 'dt_theme_google_font_supsets', 'latin-ext' );
            $fonts  = apply_filters( 'dt_theme_google_fonts_list', array(
                'Muli:300,400,700,900',
                'Muli:300,400,500,600,700,800,900',
                'Muli:400'
            ) );

			foreach( $fonts as $font ) {
				$url = '//fonts.googleapis.com/css?family=' . str_replace( ' ', '+', $font );
                $url .= !empty( $subset ) ? '&subset=' . $subset : '';
                
				$key = md5( $font . $subset );

				// check that the URL is valid. we're going to use transients to make this faster.
				$url_is_valid = get_transient( $key );

				// transient does not exist				
				if ( false === $url_is_valid ) { 
					$response = wp_remote_get( 'https:' . $url );
					if ( ! is_array( $response ) ) {
						// the url was not properly formatted,
						// cache for 12 hours and continue to the next field
						set_transient( $key, null, 12 * HOUR_IN_SECONDS );
						continue;
					}

					// check the response headers.
					if ( isset( $response['response'] ) && isset( $response['response']['code'] ) ) {
						if ( 200 == $response['response']['code'] ) {
							// URL was ok
							// set transient to true and cache for a week
							set_transient( $key, true, 7 * 24 * HOUR_IN_SECONDS );
							$url_is_valid = true;
						}
					}
				}

				// If the font-link is valid, enqueue it.
				if ( $url_is_valid ) {
					wp_enqueue_style( $key, $url, null, null );
				}
			}            

        }

        function include_module_helpers() {

            /**
             * Before Hook
             */
            do_action( 'savon_before_load_module_helpers' );

            foreach( glob( SAVON_ROOT_DIR. '/modules/*/helper.php'  ) as $helper ) {
                include_once $helper;
            }

            /**
             * After Hook
             */
            do_action( 'savon_after_load_module_helpers' );
        }

        function savon_wp_head() {
            ob_start();
        }

        function savon_wp_footer() {

            $content = ob_get_clean();
            $regex = "#<style id='savon-woo-non-archive-inline-css' type='text/css'>([^<]*)</style>#";
            preg_match($regex, $content, $matches);

            $styles = '';
            if( isset($matches[0]) ) {

                foreach ($matches[0] as $tag) {
                    $styles .= "\n".$tag;
                    $content = str_replace($tag, '', $content);
                }
            }

            if( !empty( $styles ) ) {
                $content = str_replace('</head>', $styles.'</head>', $content);
            }

            echo "{$content}";
        }

    }

    Savon_Loader::instance();
}