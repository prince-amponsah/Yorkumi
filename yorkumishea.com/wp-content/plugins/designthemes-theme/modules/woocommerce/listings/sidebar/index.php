<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Theme_Woo_Sidebar' ) ) {
    class Dt_Theme_Woo_Sidebar {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';

        private $primary_class   = '';

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
            add_filter('savon_woo_loop_column_class', array( $this, 'woo_loop_column_class' ), 10, 2 );
        }

        function primary_classes( $primary_class ) {

            if( is_shop()  ) {
                $settings = get_post_meta( get_option('woocommerce_shop_page_id'), '_dt_layout_settings', true );
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

            if( is_product_category() || is_product_tag() ) {
                $primary_class = $this->global_layout;
                if( $primary_class == 'with-left-sidebar' || $primary_class == 'with-right-sidebar' ) {
                    $primary_class = empty( $this->global_sidebar ) ?  'content-full-width' : $primary_class;
                }
            }

            if( $primary_class == 'with-left-sidebar' ) {
                $primary_class = 'page-with-sidebar with-left-sidebar';
            }elseif( $primary_class == 'with-right-sidebar' ) {
                $primary_class = 'page-with-sidebar with-right-sidebar';
            }

            $this->primary_class = $primary_class;

            return $primary_class;
        }

        function secondary_classes( $secondary_class ) {
            if( is_shop()  ) {
                $settings = get_post_meta( get_option('woocommerce_shop_page_id'), '_dt_layout_settings', true );
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

            if( is_product_category() || is_product_tag() ) {
                $secondary_class = $this->global_layout;
            }

            if( $secondary_class == 'with-left-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
            }elseif( $secondary_class == 'with-right-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
            }

            return $secondary_class;
        }

        function active_sidebars( $sidebars = array() ) {

            if( is_shop()  ) {
                $settings = get_post_meta( get_option('woocommerce_shop_page_id'), '_dt_layout_settings', true );
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

            if( is_product_category() || is_product_tag() ) {
                $sidebars = array( $this->global_sidebar );
            }

            return array_filter( $sidebars );
        }

        function woo_loop_column_class( $class, $columns ) {

            if(isset($this->primary_class) && ($this->primary_class == 'page-with-sidebar with-left-sidebar' || $this->primary_class == 'page-with-sidebar with-right-sidebar')) {

                switch( $columns ) {
                    case 1:
                        $class = 'dt-col dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12';
                    break;

                    case 2:
                        $class = 'dt-col dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-6 dt-col-qxlg-6 dt-col-lg-6';
                    break;

                    case 3:
                    case 4:
                    default:
                        $class = 'dt-col dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4';
                    break;
                }

            }

            return $class;

        }
    }
}

Dt_Theme_Woo_Sidebar::instance();