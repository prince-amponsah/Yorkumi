<?php

/**
 * Listing Sorter
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Listing_Sorter' ) ) {

    class Dt_Woo_Listing_Sorter {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Remove Actions */
                $this->remove_actions();

            /* Add Actions */
                $this->add_actions();

            /* Pagination Args Update */
                add_filter( 'woocommerce_pagination_args', array ( $this, 'woocommerce_pagination_args' ) );

            /* Sorter CSS */
                add_filter( 'savon_woo_archive_css', array( $this, 'woo_sorter_css'), 10, 1 );

            /* Sorter js */
                add_filter( 'savon_woo_archive_js', array( $this, 'woo_sorter_js'), 10, 1 );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/listings/sorter/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/listings/sorter/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Sorter Settings
        */
            function woo_sorter_settings() {

                $settings = apply_filters( 'savon_woo_sorter_settings', array () );

                return $settings;

            }

        /*
        Remove Actions
        */
            function remove_actions() {

                /** archive-product.php hooks - woocommerce_before_shop_loop, woocommerce_after_shop_loop **/

                    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
                    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
                    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

                    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

            }

        /*
        Add Actions
        */
            function add_actions() {

                add_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 1);

                add_action( 'woocommerce_before_shop_loop', array ( $this, 'product_list_sorter_settings' ), 5 );

            }

        /*
        Product List - Sorter Settings
        */
            function product_list_sorter_settings() {

                $this->product_sorter_on_header(); /* Header Sorter  */
                $this->product_sorter_on_footer(); /* Footer Sorter  */

            }


        /*
        Product List - Header Sorter Settings
        */

            function product_sorter_on_header() {

                /* Get Settings */
                    $settings = $this->woo_sorter_settings();
                    extract( $settings );

                /* Render Settings */
                    if($show_sorter_on_header) {

                        if(!empty($sorter_header_elements)) {

                            add_action( 'woocommerce_before_shop_loop', array ( $this, 'woo_sorting_wrapper' ), 9 );

                            $total_items = count($sorter_header_elements);
                            $i = 10; $j = 1;
                            foreach($sorter_header_elements as $sorter_header_element_key) {

                                $sorter_function_name = '';
                                if($sorter_header_element_key == 'filter') {
                                    $sorter_function_name = 'woocommerce_catalog_ordering';
                                } else if($sorter_header_element_key == 'result_count') {
                                    $sorter_function_name = 'woocommerce_result_count';
                                } else if($sorter_header_element_key == 'pagination') {
                                    $sorter_function_name = 'woocommerce_pagination';
                                } else if($sorter_header_element_key == 'display_mode_options') {
                                    $sorter_function_name = array ( $this, 'woo_display_mode_options' );
                                } else if($sorter_header_element_key == 'display_mode') {
                                    $sorter_function_name = array ( $this, 'woo_display_mode' );
                                }

                                $cnt = 0;
                                if($total_items > 2 && $j == 2) {
                                    add_action('woocommerce_before_shop_loop', array ( $this, 'woo_sorter_center_item_start_div' ), $i);
                                    $i = $i+1;
                                }

                                add_action('woocommerce_before_shop_loop', array ( $this, 'woo_sorter_item_start_div' ), ($i));
                                add_action('woocommerce_before_shop_loop', $sorter_function_name, ($i+1));
                                add_action('woocommerce_before_shop_loop', array ( $this, 'woo_sorter_item_end_div' ), ($i+2));

                                if($total_items > 2 && $j == ($total_items-1)) {
                                    add_action('woocommerce_before_shop_loop', array ( $this, 'woo_sorter_center_item_end_div' ), ($i+3));
                                    $i = $i+1;
                                }

                                $i = $i+3;
                                $j++;

                            }

                            add_action( 'woocommerce_before_shop_loop', array ( $this, 'woo_sorting_wrapper_close' ), 51 );

                        }

                    }

            }

        /*
        Product List - Footer Sorter Settings
        */

            function product_sorter_on_footer() {

                /* Get Settings */
                    $settings = $this->woo_sorter_settings();
                    extract( $settings );

                /* Render Settings */
                    if($show_sorter_on_footer) {

                        if(!empty($sorter_footer_elements)) {

                            add_action( 'woocommerce_after_shop_loop', array ( $this, 'woo_sorting_wrapper' ), 9 );

                            $total_items = count($sorter_footer_elements);
                            $i = 10; $j = 1;
                            foreach($sorter_footer_elements as $sorter_footer_element_key) {

                                $sorter_function_name = '';
                                if($sorter_footer_element_key == 'filter') {
                                    $sorter_function_name = 'woocommerce_catalog_ordering';
                                } else if($sorter_footer_element_key == 'result_count') {
                                    $sorter_function_name = 'woocommerce_result_count';
                                } else if($sorter_footer_element_key == 'pagination') {
                                    $sorter_function_name = 'woocommerce_pagination';
                                } else if($sorter_footer_element_key == 'display_mode_options') {
                                    $sorter_function_name = array ( $this, 'woo_display_mode_options' );
                                } else if($sorter_footer_element_key == 'display_mode') {
                                    $sorter_function_name = array ( $this, 'woo_display_mode' );
                                }

                                $cnt = 0;
                                if($total_items > 2 && $j == 2) {
                                    add_action('woocommerce_after_shop_loop', array ( $this, 'woo_sorter_center_item_start_div' ), $i);
                                    $i = $i+1;
                                }

                                add_action('woocommerce_after_shop_loop', array ( $this, 'woo_sorter_item_start_div' ), $i);
                                add_action('woocommerce_after_shop_loop', $sorter_function_name, ($i+1));
                                add_action('woocommerce_after_shop_loop', array ( $this, 'woo_sorter_item_end_div' ), ($i+2));

                                if($total_items > 2 && $j == ($total_items-1)) {
                                    add_action('woocommerce_after_shop_loop', array ( $this, 'woo_sorter_center_item_end_div' ), ($i+3));
                                    $i = $i+1;
                                }

                                $i = $i+3;
                                $j++;

                            }

                            add_action( 'woocommerce_after_shop_loop', array ( $this, 'woo_sorting_wrapper_close' ), 51 );

                        }

                    }

            }

        /*
        Sorter Elements
        */

            function woo_sorting_wrapper() {
                echo '<div class="product-loop-sorting">';
            }

            function woo_sorting_wrapper_close() {
                echo '</div>';
            }

            function woo_sorter_item_start_div() {
                echo '<div class="product-loop-sorting-item">';
            }

            function woo_sorter_item_end_div() {
                echo '</div>';
            }

            function woo_sorter_center_item_start_div() {
                echo '<div class="product-loop-sorting-item-group">';
            }

            function woo_sorter_center_item_end_div() {
                echo '</div>';
            }

            function woo_display_mode_options() {

                $shop_page_display = get_option( 'woocommerce_shop_page_display' );

                if( is_shop() && ( $shop_page_display == 'subcategories' ) ) {
                    return;
                }

                if( is_shop() || is_product_category() || is_product_tag() ) {

                    $grid_controller_class = $list_controller_class = '';

                    $display_mode = wc_get_loop_prop( 'product-display-type', 'grid' );
                    $display_mode = (isset($display_mode) && !empty($display_mode)) ? $display_mode : 'grid';

                    if($display_mode == 'list') {
                        $grid_controller_class = 'hidden';
                    } else {
                        $list_controller_class = 'hidden';
                    }

                    $column = apply_filters( 'loop_shop_columns', 4 );

                    $one_column_class = $two_column_class = $three_column_class = $four_column_class = $five_column_class = $six_column_class = '';

                    if($column == 1) {
                        $one_column_class = 'active';
                    } else if($column == 2) {
                        $two_column_class = 'active';
                    } else if($column == 3) {
                        $three_column_class = 'active';
                    } else if($column == 4) {
                        $four_column_class = 'active';
                    } else if($column == 5) {
                        $five_column_class = 'active';
                    } else if($column == 6) {
                        $six_column_class = 'active';
                    }

                    echo '<div class="product-layout-controller '.esc_attr($grid_controller_class).'">';
                        echo '<ul class="product-change-layout">';
                            echo '<li class="hidden"><span data-column="1" class="'.esc_attr($one_column_class).'">'.esc_html__('1', 'savon').'</span></li>';
                            echo '<li><span data-column="2" class="'.esc_attr($two_column_class).'">'.esc_html__('2', 'savon').'</span></li>';
                            echo '<li><span data-column="3" class="'.esc_attr($three_column_class).'">'.esc_html__('3', 'savon').'</span></li>';
                            echo '<li><span data-column="4" class="'.esc_attr($four_column_class).'">'.esc_html__('4', 'savon').'</span></li>';
                        echo '</ul>';
                    echo '</div>';


                    $display_mode_list_option = wc_get_loop_prop( 'product-display-type-list-option', 'left-thumb' );
                    $display_mode_list_option = (isset($display_mode_list_option) && !empty($display_mode_list_option)) ? $display_mode_list_option : 'left-thumb';

                    $left_thumb_class = $right_thumb_class = '';
                    if($display_mode_list_option == 'right-thumb') {
                        $right_thumb_class = 'active';
                    } else {
                        $left_thumb_class = 'active';
                    }

                    echo '<div class="product-list-options-controller '.esc_attr($list_controller_class).'">';
                        echo '<ul class="product-list-options">';
                            echo '<li><span data-list-option="left-thumb" class="'.esc_attr($left_thumb_class).'">'.esc_html__('Left Thumb', 'savon').'</span></li>';
                            echo '<li><span data-list-option="right-thumb" class="'.esc_attr($right_thumb_class).'">'.esc_html__('Right Thumb', 'savon').'</span></li>';
                        echo '</ul>';
                    echo '</div>';

                }

            }

            function woo_display_mode() {

                $shop_page_display = get_option( 'woocommerce_shop_page_display' );

                if( is_shop() && ( $shop_page_display == 'subcategories' ) ) {
                    return;
                }

                if( is_shop() || is_product_category() || is_product_tag() ) {

                    $display_mode = wc_get_loop_prop( 'product-display-type', 'grid' );
                    $display_mode = (isset($display_mode) && !empty($display_mode)) ? $display_mode : 'grid';

                    if($display_mode == 'list') {
                        $grid_display_mode_class = '';
                        $list_display_mode_class = 'active';
                    } else {
                        $grid_display_mode_class = 'active';
                        $list_display_mode_class = '';
                    }

                    echo '<div class="product-display-controller">';
                        echo '<ul class="product-change-display">';
                            echo '<li><span data-display="grid" class="'.esc_attr($grid_display_mode_class).'">'.esc_html__('Grid', 'savon').'</span></li>';
                            echo '<li><span data-display="list" class="'.esc_attr($list_display_mode_class).'">'.esc_html__('List', 'savon').'</span></li>';
                        echo '</ul>';
                    echo '</div>';

                }

            }

            function woocommerce_pagination_args( $output ){

                $output = array(
                    'prev_text' => '<i class="dticon-angle-double-left"></i>',
                    'next_text' => '<i class="dticon-angle-double-right"></i>',
                    'type'      => 'list',
                );

                return $output;
            }


        /*
        Sorter Skin CSS
        */
            function woo_sorter_skin_css() {

                $css = '';
                return $css;

            }

        /*
        Sorter CSS
        */

            function woo_sorter_css( $css ) {

                $css_file_path = $this->module_dir_path() . 'assets/css/sorter.css';

                if( file_exists ( $css_file_path ) ) {

                    ob_start();
                    include( $css_file_path );
                    $css .= "\n\n".ob_get_clean();

                }

                $css .= "\n\n".$this->woo_sorter_skin_css();

                return $css;

            }

        /*
        Sorter JS
        */

            function woo_sorter_js( $js ) {

                $js_file_path = $this->module_dir_path() . 'assets/js/sorter.js';

                if( file_exists ( $js_file_path ) ) {

                    ob_start();
                    include( $js_file_path );
                    $js .= "\n\n".ob_get_clean();

                }

                return $js;

            }


    }

}


if( !function_exists('dt_woo_listing_sorter') ) {
	function dt_woo_listing_sorter() {
		return Dt_Woo_Listing_Sorter::instance();
	}
}

dt_woo_listing_sorter();