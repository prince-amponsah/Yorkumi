<?php
add_action( 'savon_after_main_css', 'sidebar_style' );
function sidebar_style() {
    wp_enqueue_style( 'savon-secondary', get_theme_file_uri('/modules/sidebar/assets/css/sidebar.css'), false, SAVON_THEME_VERSION, 'all');
}

if( !function_exists( 'savon_get_primary_classes' ) ) {
	function savon_get_primary_classes() {
		return apply_filters( 'savon_primary_classes', 'content-full-width' );
	}
}

if( !function_exists( 'savon_get_secondary_classes' ) ) {
	function savon_get_secondary_classes() {
		return apply_filters( 'savon_secondary_classes', '' );
	}
}

if( !function_exists( 'savon_get_active_sidebars' ) ) {
	function savon_get_active_sidebars() {
		return apply_filters( 'savon_active_sidebars', [ 'name' => esc_html__( 'Main Sidebar', 'savon' ), 'id' => 'sidebar-main'] );
	}
}

add_action( 'widgets_init', 'savon_theme_sidebars' );
function savon_theme_sidebars() {
	$sidebars = apply_filters( 'savon_active_sidebars', [ 'name' => esc_html__( 'Main Sidebar', 'savon' ), 'id' => 'sidebar-main'] );

	if( !empty( $sidebars ) && ( ! class_exists( 'DesignThemesFrameworkWidgetArea' ) ) ){
		register_sidebar( $sidebars );
	}
}

$active_sidebars = savon_get_active_sidebars();
foreach( $active_sidebars as $active_sidebar ) {
	if( is_active_sidebar( $active_sidebar ) && ( ! class_exists( 'DesignThemesFrameworkWidgetArea' ) ) ) {
		add_filter( 'savon_primary_classes', function() { return 'page-with-sidebar with-right-sidebar'; } );
		add_filter( 'savon_secondary_classes', function() { return 'secondary-sidebar secondary-has-right-sidebar'; } );
	}
}