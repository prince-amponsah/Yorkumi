<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'DesignThemesFrameworkHeaderPostType' ) ) {

	class DesignThemesFrameworkHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'dt_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'dt_template_include' ) );
		}

		function dt_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'designthemes-framework' ),
				'singular_name'		 => __( 'Header', 'designthemes-framework' ),
				'menu_name'			 => __( 'Headers', 'designthemes-framework' ),
				'add_new'			 => __( 'Add Header', 'designthemes-framework' ),
				'add_new_item'		 => __( 'Add New Header', 'designthemes-framework' ),
				'edit'				 => __( 'Edit Header', 'designthemes-framework' ),
				'edit_item'			 => __( 'Edit Header', 'designthemes-framework' ),
				'new_item'			 => __( 'New Header', 'designthemes-framework' ),
				'view'				 => __( 'View Header', 'designthemes-framework' ),
				'view_item' 		 => __( 'View Header', 'designthemes-framework' ),
				'search_items' 		 => __( 'Search Headers', 'designthemes-framework' ),
				'not_found' 		 => __( 'No Headers found', 'designthemes-framework' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'designthemes-framework' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'dt_headers', $args );
		}

		function dt_template_include($template) {
			if ( is_singular( 'dt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-dt_headers.php' ) ) {
					$template = DT_FW_DIR_PATH . 'post-types/templates/single-dt_headers.php';
				}
			}

			return $template;
		}
	}
}

DesignThemesFrameworkHeaderPostType::instance();