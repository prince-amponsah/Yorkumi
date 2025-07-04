<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;

abstract class DTElementorWidgetBase extends Widget_Base {
	/**
	 * Get categories
	 */

	public function get_categories() {
		return [ 'dt-widgets' ];
	}

	public function dt_post_categories(){
		$terms = get_terms( array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
		));

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
		}

		return $options;
	}

	public function dt_get_elementor_page_list(){
		$pagelist = get_posts(array(
			'post_type' => 'elementor_library',
			'showposts' => 999,
		));

		if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
			foreach ( $pagelist as $post ) {
				$options[ $post->ID ] = esc_html__( $post->post_title, 'designthemes-theme' );
			}
	        return $options;
		}
	}

}