<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'CustomizerBlogPost' ) ) {
    class CustomizerBlogPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {

            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );            
            add_action( 'dt_blog_cutomizer_options', array( $this, 'register_blog_post' ), 40 );
        }

        function default( $option ) {

            $option['enable_title'] 		  = '1';
            $option['enable_image_lightbox']  = '0';
			$option['enable_disqus_comments'] = '0';
			$option['enable_related_article'] = '0';
			$option['post_disqus_shortname']  = '';
			$option['post_dynamic_elements']  = array( 'content', 'author_bio', 'comment_box', 'navigation', 'likes_views', 'related_posts', 'social' );
			$option['rposts_title']    		  = esc_html__('Related Posts', 'designthemes-theme');
			$option['rposts_column']   		  = 'one-third-column';
			$option['rposts_count']    		  = '3';
			$option['rposts_excerpt']  		  = '0';
			$option['rposts_excerpt_length']  = '25';
			$option['rposts_carousel']  	  = '0';
			$option['rposts_carousel_nav']    = '';
			$option['post_commentlist_style'] = 'rounded';

            return $option;
        }

        function register_blog_post( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-blog-post-section',
                    array(
                        'title'    => esc_html__('Single Post', 'designthemes-theme'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 20,
                    )
                )
            );

				/**
				 * Option : Post Title
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[enable_title]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Switch(
						$wp_customize, DT_CUSTOMISER_VAL . '[enable_title]', array(
							'type'    => 'dt-switch',
							'label'   => esc_html__( 'Enable Title', 'designthemes-theme'),
							'description' => esc_html__('YES! to enable the title of single post.', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => array(
								'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
								'off' => esc_attr__( 'No', 'designthemes-theme' )
							)
						)
					)
				);

				/**
				 * Option : Post Elements
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
						'type' => 'option',
					)
				);

			    $wp_customize->add_control(
			    	new DT_WP_Customize_Control_Sortable(
			    		$wp_customize, DT_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
							'type' => 'dt-sortable',
							'label' => esc_html__( 'Post Elements Positioning', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => apply_filters( 'savon_blog_post_dynamic_elements', array(
								'author'		=> esc_html__('Author', 'designthemes-theme'),
								'author_bio' 	=> esc_html__('Author Bio', 'designthemes-theme'),
								'category'    	=> esc_html__('Categories', 'designthemes-theme'),
								'comment' 		=> esc_html__('Comments', 'designthemes-theme'),
								'comment_box' 	=> esc_html__('Comment Box', 'designthemes-theme'),
								'content'    	=> esc_html__('Content', 'designthemes-theme'),
								'date'     		=> esc_html__('Date', 'designthemes-theme'),
								'image'			=> esc_html__('Feature Image', 'designthemes-theme'),
								'navigation'    => esc_html__('Navigation', 'designthemes-theme'),
								'tag'  			=> esc_html__('Tags', 'designthemes-theme'),
								'title'      	=> esc_html__('Title', 'designthemes-theme'),
								'likes_views'   => esc_html__('Likes & Views', 'designthemes-theme'),
								'related_posts' => esc_html__('Related Posts', 'designthemes-theme'),
								'social'  		=> esc_html__('Social Share', 'designthemes-theme'),
							)
						),
			        )
			    ));

				/**
				 * Option : Image Lightbox
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Switch(
						$wp_customize, DT_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
							'type'    => 'dt-switch',
							'label'   => esc_html__( 'Feature Image Lightbox', 'designthemes-theme'),
							'description' => esc_html__('YES! to enable lightbox for feature image. Will not work in "Overlay" style.', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => array(
								'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
								'off' => esc_attr__( 'No', 'designthemes-theme' )
							)
						)
					)
				);

				/**
				 * Option : Related Article
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[enable_related_article]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Switch(
						$wp_customize, DT_CUSTOMISER_VAL . '[enable_related_article]', array(
							'type'    => 'dt-switch',
							'label'   => esc_html__( 'Enable Related Article', 'designthemes-theme'),
							'description' => esc_html__('YES! to enable related article at right hand side of post.', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => array(
								'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
								'off' => esc_attr__( 'No', 'designthemes-theme' )
							)
						)
					)
				);

				/**
				 * Option : Disqus Comments
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Switch(
						$wp_customize, DT_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
							'type'    => 'dt-switch',
							'label'   => esc_html__( 'Enable Disqus Comments', 'designthemes-theme'),
							'description' => esc_html__('YES! to enable disqus platform comments module.', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => array(
								'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
								'off' => esc_attr__( 'No', 'designthemes-theme' )
							)
						)
					)
				);

				/**
				 * Option : Disqus Short Name
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control(
						$wp_customize, DT_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
							'type'    	  => 'textarea',
							'section'     => 'site-blog-post-section',
							'label'       => esc_html__( 'Shortname', 'designthemes-theme' ),
							'input_attrs' => array(
								'placeholder' => 'disqus',
							),
							'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
						)
					)
				);

				/**
				 * Option : Disqus Description
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[post_disqus_description]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Description(
						$wp_customize, DT_CUSTOMISER_VAL . '[post_disqus_description]', array(
							'type'    	  => 'dt-description',
							'section'     => 'site-blog-post-section',
							'description' => esc_html__('Your site\'s unique identifier', 'designthemes-theme').' '.'<a href="'.esc_url('https://help.disqus.com/customer/portal/articles/466208').'" target="_blank">'.esc_html__('What is this?', 'designthemes-theme').'</a>',
							'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
						)
					)
				);

				/**
				 * Option : Comment List Style
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[post_commentlist_style]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control( new DT_WP_Customize_Control(
					$wp_customize, DT_CUSTOMISER_VAL . '[post_commentlist_style]', array(
						'type'    => 'select',
						'section' => 'site-blog-post-section',
						'label'   => esc_html__( 'Comments List Style', 'designthemes-theme' ),
						'choices' => array(
						  'rounded' 	=> esc_html__('Rounded', 'designthemes-theme'),
						  'square'   	=> esc_html__('Square', 'designthemes-theme'),
						),
						'description' => esc_html__('Choose comments list style to display single post.', 'designthemes-theme'),
						'dependency' => array( 'enable_disqus_comments', '!=', 'true' ),
					)
				));

				/**
				 * Option : Post Related Title
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_title]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control(
						$wp_customize, DT_CUSTOMISER_VAL . '[rposts_title]', array(
							'type'    	  => 'text',
							'section'     => 'site-blog-post-section',
							'label'       => esc_html__( 'Related Posts Section Title', 'designthemes-theme' ),
							'description' => esc_html__('Put the related posts section title here', 'designthemes-theme'),
							'input_attrs' => array(
								'value'	=> esc_html__('Related Posts', 'designthemes-theme'),
							)
						)
					)
				);

				/**
				 * Option : Related Columns
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_column]', array(
						'type' => 'option',
					)
				);

			    $wp_customize->add_control( new DT_WP_Customize_Control_Radio_Image(
					$wp_customize, DT_CUSTOMISER_VAL . '[rposts_column]', array(
						'type' => 'dt-radio-image',
						'label' => esc_html__( 'Columns', 'designthemes-theme'),
						'section' => 'site-blog-post-section',
						'choices' => apply_filters( 'savon_blog_post_related_columns', array(
							'one-column' => array(
								'label' => esc_html__( 'One Column', 'designthemes-theme' ),
								'path' => DT_THEME_DIR_URL . 'modules/post/customizer/images/one-column.png'
							),
							'one-half-column' => array(
								'label' => esc_html__( 'One Half Column', 'designthemes-theme' ),
								'path' => DT_THEME_DIR_URL . 'modules/post/customizer/images/one-half-column.png'
							),
							'one-third-column' => array(
								'label' => esc_html__( 'One Third Column', 'designthemes-theme' ),
								'path' => DT_THEME_DIR_URL . 'modules/post/customizer/images/one-third-column.png'
							),
						)),
			        )
			    ));

				/**
				 * Option : Related Count
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_count]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control(
						$wp_customize, DT_CUSTOMISER_VAL . '[rposts_count]', array(
							'type'    	  => 'text',
							'section'     => 'site-blog-post-section',
							'label'       => esc_html__( 'No.of Posts to Show', 'designthemes-theme' ),
							'description' => esc_html__('Put the no.of related posts to show', 'designthemes-theme'),
							'input_attrs' => array(
								'value'	=> 3,
							),
						)
					)
				);

				/**
				 * Option : Enable Excerpt
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_excerpt]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Switch(
						$wp_customize, DT_CUSTOMISER_VAL . '[rposts_excerpt]', array(
							'type'    => 'dt-switch',
							'label'   => esc_html__( 'Enable Excerpt Text', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => array(
								'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
								'off' => esc_attr__( 'No', 'designthemes-theme' )
							)
						)
					)
				);

				/**
				 * Option : Excerpt Text
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control(
						$wp_customize, DT_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
							'type'    	  => 'text',
							'section'     => 'site-blog-post-section',
							'label'       => esc_html__( 'Excerpt Length', 'designthemes-theme' ),
							'description' => esc_html__('Put Excerpt Length', 'designthemes-theme'),
							'input_attrs' => array(
								'value'	=> 25,
							),
							'dependency' => array( 'rposts_excerpt', '==', 'true' ),
						)
					)
				);

				/**
				 * Option : Related Carousel
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_carousel]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control(
					new DT_WP_Customize_Control_Switch(
						$wp_customize, DT_CUSTOMISER_VAL . '[rposts_carousel]', array(
							'type'    => 'dt-switch',
							'label'   => esc_html__( 'Enable Carousel', 'designthemes-theme'),
							'description' => esc_html__('YES! to enable carousel related posts', 'designthemes-theme'),
							'section' => 'site-blog-post-section',
							'choices' => array(
								'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
								'off' => esc_attr__( 'No', 'designthemes-theme' )
							)
						)
					)
				);

				/**
				 * Option : Related Carousel Nav
				 */
				$wp_customize->add_setting(
					DT_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
						'type' => 'option',
					)
				);

				$wp_customize->add_control( new DT_WP_Customize_Control(
					$wp_customize, DT_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
						'type'    => 'select',
						'section' => 'site-blog-post-section',
						'label'   => esc_html__( 'Navigation Style', 'designthemes-theme' ),
						'choices' => array(
							'' 			 => esc_html__('None', 'designthemes-theme'),
							'navigation' => esc_html__('Navigations', 'designthemes-theme'),
							'pager'   	 => esc_html__('Pager', 'designthemes-theme'),
						),
						'description' => esc_html__('Choose navigation style to display related post carousel.', 'designthemes-theme'),
						'dependency' => array( 'rposts_carousel', '==', 'true' ),
					)
				));
        }
    }
}

CustomizerBlogPost::instance();