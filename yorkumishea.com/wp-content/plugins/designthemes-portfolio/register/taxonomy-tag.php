<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DTRegisterPortfolioTags' ) ) {
    class DTRegisterPortfolioTags {

        private static $_instance = null;
        private $slug             = 'dt-portfolio-tag';
        private $permalinks       = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->permalinks = get_option( DT_PORTFOLIO_OPTION );

            add_action( 'admin_init', array( $this, 'settings' ) );
            add_action( 'init', array( $this, 'register' ), 0 );
        }

        function settings() {
            add_settings_field(
                'portfolio-tag-base',
                esc_html__('Portfolio Tag base', 'designthemes-portfolio'),
                array( $this, 'settings_input' ),
                'permalink',
                'optional'
            );
        }

        function settings_input() {
            $permalinks = $this->permalinks;
            $value      = isset( $permalinks['portfolio-tag-base'] ) ? $permalinks['portfolio-tag-base'] : $this->slug;

            printf(
                '<input name="dt_portfolios[portfolio-tag-base]" type="text" class="regular-text code" value="%s" placeholder="%s"/>',
                $value,
                $this->slug
            );
        }

        function register() {
            $permalinks = $this->permalinks;
            $tag_slug   = isset( $permalinks['portfolio-tag-base'] ) ? $permalinks['portfolio-tag-base'] : $this->slug;

            $labels = array(
                'name'          => _x( 'Tags', 'Portfolio Tag taxonomy General Name', 'designthemes-portfolio' ),
                'singular_name' => _x( 'Tag', 'Portfolio Tag Taxonomy Singular Name', 'designthemes-portfolio' ),
                'menu_name'     => esc_html__( 'Tags', 'designthemes-portfolio' ),
            );

            $args = array(
                'labels'            => $labels,
                'public'            => true,
                'show_ui'           => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => true,
                'query_var'         => true,
                'show_in_rest'      => true,
                'rewrite'           => array ( 'slug' => $tag_slug ),
            );

            register_taxonomy( 'dt_portfolio_tags', array( 'dt_portfolios' ), $args );
            flush_rewrite_rules();
        }
    }
}

DTRegisterPortfolioTags::instance();