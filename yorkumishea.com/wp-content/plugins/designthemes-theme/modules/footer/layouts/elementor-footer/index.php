<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesElementorFooter' ) ) {
    class DesignThemesElementorFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_footer_layouts', array( $this, 'add_elementor_footer_option' ), 20 );
            add_action( 'dt_general_cutomizer_options', array( $this, 'register_general' ), 30 );

            $footer = dt_customizer_settings( 'site_footer' );
            $footer = apply_filters( 'savon_final_footer', $footer );
            if( $footer == 'elementor-footer' ) {
                add_action( 'init', array( $this, 'frontend' ) );
            }
        }

        function add_elementor_footer_option( $options ) {
            $options['elementor-footer'] = esc_html__('Elementor Footer', 'designthemes-theme');
            return $options;
        }

        function register_general( $wp_customize ) {
            /**
             * Option :Site Elementor Footer
             */
            $wp_customize->add_setting(
                DT_CUSTOMISER_VAL . '[site_elementor_footer]', array(
                    'type'    => 'dt-description',
                )
            );
            
            $wp_customize->add_control(
                new DT_WP_Customize_Control_Description(
                    $wp_customize, DT_CUSTOMISER_VAL . '[site_elementor_footer]', array(
                        'type'        => 'dt-description',
                        'section'     => 'site-footer-section',
                        'label'       => esc_html__( 'Elementor Footers', 'designthemes-theme' ),
                        'dependency'  => array( 'site_footer', '==', 'elementor-footer' ),
                        'description' => esc_html__( 'Compatible with Jet Elements, you can build and assign it in elementor.', 'designthemes-theme' ),
                    )
                )
            );             

        }

        function frontend() {
            add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );
            remove_action( 'savon_footer', 'footer_content' );
            add_action( 'savon_footer', array( $this, 'load_template' ) );
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-footer-elementor', DT_THEME_DIR_URL . 'modules/footer/layouts/elementor-footer/assets/css/elementor-footer.css',DT_THEME_VERSION );
        }        

        function load_template() {
            echo dt_theme_get_template_part( 'footer/layouts/elementor-footer', 'template', '' );
        }
    }
}

DesignThemesElementorFooter::instance();