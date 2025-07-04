<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Blog_Posts extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-blog-posts';
    }

    public function get_title() {
        return __('Blog Posts', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-thumb-tack';
	}

	public function get_style_depends() {
		return array( 'swiper', 'dt-blogcarousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'dt-blogcarousel' );
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),  
        ) );

            $this->add_control( '_post_categories', array(
                'label'       => esc_html__( 'Categories', 'designthemes-theme' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->dt_post_categories()
            ) );

            $this->add_control( 'count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => __('Post Counts', 'designthemes-theme'),
                'default'     => '5',
                'placeholder' => __( 'Enter post count', 'designthemes-theme' ),
            ) );

            $this->add_control( 'blog_post_layout', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Post Layout', 'designthemes-theme'),
                'default' => 'entry-grid',
                'options' => array(
                    'entry-grid'  => __('Grid', 'designthemes-theme'),
                    'entry-list'  => __('List', 'designthemes-theme'),
                    'entry-cover' => __('Cover', 'designthemes-theme'),
                )
            ) );

            $this->add_control( 'blog_post_grid_list_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Post Style', 'designthemes-theme'),
                'default' => 'dt-sc-boxed',
                'options' => array(
                    'dt-sc-boxed'           => __('Boxed', 'designthemes-theme'),
                    'dt-sc-simple'          => __('Simple', 'designthemes-theme'),
                    'dt-sc-overlap'         => __('Overlap', 'designthemes-theme'),
                    'dt-sc-content-overlay' => __('Content Overlay', 'designthemes-theme'),
                    'dt-sc-simple-withbg'   => __('Simple with Background', 'designthemes-theme'),
                    'dt-sc-overlay'         => __('Overlay', 'designthemes-theme'),
                    'dt-sc-overlay-ii'      => __('Overlay II', 'designthemes-theme'),
                    'dt-sc-overlay-iii'     => __('Overlay III', 'designthemes-theme'),
                    'dt-sc-alternate'       => __('Alternate', 'designthemes-theme'),
                    'dt-sc-minimal'         => __('Minimal', 'designthemes-theme'),
                    'dt-sc-modern'          => __('Modern', 'designthemes-theme'),
                    'dt-sc-classic'         => __('Classic', 'designthemes-theme'),
                    'dt-sc-classic-ii'      => __('Classic II', 'designthemes-theme'),
                    'dt-sc-classic-overlay' => __('Classic Overlay', 'designthemes-theme'),
                    'dt-sc-grungy-boxed'    => __('Grungy Boxed', 'designthemes-theme'),
                    'dt-sc-title-overlap'   => __('Title Overlap', 'designthemes-theme'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_post_cover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Post Style', 'designthemes-theme'),
                'default' => 'dt-sc-boxed',
                'options' => array(
                    'dt-sc-boxed'           => __('Boxed', 'designthemes-theme'),
                    'dt-sc-canvas'          => __('Canvas', 'designthemes-theme'),
                    'dt-sc-content-overlay' => __('Content Overlay', 'designthemes-theme'),
                    'dt-sc-overlay'         => __('Overlay', 'designthemes-theme'),
                    'dt-sc-overlay-ii'      => __('Overlay II', 'designthemes-theme'),
                    'dt-sc-overlay-iii'     => __('Overlay III', 'designthemes-theme'),
                    'dt-sc-trendy'          => __('Trendy', 'designthemes-theme'),
                    'dt-sc-mobilephone'     => __('Mobile Phone', 'designthemes-theme'),
                ),
                'condition' => array( 'blog_post_layout' => 'entry-cover' )
            ) );

            $this->add_control( 'blog_post_columns', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Columns', 'designthemes-theme'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'        => __('I Column', 'designthemes-theme'),
                    'one-half-column'   => __('II Columns', 'designthemes-theme'),
                    'one-third-column'  => __('III Columns', 'designthemes-theme'),
                    'one-fourth-column' => __('IV Columns', 'designthemes-theme'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'blog_list_thumb', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('List Type', 'designthemes-theme'),
                'default' => 'entry-left-thumb',
                'options' => array(
                    'entry-left-thumb'  => __('Left Thumb', 'designthemes-theme'),
                    'entry-right-thumb' => __('Right Thumb', 'designthemes-theme'),
                ),
                'condition' => array( 'blog_post_layout' => 'entry-list' )
            ) );

            $this->add_control( 'blog_alignment', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Elements Alignment', 'designthemes-theme'),
                'default' => 'alignnone',
                'options' => array(
                    'alignnone'   => __('None', 'designthemes-theme'),
                    'alignleft'   => __('Align Left', 'designthemes-theme'),
                    'aligncenter' => __('Align Center', 'designthemes-theme'),
                    'alignright'  => __('Align Right', 'designthemes-theme'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );
        
            $this->add_control( 'enable_equal_height', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable Equal Height?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_no_space', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable No Space?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_gallery_slider', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Display Gallery Slider?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Element', 'designthemes-theme'),
                'default' => 'feature_image',
                'options' => array(
                    'feature_image' => __('Feature Image', 'designthemes-theme'),
                    'title'         => __('Title', 'designthemes-theme'),
                    'content'       => __('Content', 'designthemes-theme'),
                    'read_more'     => __('Read More', 'designthemes-theme'),
                    'meta_group'    => __('Meta Group', 'designthemes-theme'),
                    'author'        => __('Author', 'designthemes-theme'),
                    'date'          => __('Date', 'designthemes-theme'),
                    'comment'       => __('Comments', 'designthemes-theme'),
                    'category'      => __('Categories', 'designthemes-theme'),
                    'tag'           => __('Tags', 'designthemes-theme'),
                    'social'        => __('Social Share', 'designthemes-theme'),
                    'likes_views'   => __('Likes & Views', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'blog_elements_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => __('Elements & Positioning', 'designthemes-theme'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'title' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Element', 'designthemes-theme'),
                'default' => 'author',
                'options' => array(
                    'author'       => __('Author', 'designthemes-theme'),
                    'date'         => __('Date', 'designthemes-theme'),
                    'comment'      => __('Comments', 'designthemes-theme'),
                    'category'     => __('Categories', 'designthemes-theme'),
                    'tag'          => __('Tags', 'designthemes-theme'),
                    'social'       => __('Social Share', 'designthemes-theme'),
                    'likes_views'  => __('Likes & Views', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'blog_meta_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => __('Meta Group Positioning', 'designthemes-theme'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'author' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $this->add_control( 'enable_post_format', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable Post Format?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );
        
            $this->add_control( 'enable_video_audio', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Display Video & Audio for Posts?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
                'description'  => __( 'YES! to display video & audio, instead of feature image for posts', 'designthemes-theme' ),
            ) );

            $this->add_control( 'enable_excerpt_text', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable Excerpt Text?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'blog_excerpt_length', array(
                'type'      => Controls_Manager::NUMBER,
                'label'     => __('Excerpt Length', 'designthemes-theme'),
                'default'   => '25',
                'condition' => array( 'enable_excerpt_text' => 'yes' )
            ) );

            $this->add_control( 'blog_readmore_text', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => __('Read More Text', 'designthemes-theme'),
                'default'     => __('Read More', 'designthemes-theme'),
            ) );

            $this->add_control( 'blog_image_hover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Image Hover Style', 'designthemes-theme'),
                'default' => 'dt-sc-default',
                'options' => array(
                    'dt-sc-default'     => __('Default', 'designthemes-theme'),
                    'dt-sc-blur'        => __('Blur', 'designthemes-theme'),
                    'dt-sc-bw'          => __('Black and White', 'designthemes-theme'),
                    'dt-sc-brightness'  => __('Brightness', 'designthemes-theme'),
                    'dt-sc-fadeinleft'  => __('Fade InLeft', 'designthemes-theme'),
                    'dt-sc-fadeinright' => __('Fade InRight', 'designthemes-theme'),
                    'dt-sc-hue-rotate'  => __('Hue-Rotate', 'designthemes-theme'),
                    'dt-sc-invert'      => __('Invert', 'designthemes-theme'),
                    'dt-sc-opacity'     => __('Opacity', 'designthemes-theme'),
                    'dt-sc-rotate'      => __('Rotate', 'designthemes-theme'),
                    'dt-sc-rotate-alt'  => __('Rotate Alt', 'designthemes-theme'),
                    'dt-sc-scalein'     => __('Scale In', 'designthemes-theme'),
                    'dt-sc-scaleout'    => __('Scale Out', 'designthemes-theme'),
                    'dt-sc-sepia'       => __('Sepia', 'designthemes-theme'),
                    'dt-sc-tint'        => __('Tint', 'designthemes-theme'),
                ),
                'description' => __('Note: Fade, Rotate & Scale Styles will not work for Gallery Sliders.', 'designthemes-theme'),
            ) );

            $this->add_control( 'blog_image_overlay_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Image Overlay Style', 'designthemes-theme'),
                'default' => 'dt-sc-default',
                'options' => array(
                    'dt-sc-default'         => __('None', 'designthemes-theme'),
                    'dt-sc-fixed'           => __('Fixed', 'designthemes-theme'),
                    'dt-sc-tb'              => __('Top to Bottom', 'designthemes-theme'),
                    'dt-sc-bt'              => __('Bottom to Top', 'designthemes-theme'),
                    'dt-sc-rl'              => __('Right to Left', 'designthemes-theme'),
                    'dt-sc-lr'              => __('Left to Right', 'designthemes-theme'),
                    'dt-sc-middle'          => __('Middle', 'designthemes-theme'),
                    'dt-sc-middle-radial'   => __('Middle Radial', 'designthemes-theme'),
                    'dt-sc-tb-gradient'     => __('Gradient - Top to Bottom', 'designthemes-theme'),
                    'dt-sc-bt-gradient'     => __('Gradient - Bottom to Top', 'designthemes-theme'),
                    'dt-sc-rl-gradient'     => __('Gradient - Right to Left', 'designthemes-theme'),
                    'dt-sc-lr-gradient'     => __('Gradient - Left to Right', 'designthemes-theme'),
                    'dt-sc-radial-gradient' => __('Gradient - Radial', 'designthemes-theme'),
                    'dt-sc-flash'           => __('Flash', 'designthemes-theme'),
                    'dt-sc-circle'          => __('Circle', 'designthemes-theme'),
                    'dt-sc-hm-elastic'      => __('Horizontal Elastic', 'designthemes-theme'),
                    'dt-sc-vm-elastic'      => __('Vertical Elastic', 'designthemes-theme'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_pagination', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Pagination Style', 'designthemes-theme'),
                'default' => 'older_newer',
                'options' => array(
                    ''                => __('None', 'designthemes-theme'),
                    'older_newer'     => __('Older & Newer', 'designthemes-theme'),
                    'numbered'        => __('Numbered', 'designthemes-theme'),
                    'load_more'       => __('Load More', 'designthemes-theme'),
                    'infinite_scroll' => __('Infinite Scroll', 'designthemes-theme'),
                    'carousel'        => __('Carousel', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => __('Extra class name', 'designthemes-theme'),
                'description' => __('Style particular element differently - add a class name and refer to it in custom CSS', 'designthemes-theme')
            ) );

        $this->end_controls_section();

		$this->start_controls_section( 'blog_carousel_section', array(
			'label'     => esc_html__( 'Carousel Settings', 'designthemes-theme' ),
			'condition' => array( 'blog_pagination' => 'carousel' ),
		) );
			$this->add_control( 'carousel_effect', array(
				'label'       => __( 'Effect', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'designthemes-theme' ),
				'default'     => '',
				'options'     => array(
					''     => __( 'Default', 'designthemes-theme' ),
					'fade' => __( 'Fade', 'designthemes-theme' ),
	            ),
	        ) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => __( 'Slides Per View', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'designthemes-theme' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 2,
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'designthemes-theme'),
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'designthemes-theme'),
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'designthemes-theme'),
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'designthemes-theme'),
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => __( 'Arrow Type', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'designthemes-theme' ),
				'options'     => array( 
					''      => esc_html__('Default', 'designthemes-theme'), 
					'type2' => esc_html__('Type 2', 'designthemes-theme'), 
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),				
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'designthemes-theme'),
				'label_on'     => __( 'yes', 'designthemes-theme' ),
				'label_off'    => __( 'no', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

		$this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

		$media_carousel_attributes_string = $container_class = $wrapper_class = $item_class = '';

		if( $blog_pagination == 'carousel' ) {

			$media_carousel_attributes = array ();

			array_push( $media_carousel_attributes, 'data-carouseleffect="'.$settings['carousel_effect'].'"' );
			array_push( $media_carousel_attributes, 'data-carouselslidesperview="'.$settings['carousel_slidesperview'].'"' );
			array_push( $media_carousel_attributes, 'data-carouselloopmode="'.$settings['carousel_loopmode'].'"' );
			array_push( $media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$settings['carousel_mousewheelcontrol'].'"' );
			array_push( $media_carousel_attributes, 'data-carouselbulletpagination="'.$settings['carousel_bulletpagination'].'"' );
			array_push( $media_carousel_attributes, 'data-carouselarrowpagination="'.$settings['carousel_arrowpagination'].'"' );
			array_push( $media_carousel_attributes, 'data-carouselscrollbar="'.$settings['carousel_scrollbar'].'"' );

			if( !empty( $media_carousel_attributes ) ) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$container_class = 'swiper-container';
			$wrapper_class = 'swiper-wrapper';
			$item_class = 'swiper-slide';

			$out .= '<div class="dt-sc-post-list-carousel-container">';
		}

		$out .= '<div class="dt-sc-posts-list-wrapper '.$container_class.' '.$el_class.'" '.$media_carousel_attributes_string.'>';

		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) { 
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
		$warning = esc_html__('No Posts Found','designthemes-theme');

		if( !empty( $_post_categories ) ) {
            $_post_categories = implode( ',', $_post_categories );
			$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'cat' => $_post_categories, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
			$warning = esc_html__('No Posts Found in Category ','designthemes-theme').$_post_categories;
		}

		if( !empty( $_post_not_in ) ) {
			$args['post__not_in'] = array( $_post_not_in );
            $settings['blog_excerpt_length'] = $settings['blog_excerpt_length2'];
		}

		$rposts = new WP_Query( $args );
		if ( $rposts->have_posts() ) :

           	do_action( 'call_blog_elementor_sc_filters', $settings );

            $holder_class  = savon_get_archive_post_holder_class();
            $combine_class = savon_get_archive_post_combine_class();

            $post_style    = savon_get_archive_post_style();
            $template_args['Post_Style'] = $post_style;
            $template_args = array_merge( $template_args, savon_archive_blog_post_params() );
            $template_args = apply_filters( 'savon_blog_archive_order_params', $template_args );

            $out .= "<div class='tpl-blog-holder ".$holder_class."'>";
            $out .= "<div class='grid-sizer ".$combine_class."'></div>";

                while( $rposts->have_posts() ) :
                    $rposts->the_post();
                    $post_ID = get_the_ID();

                    $out .= '<div class="'.esc_attr($combine_class).'">';
                        $out .= '<!-- #post-'. $post_ID .' -->';
                        $out .= '<article id="post-'.$post_ID.'" class="' . implode( ' ', get_post_class( '', $post_ID ) ) . '">';

                            $template_args['ID'] = $post_ID;
                            $out .= savon_get_template_part( 'blog', 'templates/'.$post_style.'/post', '', $template_args );
                        $out .= '</article><!-- #post-'. $post_ID .' -->';
                    $out .= '</div>';
                endwhile;

			wp_reset_postdata($rposts);

            $out .= '</div>';

			if( $blog_pagination == 'numbered' ):

				$out .= '<div class="pagination blog-pagination">'.savon_pagination($rposts).'</div>';

			elseif( $blog_pagination == 'older_newer' ):

				$out .= '<div class="pagination blog-pagination"><div class="newer-posts">'.get_previous_posts_link( '<i class="fa fa-angle-left"></i>'.esc_html__(' Newer Posts', 'designthemes-theme') ).'</div>';
				$out .= '<div class="older-posts">'.get_next_posts_link( esc_html__('Older Posts ', 'designthemes-theme').'<i class="fa fa-angle-right"></i>', $rposts->max_num_pages ).'</div></div>';

			elseif( $blog_pagination == 'load_more' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

				$out .= "<div class='pagination blog-pagination'><a class='loadmore-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' href='javascript:void(0);' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'>".esc_html__('Load More', 'designthemes-theme')."</a></div>";

			elseif( $blog_pagination == 'infinite_scroll' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

                $out .= "<div class='pagination blog-pagination'><div class='infinite-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'></div></div>";

			elseif( $blog_pagination == 'carousel' ):

				$out .= '<div class="dt-sc-products-pagination-holder">';

					if( $settings['carousel_bulletpagination'] == 'true' ) {
						$out .= '<div class="dt-sc-products-bullet-pagination"></div>';	
					}

					if( $settings['carousel_scrollbar'] == 'true' ) {
						$out .= '<div class="dt-sc-products-scrollbar"></div>';	
					}											

					if( $settings['carousel_arrowpagination'] == 'true' ) {
						$out .= '<div class="dt-sc-products-arrow-pagination '.$settings['carousel_arrowpagination_type'].'">';
							$out .= '<a href="#" class="dt-sc-products-arrow-prev">'.esc_html__('Prev', 'designthemes-theme').'</a>';
							$out .= '<a href="#" class="dt-sc-products-arrow-next">'.esc_html__('Next', 'designthemes-theme').'</a>';
						$out .= '</div>';
					}

				$out .= '</div>';

			endif;

		else:
			$out .= "<div class='dt-sc-warning-box'>{$warning}</div>";
		endif;

		$out .= '</div>';

		if( $blog_pagination == 'carousel' ) {
			$out .= '</div>';
		}

        echo $out;
    }

    protected function content_template() {
    }
}