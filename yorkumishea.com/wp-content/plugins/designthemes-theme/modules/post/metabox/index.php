<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxPostOptions' ) ) {
    class MetaboxPostOptions {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'post_options' ) );
			add_filter( 'cs_metabox_options', array( $this, 'header_footer_options' ) );
			add_action( 'template_redirect', array( $this, 'register_templates' ) );
        }

        function post_options( $options ) {

            $post_types = apply_filters( 'dtm_post_options_post', array( 'post' ) );

            $options[] = array(
                'id'        => '_dt_post_settings',
                'title'     => esc_html('Post Options', 'designthemes-theme'),
                'post_type' => $post_types,
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'post_options_section',
                        'fields' => array(
							array(
								'id'         => 'single_post_style',
								'type'       => 'select',
								'title'      => esc_html__('Post Style', 'designthemes-theme'),
								'options'    => apply_filters( 'dtm_post_styles', array() ),
								'class'      => 'chosen',
								'default'    => 'minimal',
								'attributes' => array(
									'style'  => 'width: 25%;'
								),
								'info'       => esc_html__('Choose post style to display single post. If post style is "Custom Template", display based on Editor content.', 'designthemes-theme')
							),
							array(
								'id'         => 'view_count',
							    'type'       => 'number',
							    'title'      => esc_html__('Views', 'designthemes-theme' ),
								'info'       => esc_html__('No.of views of this post.', 'designthemes-theme'),
								'attributes' => array(
									'style'  => 'width: 15%;'
								),
							),
							array(
								'id'         => 'like_count',
							    'type'       => 'number',
							    'title'      => esc_html__('Likes', 'designthemes-theme' ),
								'info'       => esc_html__('No.of likes of this post.', 'designthemes-theme'),
								'attributes' => array(
									'style'  => 'width: 15%;'
								),
							),
							array(
								'id' 		 => 'post-format-type',
								'title'   	 => esc_html__('Type', 'designthemes-theme' ),
								'type' 		 => 'select',
								'default' 	 => 'standard',
								'options' 	 => array(
								 'standard'  => esc_html__('Standard', 'designthemes-theme'),
								 'status'	 => esc_html__('Status','designthemes-theme'),
								 'quote'	 => esc_html__('Quote','designthemes-theme'),
								 'gallery'	 => esc_html__('Gallery','designthemes-theme'),
								 'image'	 => esc_html__('Image','designthemes-theme'),
								 'video'	 => esc_html__('Video','designthemes-theme'),
								 'audio'	 => esc_html__('Audio','designthemes-theme'),
								 'link'		 => esc_html__('Link','designthemes-theme'),
								 'aside'	 => esc_html__('Aside','designthemes-theme'),
								 'chat'		 => esc_html__('Chat','designthemes-theme')
								),
								'class'      => 'chosen',
								'attributes' => array(
									'style'  => 'width: 25%;'
								),
								'info'       => esc_html__('Post Format & Type should be Same. Check the Post Format from the "Format" Tab, which comes in the Right Side Section.', 'designthemes-theme'),
							),
							array(
								'id' 	 	 => 'post-gallery-items',
								'type'	 	 => 'gallery',
								'title'   	 => esc_html__('Add Images', 'designthemes-theme' ),
								'add_title'  => esc_html__('Add Images', 'designthemes-theme' ),
								'edit_title' => esc_html__('Edit Images', 'designthemes-theme' ),
								'clear_title'=> esc_html__('Remove Images', 'designthemes-theme' ),
								'dependency' => array( 'post-format-type', '==', 'gallery' ),
							),
							array(
								'id' 	  	 => 'media-type',
								'type'	  	 => 'select',
								'title'   	 => esc_html__('Select Type', 'designthemes-theme' ),
								'dependency' => array( 'post-format-type', 'any', 'video,audio' ),
						      	'options'	 => array(
						      		'oembed' => esc_html__('Oembed','designthemes-theme'),
						      		'self'   => esc_html__('Self Hosted','designthemes-theme'),
								)
							),
							array(
								'id' 	  	 => 'media-url',
								'type'	  	 => 'textarea',
								'title'   	 => esc_html__('Media URL', 'designthemes-theme' ),
								'dependency' => array( 'post-format-type', 'any', 'video,audio' ),
							),
							array(
								'id'         => 'fieldset_link',
						        'type'       => 'fieldset',
						        'title'      => esc_html__('Link Values', 'designthemes-theme'),
						        'fields'     => array(
						        	array(
						        	 'id'    => 'fieldset_link_title',
						        	 'type'  => 'text',
						        	 'title' => esc_html__('Link Text', 'designthemes-theme'),
						            ),
						            array(
						             'id'    => 'fieldset_link_url',
						             'type'  => 'text',
						             'title' => esc_html__('URL', 'designthemes-theme'),
						            ),
						        ),
						        'dependency' => array( 'post-format-type', '==', 'link' ),
						    ),
                        )
                    )
                )
            );

            return $options;
        }

		function header_footer_options( $options ) {

        	$post_types = apply_filters( 'dtm_header_footer_posts', array( 'post', 'page' ) );

			$options[] = array(
				'id'        => '_dt_custom_settings',
				'title'     => esc_html__('Header & Footer', 'designthemes-theme'),
				'post_type' => $post_types,
				'priority'  => 'high',
				'context'   => 'side',
				'sections'  => array(
					array(
						'name'   => 'header_section',
						'title'  => esc_html__('Header', 'designthemes-theme'),
						'icon'   => 'fa fa-angle-double-right',
						'fields' =>  array(
							array(
								'id'      => 'show-header',
								'type'    => 'switcher',
								'title'   => esc_html__('Show Header', 'designthemes-theme'),
								'default' =>  true,
							),
							array(
								'id'  		 => 'header',
								'type'  	 => 'select',
								'title' 	 => esc_html__('Choose Header', 'designthemes-theme'),
								'class'		 => 'chosen',
								'options'	 => 'posts',
								'query_args' => array(
									'post_type'      => 'dt_headers',
									'orderby'        => 'ID',
									'order'          => 'ASC',
									'posts_per_page' => -1,
								),
								'default_option' => esc_attr__('Select Header', 'designthemes-theme'),
								'attributes'     => array( 'style'	=> 'width:50%' ),
								'info'           => esc_html__('Select custom header for this page.','designthemes-theme'),
								'dependency'     => array( 'show-header', '==', 'true' )
							),
						)
					),

					array(
						'name'   => 'footer_settings',
						'title'  => esc_html__('Footer', 'designthemes-theme'),
						'icon'   => 'fa fa-angle-double-right',
						'fields' =>  array(
							array(
								'id'      => 'show-footer',
								'type'    => 'switcher',
								'title'   => esc_html__('Show Footer', 'designthemes-theme'),
								'default' =>  true,
							),
					        array(
								'id'         => 'footer',
								'type'       => 'select',
								'title'      => esc_html__('Choose Footer', 'designthemes-theme'),
								'class'      => 'chosen',
								'options'    => 'posts',
								'query_args' => array(
									'post_type'      => 'dt_footers',
									'orderby'        => 'ID',
									'order'          => 'ASC',
									'posts_per_page' => -1,
								),
								'default_option' => esc_attr__('Select Footer', 'designthemes-theme'),
								'attributes'     => array( 'style'  => 'width:50%' ),
								'info'           => esc_html__('Select custom footer for this page.','designthemes-theme'),
								'dependency'     => array( 'show-footer', '==', 'true' )
							),
						)
					),
				)
			);

			return $options;
        }

		function register_templates() {
			if( is_singular() ) {
				add_filter( 'savon_header_get_template_part', array( $this, 'register_header_template' ) );
            	add_filter( 'savon_footer_get_template_part', array( $this, 'register_footer_template' ), 10 );
			}
        }

        function register_header_template( $template ) {

        	$header_type = dt_customizer_settings( 'site_header' );

        	if( is_singular() ) {

        		global $post;

                $settings = get_post_meta( $post->ID, '_dt_custom_settings', TRUE );
                $settings = is_array( $settings ) ? $settings  : array();

                if( array_key_exists( 'show-header', $settings ) && ! $settings['show-header'] )
                    return;

                $id = isset( $settings['header'] ) ? $settings['header'] : '';

                $id = ( $id == '' ) ? ( ( 'custom-header' == $header_type ) ? dt_customizer_settings( 'site_custom_header' ) : '' ) : $id;

                if( ! $id || $id == -1 ) {
					echo savon_get_template_part( 'header', 'templates/header-content' );
					return;
                }

                apply_filters( 'savon_print_header_template', $id );
        	}
        }

        function register_footer_template( $template ) {

        	$footer_type = dt_customizer_settings( 'site_footer' );

        	if( is_singular() ) {

        		global $post;

                $settings = get_post_meta( $post->ID, '_dt_custom_settings', TRUE );
                $settings = is_array( $settings ) ? $settings  : array();

                if( array_key_exists( 'show-footer', $settings ) && ! $settings['show-footer'] )
                    return true;

                $id = isset( $settings['footer'] ) ? $settings['footer'] : '';

                $id = ( $id == '' ) ? ( ( 'custom-footer' == $footer_type ) ? dt_customizer_settings( 'site_custom_footer' ) : '' ) : $id;

                if( ! $id || $id == -1 ) {
                	$template = savon_get_template_part( 'footer', 'templates/footer' );
					return $template;
                }

                apply_filters( 'savon_print_footer_template', $id );

                if( $id ) {
                	return $template;
                } else {
                	return "";
                }
        	}
        }

    }
}

MetaboxPostOptions::instance();