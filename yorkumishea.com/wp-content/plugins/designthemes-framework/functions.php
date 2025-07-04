<?php
if( !function_exists('dt_framework_get_template_part') ) {
    function dt_framework_get_template_part( $root, $module, $template, $slug = '', $params = array() ) {

		$temp = $root . '/' . $module . '/' . $template;
		
		$template = dt_framework_get_template_with_slug( $temp, $slug );
		
		return dt_framework_execute_template_with_params( $template, $params );        
    }
}

if( !function_exists( 'dt_framework_get_template_with_slug' ) ) {

    function dt_framework_get_template_with_slug( $temp, $slug ) {
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
		
		return $template;        
    }
}

if( !function_exists('dt_framework_execute_template_with_params') ) {
    function dt_framework_execute_template_with_params( $template, $params ) {
		if ( ! empty( $template ) && file_exists( $template ) ) {
			//Extract params so they could be used in template
			if ( is_array( $params ) && count( $params ) ) {
				extract( $params );
			}
			
			ob_start();
			include( $template );
			$html = ob_get_clean();
			
			return $html;
		} else {
			return '';
		}        
    }
}