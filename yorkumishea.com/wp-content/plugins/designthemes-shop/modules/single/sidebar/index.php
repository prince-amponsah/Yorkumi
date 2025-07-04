<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Woo_single_Sidebar' ) ) {
    class Dt_Theme_Woo_single_Sidebar {

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

            $this->global_layout  = dt_customizer_settings('global_sidebar_layout');
            $this->global_sidebar = dt_customizer_settings('global_sidebar');

            $this->frontend();

        }

        function frontend() {
            add_filter('savon_primary_classes', array( $this, 'primary_classes' ) );
            add_filter('savon_secondary_classes', array( $this, 'secondary_classes' ) );
            add_filter('savon_active_sidebars', array( $this, 'active_sidebars' ) );
        }

        function primary_classes( $primary_class ) {

            if( is_product() ) {

                global $post;
                $post_id = $post->ID;

                $settings = get_post_meta( $post_id, '_dt_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'content-full-width' ) {
                        $primary_class = 'content-full-width';
                    }elseif( $settings['layout'] == 'with-left-sidebar' || $settings['layout'] == 'with-right-sidebar' ) {
                        $sidebars      = isset( $settings['sidebars'] ) ? $settings['sidebars'] : array();
                        $primary_class = count( $sidebars ) ? $settings['layout'] : 'content-full-width';
                    }elseif( $settings['layout'] == 'global-sidebar-layout' ) {
                        $primary_class = $this->global_layout;
                        if( $primary_class == 'with-left-sidebar' || $primary_class == 'with-right-sidebar' ) {
                            $primary_class = empty( $this->global_sidebar ) ?  'content-full-width' : $primary_class;
                        }
                    }
                } else {
                    $primary_class = $this->global_layout;
                    if( $primary_class == 'with-left-sidebar' || $primary_class == 'with-right-sidebar' ) {
                        $primary_class = empty( $this->global_sidebar ) ?  'content-full-width' : $primary_class;
                    }
                }

            }

            if( $primary_class == 'with-left-sidebar' ) {
                $primary_class = 'page-with-sidebar with-left-sidebar';
            }elseif( $primary_class == 'with-right-sidebar' ) {
                $primary_class = 'page-with-sidebar with-right-sidebar';
            }

            return $primary_class;
        }

        function secondary_classes( $secondary_class ) {

            if( is_product() ) {

                global $post;
                $post_id = $post->ID;

                $settings = get_post_meta( $post_id, '_dt_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'global-sidebar-layout' ) {
                        $secondary_class = $this->global_layout;
                    } else {
                        $secondary_class = $settings['layout'];
                    }
                } else{
                    $secondary_class = $this->global_layout;
                }

            }

            if( $secondary_class == 'with-left-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
            }elseif( $secondary_class == 'with-right-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
            }

            return $secondary_class;
        }

        function active_sidebars( $sidebars = array() ) {

            if( is_product() ) {

                global $post;
                $post_id = $post->ID;

                $settings = get_post_meta( $post_id, '_dt_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'global-sidebar-layout' ) {
                        $global_sidebar = $this->global_sidebar;
                        if( $global_sidebar ) {
                            $sidebars = array( $global_sidebar );
                        }
                    } else {
                        $sidebars = isset( $settings['sidebars'] ) ? $settings['sidebars'] : array();
                    }
                }else{
                    $sidebars = array( $this->global_sidebar );
                }

            }

            return array_filter( $sidebars );
        }

    }
}

Dt_Theme_Woo_single_Sidebar::instance();