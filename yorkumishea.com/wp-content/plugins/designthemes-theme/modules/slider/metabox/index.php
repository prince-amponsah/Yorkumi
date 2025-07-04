<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxSlider' ) ) {
    class MetaboxSlider {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'slider' ) );
        }

        function slider( $options ) {

            $post_types = apply_filters( 'dtm_slider_posts', array( 'page' ) );

            $options[] = array(
                'id'        => '_dt_slider_settings',
                'title'     => esc_html('Slider', 'designthemes-theme'),
                'post_type' => $post_types,
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'layout_section',
                        'fields' => array(
                            array(
                                'id'      => 'slider-notice',
                                'type'    => 'notice',
                                'class'   => 'danger',
                                'content' => esc_html__('Slider tab works only if breadcrumb disabled.','designthemes-theme'),
                                'class'   => 'margin-30 cs-danger'
                            ),
                            array(
                                'id'    => 'show',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Slider', 'designthemes-theme' ),
                            ),
                            array(
                                'id'         => 'position',
                                'type'       => 'select',
                                'title'      => esc_html__('Position?', 'designthemes-theme' ),
                                'options'    => array(
                                    'header-top-relative' => esc_html__('Top Header Relative','designthemes-theme'),
                                    'header-top-absolute' => esc_html__('Top Header Absolute','designthemes-theme'),
                                    'bottom-header'       => esc_html__('Bottom Header','designthemes-theme'),
                                ),
                                'default'    => 'bottom-header',
                                'dependency' => array( 'show', '==', 'true' ),
                            ),
                            array(
                                'id'         => 'type',
                                'type'       => 'select',
                                'title'      => esc_html__('Slider', 'designthemes-theme' ),
                                'options'    => array(
                                  ''                 => esc_html__('Select a slider','designthemes-theme'),
                                  'layerslider'      => esc_html__('Layer slider','designthemes-theme'),
                                  'revolutionslider' => esc_html__('Revolution slider','designthemes-theme'),
                                  'customslider'     => esc_html__('Custom Slider Shortcode','designthemes-theme'),
                                ),
                                'dependency' => array( 'show', '==', 'true' ),
                            ),
                            array(
                                'id'         => 'layerslider',
                                'type'       => 'select',
                                'title'      => esc_html__('Layer Slider', 'designthemes-theme' ),
                                'options'    => $this->layersliders(),
                                'dependency' => array( 'show|type', '==|==', 'true|layerslider' ),
                            ),
                            array(
                                'id'         => 'revolutionslider',
                                'type'       => 'select',
                                'title'      => esc_html__('Revolution Slider', 'designthemes-theme' ),
                                'options'    => $this->revolutionsliders(),
                                'dependency' => array( 'show|type', '==|==', 'true|revolutionslider' ),
                            ),
                            array(
                                'id'         => 'customslider',
                                'type'       => 'textarea',
                                'title'      => esc_html__('Custom Slider Code', 'designthemes-theme' ),
                                'dependency' => array( 'show|type', '==|==', 'true|customslider' ),
                            ),                                                      
                        )
                    )
                )
            );

            return $options;
        }

        function layersliders() {
            $layerslider = array( esc_html__('Select a slider','designthemes-theme') );

            if( class_exists('LS_Sliders') ) {
                $sliders = LS_Sliders::find(array('limit' => 50));

                if(!empty($sliders)) {
                    foreach($sliders as $key => $item){
                        $layerslider[ $item['id'] ] = $item['name'];
                    }
                }
            }
          
            return $layerslider;
        }

        function revolutionsliders() {
            $revolutionslider = array( '' => esc_html__('Select a slider','designthemes-theme') );

            if( class_exists('RevSlider') ) {
                $sld     = new RevSlider();
                $sliders = $sld->getArrSliders();
                
                if(!empty($sliders)){
                    foreach($sliders as $key => $item) {
                        $revolutionslider[$item->getAlias()] = $item->getTitle();
                    }
                }
            }
          
            return $revolutionslider;            
        }
    }
}

MetaboxSlider::instance();            