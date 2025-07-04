<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxSideNav' ) ) {
    class MetaboxSideNav {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'sidenav' ) );
        }

        function sidenav( $options ) {
            $options[] = array(
                'id'        => '_dt_sidenav_settings',
                'title'     => esc_html('Side Navigation Template', 'designthemes-theme'),
                'post_type' => 'page',
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'sidenav_section',
                        'fields' => array(
                            array(
                                'id'      => 'sidenav-tpl-notice',
                                'type'    => 'notice',
                                'class'   => 'success',
                                'content' => esc_html__('Side Navigation Tab Works only if page template set to Side Navigation Template in Page Attributes','designthemes-theme'),
                                'class'   => 'margin-30 cs-success'
                            ),
                            array(
                                'id'      => 'style',
                                'type'    => 'select',
                                'title'   => esc_html__('Side Navigation Style', 'designthemes-theme' ),
                                'options' => array(
                                    'sidenav-style-type1' => esc_html__('Type1','designthemes-theme'),
                                    'sidenav-style-type2' => esc_html__('Type2','designthemes-theme'),
                                    'sidenav-style-type3' => esc_html__('Type3','designthemes-theme'),
                                    'sidenav-style-type4' => esc_html__('Type4','designthemes-theme'),
                                    'sidenav-style-type5' => esc_html__('Type5','designthemes-theme')
                                ),
                            ),
                            array(
                                'id'    => 'align',
                                'type'  => 'switcher',
                                'title' => esc_html__('Align Right', 'designthemes-theme' ),
                                'info'  => esc_html__('YES! to align right of side navigation.','designthemes-theme')
                            ),
                            array(
                                'id'    => 'sticky',
                                'type'  => 'switcher',
                                'title' => esc_html__('Sticky Side Navigation', 'designthemes-theme' ),
                                'info'  => esc_html__('YES! to sticky side navigation content.','designthemes-theme')
                            ),
                            array(
                                'id'    => 'show_content',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Content', 'designthemes-theme' ),
                                'info'  => esc_html__('YES! to show content in below side navigation.','designthemes-theme')
                            ),
                            array(
                                'id'         => 'content',
                                'type'       => 'select',
                                'title'      => esc_html__('Content', 'designthemes-theme' ),
                                'options'    => dt_elementor_library_list(),
                                'dependency' => array( 'show_content', '==', 'true' ),
                            ),                            
                        )
                    )
                )
            );

            return $options;
        }
    }
}

MetaboxSideNav::instance();