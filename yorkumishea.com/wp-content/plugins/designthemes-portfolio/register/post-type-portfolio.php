<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DTRegisterPortfolio' ) ) {
    class DTRegisterPortfolio {

        private static $_instance = null;
        private $slug             = 'dt-portfolio';
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
                'portfolio-base',
                esc_html__('Portfolio base', 'designthemes-portfolio'),
                array( $this, 'settings_input' ),
                'permalink',
                'optional'
            );
        }

        function settings_input() {
            $permalinks = $this->permalinks;
            $value      = isset( $permalinks['portfolio-base'] ) ? $permalinks['portfolio-base'] : $this->slug;

            printf(
                '<input name="dt_portfolios[portfolio-base]" type="text" class="regular-text code" value="%s" placeholder="%s"/>',
                $value,
                $this->slug
            );
        }

        function register() {
            $permalinks     = $this->permalinks;
            $portfolio_slug = isset( $permalinks['portfolio-base'] ) ? $permalinks['portfolio-base'] : $this->slug;

            $labels = array(
                'name'                  => _x( 'Portfolios', 'Portfolio General Name', 'designthemes-portfolio' ),
                'singular_name'         => _x( 'Portfolio', 'Portfolio Singular Name', 'designthemes-portfolio' ),
                'menu_name'             => esc_html__( 'Portfolios', 'designthemes-portfolio' ),
                'name_admin_bar'        => esc_html__( 'Portfolio', 'designthemes-portfolio' ),
                'archives'              => esc_html__( 'Portfolio Item Archives', 'designthemes-portfolio' ),
                'attributes'            => esc_html__( 'Portfolio Item Attributes', 'designthemes-portfolio' ),
                'parent_item_colon'     => esc_html__( 'Portfolio Parent Item:', 'designthemes-portfolio' ),
                'all_items'             => esc_html__( 'All Portfolios', 'designthemes-portfolio' ),
                'add_new_item'          => esc_html__( 'Add New Portfolio', 'designthemes-portfolio' ),
                'add_new'               => esc_html__( 'Add New', 'designthemes-portfolio' ),
                'new_item'              => esc_html__( 'New Portfolio Item', 'designthemes-portfolio' ),
                'edit_item'             => esc_html__( 'Edit Portfolio Item', 'designthemes-portfolio' ),
                'update_item'           => esc_html__( 'Update Portfolio Item', 'designthemes-portfolio' ),
                'view_item'             => esc_html__( 'View Portfolio Item', 'designthemes-portfolio' ),
                'view_items'            => esc_html__( 'View Portfolio Items', 'designthemes-portfolio' ),
                'search_items'          => esc_html__( 'Search Portfolio Item', 'designthemes-portfolio' ),
                'not_found'             => esc_html__( 'Not found', 'designthemes-portfolio' ),
                'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'designthemes-portfolio' ),
                'insert_into_item'      => esc_html__( 'Insert into item', 'designthemes-portfolio' ),
                'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'designthemes-portfolio' ),
                'items_list'            => esc_html__( 'Portfolio Items list', 'designthemes-portfolio' ),
                'items_list_navigation' => esc_html__( 'Portfolio Items list navigation', 'designthemes-portfolio' ),
                'filter_items_list'     => esc_html__( 'Filter portfolio items list', 'designthemes-portfolio' ),
            );

            $args = array(
                'label'               => esc_html__( 'Portfolios', 'designthemes-portfolio' ),
                'description'         => esc_html__( 'This is custom post type portfolios.', 'designthemes-portfolio' ),
                'labels'              => $labels,
                'supports'            => array ( 'title', 'editor', 'comments', 'excerpt', 'revisions' ),
                'hierarchical'        => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_position'       => 5,
                'menu_icon'           => 'dashicons-format-image',
                'show_in_admin_bar'   => true,
                'show_in_nav_menus'   => true,
                'show_in_rest'        => true,
                'public'              => true,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'query_var'           => true,
                'capability_type'     => 'post',
                'rewrite'             => array ( 'slug' => $portfolio_slug ),
            );

            register_post_type( 'dt_portfolios', $args );
            flush_rewrite_rules();
        }
    }
}

DTRegisterPortfolio::instance();