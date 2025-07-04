<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'DesignThemesFrameworkFooterPostType' ) ) {

	class DesignThemesFrameworkFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'dt_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'dt_template_include' ) );
		}

		function dt_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'designthemes-framework' ),
				'singular_name'		 => __( 'Footer', 'designthemes-framework' ),
				'menu_name'			 => __( 'Footers', 'designthemes-framework' ),
				'add_new'			 => __( 'Add Footer', 'designthemes-framework' ),
				'add_new_item'		 => __( 'Add New Footer', 'designthemes-framework' ),
				'edit'				 => __( 'Edit Footer', 'designthemes-framework' ),
				'edit_item'			 => __( 'Edit Footer', 'designthemes-framework' ),
				'new_item'			 => __( 'New Footer', 'designthemes-framework' ),
				'view'				 => __( 'View Footer', 'designthemes-framework' ),
				'view_item' 		 => __( 'View Footer', 'designthemes-framework' ),
				'search_items' 		 => __( 'Search Footers', 'designthemes-framework' ),
				'not_found' 		 => __( 'No Footers found', 'designthemes-framework' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'designthemes-framework' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'dt_footers', $args );			
		}

		function dt_template_include($template) {
			if ( is_singular( 'dt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-dt_footers.php' ) ) {
					$template = DT_FW_DIR_PATH . 'post-types/templates/single-dt_footers.php';
				}
			}

			return $template;
		}
	}
}

DesignThemesFrameworkFooterPostType::instance();