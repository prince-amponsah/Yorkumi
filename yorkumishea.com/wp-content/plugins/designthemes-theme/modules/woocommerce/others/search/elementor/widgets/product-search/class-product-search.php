<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTShop_Widget_Product_Search extends Widget_Base {

	public function get_categories() {
		return [ 'dtshop-widgets' ];
	}

	public function get_name() {
		return 'dt-shop-product-search';
	}

	public function get_title() {
		return esc_html__( 'Product Search', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array( 'dtshop-product-search' );
	}

	protected function register_controls() {


		$tpl_args = array (
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'tpl-product-search-listing.php',
			'suppress_filters' => 0
		);
		$product_search_tpl_posts = get_posts($tpl_args);

		$product_search_tpls = array ();
		if(is_array($product_search_tpl_posts) && !empty($product_search_tpl_posts)) {
			foreach($product_search_tpl_posts as $product_search_tpl_post) {
				$product_search_tpls[$product_search_tpl_post->ID] = $product_search_tpl_post->post_title;
			}
		}

		$this->start_controls_section( 'product_search_section', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		) );

			$this->add_control( 'show_categories', array(
				'label'       => esc_html__( 'Show Categories', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Show categories dropdown to search.', 'designthemes-theme' ),
				'options'     => array(
					'false' => esc_html__('False', 'designthemes-theme'),
					'true' => esc_html__('True', 'designthemes-theme')
				),
				'default'     => 'true',
			) );

			$this->add_control( 'textfield_label', array(
				'label'       => esc_html__( 'Textfield Label', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can change textfield label here.', 'designthemes-theme' ),
				'default'     => ''
			) );

			$this->add_control( 'search_template', array(
				'label'       => esc_html__( 'Search Template', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose product search result template that you would like to use. If you haven\'t created any create page by choosing "Product Search Result Template".', 'designthemes-theme' ),
				'options'     => $product_search_tpls
			) );

			$this->add_control( 'class', array(
				'label'       => esc_html__( 'Class', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'designthemes-theme' ),
				'default'     => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		$output .= '<div class="dt-sc-shop-product-search-container">';

			$output .= '<form class="dtshopSearchForm" action="'.get_permalink($settings['search_template']).'" method="post">';

				if(isset($settings['show_categories']) && $settings['show_categories'] == 'true') {

					$dtshop_search_categories = array ();
					if(isset($_REQUEST['dtshop_search_categories'])) {
						if(is_array($_REQUEST['dtshop_search_categories']) && !empty($_REQUEST['dtshop_search_categories'])) {
							$dtshop_search_categories = $_REQUEST['dtshop_search_categories'];
						} else if($_REQUEST['dtshop_search_categories'] != '') {
							$dtshop_search_categories = explode(',', $_REQUEST['dtshop_search_categories']);
						}
					}

					$mulitple_attr = '';
					$mulitple_name = 'dtshop_search_categories';
					if(isset($settings['categories_multiple_dropdown']) && $settings['categories_multiple_dropdown'] == 'true') {
						$mulitple_attr = 'multiple';
						$mulitple_name = 'dtshop_search_categories[]';
					}

					$output .= '<div class="dt-sc-shop-product-search-item">';

						$cat_args = array (
							'taxonomy'   => 'product_cat',
							'hide_empty' => 1
						);
						$categories = get_categories($cat_args);

						if( is_array($categories) && !empty($categories) ) {

							$output .= '<select class="dtshop-search-field dtshop-search-categories-field dtshop-chosen-select" name="'.$mulitple_name.'" data-placeholder="'.esc_html__('Choose Categories', 'designthemes-theme').'" '.esc_attr($mulitple_attr).'>';

								if($mulitple_attr == '') {
									$output .= '<option value="">'.esc_html__('Choose Categories', 'designthemes-theme').'</option>';
								}

								foreach( $categories as $category ) {

									$selected_attr = '';
									if(in_array($category->term_id, $dtshop_search_categories)) {
										$selected_attr = 'selected="selected"';
									}
									$output .= '<option value="'.esc_attr($category->term_id).'" '.$selected_attr.'>'.esc_html($category->name).'</option>';

								}

							$output .= '</select>';

						}

					$output .= '</div>';

				}

				$output .= '<div class="dt-sc-shop-product-search-item-holder">';

					$output .= '<div class="dt-sc-shop-product-search-item">';

						$textfield_label = esc_html__('Keyword', 'designthemes-theme');
						if($settings['textfield_label'] != '') {
							$textfield_label = esc_html($settings['textfield_label']);
						}

						$dtshop_search_keyword = '';
						if(isset($_REQUEST['dtshop_search_keyword']) && $_REQUEST['dtshop_search_keyword'] != '') {
							$dtshop_search_keyword = $_REQUEST['dtshop_search_keyword'];
						}

						$output .= '<input name="dtshop_search_keyword" class="dtshop-search-field dtshop-search-keyword-field" type="text" value="'.esc_attr($dtshop_search_keyword).'" placeholder="'.esc_attr($textfield_label).'" />';

					$output .= '</div>';

					$output .= '<div class="dt-sc-shop-product-search-item">';

						$output .= '<input name="dtshop_search_submit" class="dtshop-search-field dtshop-search-submit-field" type="submit" value="'.esc_html__('Submit', 'designthemes-theme').'" />';

						$output .= '<input type="hidden" name="dtshop_product_search_nonce" value="'.wp_create_nonce('dtshop_product_search').'" />';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</form>';

		$output .= '</div>';

		echo savon_html_output($output);

	}

}