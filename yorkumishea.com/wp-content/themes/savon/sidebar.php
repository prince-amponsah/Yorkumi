<?php 
$active_sidebars = savon_get_active_sidebars();

foreach( $active_sidebars as $active_sidebar ) {
	if( is_active_sidebar( $active_sidebar ) ) {
    	dynamic_sidebar( $active_sidebar );    	
    }
}