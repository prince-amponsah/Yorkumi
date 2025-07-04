<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxBreadcrumb' ) ) {
    class MetaboxBreadcrumb {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'breadcrumb' ) );
        }

        function breadcrumb( $options ) {

            $post_types = apply_filters( 'dtm_breadcrumb_posts', array( 'post', 'page' ) );

            $options[] = array(
                'id'        => '_dt_breadcrumb_settings',
                'title'     => esc_html('Breadcrumb', 'designthemes-theme'),
                'post_type' => $post_types,
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'layout_section',
                        'fields' => array(
                            array(
                                'id'      => 'layout',
                                'type'    => 'image_select',
                                'title'   => esc_html__('Breadcrumb Settings?', 'designthemes-theme'),
                                'options' => array(
                                    'global-option'     => DT_THEME_DIR_URL . 'modules/breadcrumb/assets/images/admin-option.png',
                                    'individual-option' => DT_THEME_DIR_URL . 'modules/breadcrumb/assets/images/individual-option.png',
                                    'disable'           => DT_THEME_DIR_URL . 'modules/breadcrumb/assets/images/disable.png',
                                ),
                                'default'    => 'global-option',
                                'attributes' => array( 'data-depend-id' => 'breadcrumb-layout' )
                            ),
                            array(
                                'id'         => 'enable_dark_bg',
                                'type'       => 'switcher',
                                'title'      => esc_html__('Dark BG?', 'designthemes-theme' ),
                                'default'    => true,
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'position',
                                'type'       => 'select',
                                'title'      => esc_html__('Position?', 'designthemes-theme'),
                                'options'    => array(
                                    'header-top-absolute' => esc_html__('Behind the Header','designthemes-theme'),
                                    'header-top-relative' => esc_html__('Default','designthemes-theme'),
                                ),
                                'default'    => 'header-top-relative',
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'background',
                                'type'       => 'background',
                                'title'      => esc_html__('Background', 'designthemes-theme' ),
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            )
                        )
                    )
                )
            );

            return $options;
        }
    }
}

MetaboxBreadcrumb::instance();            