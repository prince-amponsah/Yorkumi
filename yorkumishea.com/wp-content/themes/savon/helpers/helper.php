<?php
if ( ! function_exists( 'savon_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 */
	function savon_template_part( $module, $template, $slug = '', $params = array() ) {
		echo savon_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'savon_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 */
	function savon_get_template_part( $module, $template, $slug = '', $params = array() ) {

		$p_template = apply_filters( 'savon_get_template_plugin_part', '', $module, $template, $slug);

		if( empty( $p_template ) ) {

			$html          = '';
			$template_path = SAVON_MODULE_DIR . '/' . $module;
			
			$temp = $template_path . '/' . $template;
			
			$template = '';
			
			if ( ! empty( $temp ) ) {
				if ( ! empty( $slug ) ) {
					$template = "{$temp}-{$slug}.php";
					
					if ( ! file_exists( $template ) ) {
						$template = $temp . '.php';
					}
				} else {
					$template = $temp . '.php';
				}
			}
		} else {
			$template = $p_template;
		}

		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}

		if ( $template && file_exists( $template ) ) {
			ob_start();			
			include( $template );
			$html = ob_get_clean();
		}

		return $html;
	}
}

if ( ! function_exists( 'savon_get_page_id' ) ) {
	function savon_get_page_id() {

		$page_id = get_queried_object_id();

		if( is_archive() || is_search() || is_404() || ( is_front_page() && is_home() ) ) {
			$page_id = -1;
		}

		return $page_id;
	}
}