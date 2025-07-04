<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Product_Cat extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-product-cat';
	}

	public function get_title() {
		return esc_html__( 'Product Categories', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array ( 'dtshop-product-cat' );
	}

	public function get_script_depends() {
		return array ();
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_cat_section', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose type that you like yo use.', 'designthemes-theme' ),
				'options'     => array(
					'type1' => esc_html__('Type 1', 'designthemes-theme'),
					'type2' => esc_html__('Type 2', 'designthemes-theme')
				),
				'default'     => 'type1',
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column', 'designthemes-theme'),
					2  => esc_html__('II Columns', 'designthemes-theme'),
					3  => esc_html__('III Columns', 'designthemes-theme')
				),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.', 'designthemes-theme' ),
				'default'      => 3,
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include', 'designthemes-theme' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Category ids separated by comma.', 'designthemes-theme' ),
				'default' => ''
			) );

			$this->add_control( 'show_starting_price', array(
				'label'       => __( 'Show Starting Price', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose true if you like to show starting price.', 'designthemes-theme' ),
				'options'     => array(
					'false' => esc_html__('False', 'designthemes-theme'),
					'true'  => esc_html__('True', 'designthemes-theme'),
				),
				'condition'   => array( 'type' => 'type1' ),
				'default'     => 'false',
	        ) );

			$this->add_control( 'show_button', array(
				'label'       => __( 'Show Button', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose true if you like to show button.', 'designthemes-theme' ),
				'options'     => array(
					'false' => esc_html__('False', 'designthemes-theme'),
					'true'  => esc_html__('True', 'designthemes-theme'),
				),
				'default'     => 'false',
	        ) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'designthemes-theme' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'designthemes-theme' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

			if($settings['columns'] == 1) {
				$column_class = 'column dt-sc-one-column';
			} else if($settings['columns'] == 2) {
				$column_class = 'column dt-sc-one-half';
			} else {
				$column_class = 'column dt-sc-one-third';
			}

			$cat_args = array (
				'taxonomy'   => 'product_cat',
				'hide_empty' => 1
			);
			if($settings['include'] != '') {
				$cat_args['include'] = $settings['include'];
			}
			$categories = get_categories($cat_args);

			if( is_array($categories) && !empty($categories) ) {

				$i = 1;
				foreach( $categories as $category ) {

					if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
					if($i == $settings['columns']) { $i = 1; } else { $i = $i + 1; }

					$term_id = $category->term_id;
					$thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
					$image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
					$cat_image = $image_url[0];

					$color_html = '';
					$dtshop_cat_color = get_term_meta($term_id, 'dtshop_cat_color', true);
					if($dtshop_cat_color != '') {
						$color_html .= '<div class="dt-sc-shop-category-listing-color" style="background-color:'.$dtshop_cat_color.';"></div>';
					}

					if($settings['type'] == 'type2') {

						$output .= '<div class="dt-sc-shop-category-listing-item '.$column_class.' '.$first_class.' '.$settings['type'].' '.$settings['class'].'">';
							$output .= '<div class="dt-sc-shop-category-listing-inner">';
								$output .= '<div class="dt-sc-shop-category-listing-image">';
									$output .= '<a href="'.get_term_link($category->term_id).'"><img src="'.esc_url($cat_image).'" alt="'.esc_html__('Category Image', 'designthemes-theme').'" title="'.esc_html__('Category Image', 'designthemes-theme').'" /></a>';
								$output .= '</div>';
								$output .= '<div class="dt-sc-shop-category-meta-data">';
									$output .= '<h3><a href="'.get_term_link($category->term_id).'">'.esc_html($category->cat_name).'</a></h3>';
									$output .= '<div class="dt-sc-shop-category-total-items">('.sprintf( esc_html__('%1$s Items', 'designthemes-theme'), '<span>'.$category->count.'</span>' ).')</div>';
									if($settings['show_button'] == 'true') {
										$output .= '<a href="'.get_term_link($category->term_id).'" class="dt-sc-shop-cat-button button">'.esc_html__('View Details', 'designthemes-theme').'</a>';
									}
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

					} else {

						$output .= '<div class="dt-sc-shop-category-listing-item '.$column_class.' '.$first_class.' '.$settings['type'].' '.$settings['class'].'">';
						$output .= '<div class="dt-sc-shop-category-listing-inner">';
							$output .= '<div class="dt-sc-shop-category-listing-image">';
									$output .= '<a href="'.get_term_link($category->term_id).'"><img src="'.esc_url($cat_image).'" alt="'.esc_html__('Category Image', 'designthemes-theme').'" title="'.esc_html__('Category Image', 'designthemes-theme').'" /></a>';
									$output .= $color_html;
								$output .= '</div>';
								$output .= '<div class="dt-sc-shop-category-meta-data">';
									$output .= '<h3><a href="'.get_term_link($category->term_id).'">'.esc_html($category->cat_name).'</a></h3>';
									if($settings['show_starting_price'] == 'true') {

										$product_args = array (
											'posts_per_page' => -1,
											'post_type'      => 'product',
											'meta_query'     => array (),
											'tax_query'      => array (),
											'post_status'    => 'publish'
										);

										$product_args['tax_query'][] = array (
											'taxonomy' => 'product_cat',
											'field' => 'id',
											'terms' => $category,
											'operator' => 'IN'
										);

										$product_args['orderby']  = 'meta_value_num';
										$product_args['order']    = 'ASC';
										$product_args['meta_key'] = '_sale_price';
										$product_args['fields']   = 'ids';

										$product_ids = get_posts($product_args);
										$cat_product_id = $product_ids[0];

										$wc_product_object = wc_get_product( $cat_product_id );
										if($wc_product_object) {
											$woo_price_html = $wc_product_object->get_price_html();

											if($woo_price_html != '') {
												$output .= '<div class="dt-sc-shop-category-starting-price-html">'.sprintf(esc_html__('Starts from %1$s', 'designthemes-theme'), $woo_price_html).'</div>';
											}
										}

									}
									if($settings['show_button'] == 'true') {
										$output .= '<a href="'.get_term_link($category->term_id).'" class="dt-sc-shop-cat-button button">'.esc_html__('View Details', 'designthemes-theme').'</a>';
									}
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

					}

				}

			}

		echo savon_html_output($output);

	}

}