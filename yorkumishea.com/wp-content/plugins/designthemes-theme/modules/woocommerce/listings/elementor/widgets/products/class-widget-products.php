<?php
namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Products extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-products';
	}

	public function get_title() {
		return esc_html__( 'Products', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array( 'swiper', 'dtshop-products-carousel', 'dtshop-products' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'dtshop-products' );
	}

	public function product_cats() {

		$categories = get_categories( array(
			'hide_empty' =>  0,
			'taxonomy'   =>  'product_cat'
		) );

		$categories_array = array ();

		foreach( $categories as $category ){
			$categories_array[ $category->term_id  ] = $category->name;
		}

		return $categories_array;
	}

	public function product_tags() {

		$tags = get_categories( array(
			'hide_empty' =>  0,
			'taxonomy'   =>  'product_tag'
		) );

		$tags_array = array ();

		foreach( $tags as $tag ){

			$tags_array[ $tag->term_id ] = $tag->name;
		}

		return $tags_array;
	}

	public function product_posts() {

		$product_posts = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'product'
		) );

		$product_title_array = array ();

		foreach($product_posts as $product_post){
			$product_title_array[ $product_post->ID ] = $product_post->post_title;
		}

		return $product_title_array;
	}

	public function product_style_templates() {

		$product_templates_list = array ();
		$product_templates_list[-1] = esc_html__('Admin Option', 'designthemes-theme');

		$cs_options = get_option( CS_OPTION );

		if( is_array( $cs_options ) && !empty( $cs_options ) ) {
			foreach( $cs_options as $cs_option_key => $cs_option ) {

				if( strpos($cs_option_key, 'dt-woo-product-style-template-') !== false ) {

					$product_templates_list[str_replace('dt-woo-product-style-template-', 'predefined-template-', $cs_option_key)] = $cs_option[0]['product-template-id'];

				} else if( strpos($cs_option_key, 'dt-woo-product-style-templates') !== false ) {

					if( is_array( $cs_option ) && !empty( $cs_option ) ) {
						foreach( $cs_option as $cs_custom_option_key => $cs_custom_option ) {
							$product_templates_list['custom-template-'.$cs_custom_option_key] = $cs_custom_option['product-template-id'];
						}
					}

				}

			}
		}

		return $product_templates_list;

	}

	protected function register_controls() {

		$this->general_section();
		$this->filter_section();
		$this->carousel_section();
	}

	public function general_section() {

		$this->start_controls_section( 'products_section', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		) );

			$this->add_control( 'data_source', array(
				'label'       => __( 'Data Source', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''           => esc_html__('All Products', 'designthemes-theme'),
					'featured'   => esc_html__('Featured Products', 'designthemes-theme'),
					'recent'     => esc_html__('Recent Products', 'designthemes-theme'),
					'sale'       => esc_html__('Sale Products', 'designthemes-theme'),
					'bestseller' => esc_html__('Bestsellers', 'designthemes-theme'),
				),
	        ) );

			$this->add_control( 'show_pagination', array(
				'label'        => esc_html__( 'Show Pagination', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'True', 'designthemes-theme' ),
				'label_off'    => __( 'False', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'enable_carousel', array(
				'label'        => esc_html__( 'Enable Carousel', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'True', 'designthemes-theme' ),
				'label_off'    => __( 'False', 'designthemes-theme' ),
				'default'      => '',
				'return_value' => 'true',
				'condition'   => array( 'show_pagination' => '' ),
			) );

			$this->add_control( 'post_per_page', array(
				'label'   => esc_html__( 'Post Per Page', 'designthemes-theme' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 12
			) );

			$this->add_control( 'display_mode', array(
				'label'       => __( 'Display Mode', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'grid' => __('Grid', 'designthemes-theme'),
					'list' => __('List', 'designthemes-theme'),
				),
				'default'     => 'grid',
	        ) );

			$this->add_control( 'columns', array(
				'label'       => __( 'Columns', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 4,
				'condition'   => array( 'display_mode' => 'grid' ),
	        ) );

			$this->add_control( 'list_options', array(
				'label'       => __( 'List Options', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'left-thumb'  => __('Left Thumb', 'designthemes-theme'),
					'right-thumb' => __('Right Thumb', 'designthemes-theme'),
				),
				'default'     => 'left-thumb',
				'condition'   => array( 'display_mode' => 'list' ),
	        ) );

			$this->add_control( 'product_style_template', array(
				'label'       => __( 'Product Style Template', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'designthemes-theme' ),
				'options'     => $this->product_style_templates(),
				'default'     => '-1',
	        ) );

			$this->add_control(
				'class',
				array (
					'label' => __( 'Class', 'designthemes-theme' ),
					'type'  => Controls_Manager::TEXT
				)
			);

			$this->add_control(
				'current_page',
				array (
					'label' => __( 'Current Page', 'designthemes-theme' ),
					'type'  => Controls_Manager::HIDDEN,
					'default' => 1
				)
			);

			$this->add_control(
				'offset',
				array (
					'label' => __( 'Offset', 'designthemes-theme' ),
					'type'  => Controls_Manager::HIDDEN,
					'default' => 0
				)
			);

		$this->end_controls_section();

	}

	public function filter_section() {

		$this->start_controls_section( 'filter_section', array(
			'label' => esc_html__( 'Filters', 'designthemes-theme' ),
		) );

			$this->add_control( 'categories', array(
				'label'       => __( 'Categories', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'description' => esc_html__( 'Choose categories that you want to display.', 'designthemes-theme' ),
				'options'     => $this->product_cats(),
	        ) );

			$this->add_control( 'tags', array(
				'label'       => __( 'Tags', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'description' => esc_html__( 'Choose tags that you want to display.', 'designthemes-theme' ),
				'options'     => $this->product_tags(),
	        ) );

			$this->add_control( 'include', array(
				'label'       => __( 'Include', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Choose product that you want to display.', 'designthemes-theme' ),
	        ) );

			$this->add_control( 'exclude', array(
				'label'       => __( 'Exclude', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Choose product that you don\'t want to display.', 'designthemes-theme' ),
	        ) );

		$this->end_controls_section();

	}

	public function carousel_section() {

		$this->start_controls_section( 'product_carousel_section', array(
			'label'     => esc_html__( 'Carousel Settings', 'designthemes-theme' ),
			'condition' => array( 'enable_carousel' => 'true' ),
		) );
			$this->add_control( 'carousel_effect', array(
				'label'       => __( 'Effect', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'designthemes-theme' ),
				'default'     => '',
				'options'     => array(
					''     => __( 'Default', 'designthemes-theme' ),
					'fade' => __( 'Fade', 'designthemes-theme' ),
					'multirow' => __( 'Multi Row', 'designthemes-theme' ),
	            ),
	        ) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => __( 'Slides Per View', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'designthemes-theme' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6 ),
				'default'     => 2,
				'condition'   => array( 'carousel_effect' => array ( '', 'multirow' ) ),
	        ) );

			$this->add_control( 'carousel_slidespercolumn', array(
				'label'       => __( 'Slides Per Column', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show per column.', 'designthemes-theme' ),
				'options'     => array( 2 => 2, 3 => 3 ),
				'default'     => 2,
				'condition'   => array( 'carousel_effect' => array ('multirow' ) ),
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

			$this->add_control( 'carousel_spacebetween', array(
				'label'       => esc_html__( 'Space Between Sliders', 'designthemes-theme' ),
				'type'        => Controls_Manager::HIDDEN,
				'description' => esc_html__('Space between sliders can be given here.', 'designthemes-theme'),
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = dtshop_products_render_html($settings);

		echo $output;

	}

}