<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DTRegisterPortfolioFields' ) ) {
    class DTRegisterPortfolioFields {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'init', array( $this, 'register' ), 0 );
            add_action( 'admin_head', array( $this, 'taxonomy_css' ) );
            add_filter( 'manage_edit-dt_portfolio_fields_columns', array( $this, 'remove_fields' ) );
            add_filter( 'cs_taxonomy_options', array( $this, 'register_fields' ) );
            add_filter( 'dtm_metabox_custom_fields', array( $this, 'register_metabox_fields' ) );
        }

        function register() {
            $labels = array(
                'name'          => _x( 'Fields', 'Portfolio Custom Fields Name', 'designthemes-portfolio' ),
                'singular_name' => _x( 'Field', 'Portfolio Custom Field Name', 'designthemes-portfolio' ),
                'menu_name'     => esc_html__( 'Extra Fields', 'designthemes-portfolio' ),
                'all_items'     => esc_html__( 'All Fields', 'designthemes-portfolio' ),
                'add_new_item'  => esc_html__( 'Add New Field', 'designthemes-portfolio' ),
                'add_new'       => esc_html__( 'Add New', 'designthemes-portfolio' ),
                'new_item'      => esc_html__( 'New Field', 'designthemes-portfolio' ),
                'edit_item'     => esc_html__( 'Edit Field', 'designthemes-portfolio' ),
                'update_item'   => esc_html__( 'Update Field Item', 'designthemes-portfolio' ),
                'view_item'     => esc_html__( 'View Field Item', 'designthemes-portfolio' ),
                'view_items'    => esc_html__( 'View Field Items', 'designthemes-portfolio' ),
                'search_items'  => esc_html__( 'Search Field Item', 'designthemes-portfolio' ),
            );

            $args = array(
                'labels'            => $labels,
                'hierarchical'      => false,
                'public'            => false,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'capabilities'      => array( 'edit_theme_options' ),
                'query_var'         => false,
                'rewrite'           => false,
            );

            register_taxonomy( 'dt_portfolio_fields', array( 'dt_portfolios' ), $args );
        }

        function taxonomy_css() {
            if ( get_current_screen()->id != 'edit-dt_portfolio_fields' ) {
                return;
            }

            echo '<style>';
                echo '#addtag div.form-field.term-slug-wrap, #edittag tr.form-field.term-slug-wrap { display: none; }';
                echo '#addtag div.form-field.term-description-wrap, #edittag tr.form-field.term-description-wrap { display: none; }';
            echo '</style>';
        }

        function remove_fields( $columns ) {

            $screen = get_current_screen();

            if ( isset( $screen->base ) && 'edit-tags' == $screen->base ) {
				$old_columns = $columns;
				$columns     = array(
					'cb'   => $old_columns['cb'],
					'name' => $old_columns['name'],
				);
            }

            return $columns;
        }

        function register_fields( $options ) {
            $options[] = array(
                'id'       => 'dt_portfolio_fields_options',
                'taxonomy' => 'dt_portfolio_fields',
                'fields'   => array(
                    array(
                        'id'      => 'type',
                        'type'    => 'select',
                        'title'   => esc_html__('Field Type?', 'designthemes-theme'),
                        'options' => array(
                            'text' => esc_html__('Text','designthemes-theme'),
                            'link' => esc_html__('Link','designthemes-theme'),
                        ),
                        'default' => 'text',
                    ),

                )
            );

            return $options;
        }

        function register_metabox_fields() {
            $fields = array();
            $terms  = get_terms( 'dt_portfolio_fields', array( 'hide_empty' => false ) );

            if( !empty( $terms ) ) {
                foreach ( $terms as $term ) {
                    $id   = $term->term_id;
                    $name = $term->name;

                    $meta = get_term_meta( $id, 'dt_portfolio_fields_options', true );
                    $type = isset( $meta['type'] ) ? $meta['type'] : 'text';

                    if( $type == 'text' ) {
                        $fields[  $id ] = array(
                            'id'    => 'dt_portfolio_fields_'.$term->term_id,
                            'title' => $name,
                            'type'  => 'text'
                        );
                    }

                    if( $type == 'link' ) {
                        $fields[  $id ] = array(
                            'id'     => 'dt_portfolio_fields_'.$term->term_id,
                            'title'  => $name,
                            'type'   => 'fieldset',
                            'fields' => array(
                                array(
                                    'id'    => 'link',
                                    'type'  => 'text',
                                    'title' => esc_html__('Link', 'designthemes-portfolio' ),
                                ),
                                array(
                                    'id'    => 'text',
                                    'type'  => 'text',
                                    'title' => esc_html__('Link Text', 'designthemes-portfolio' ),
                                ),
                                array(
                                    'id'    => 'target',
                                    'type'  => 'switcher',
                                    'title' => esc_html__('Open in New Window', 'designthemes-portfolio' ),
                                  ),
                            )
                        );
                    }
                }
            }

            return $fields;
        }
    }
}

DTRegisterPortfolioFields::instance();