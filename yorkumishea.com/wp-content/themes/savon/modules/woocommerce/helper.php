<?php

/**
 * WooCommerce Helper
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Woo_Helper' ) ) {

    class Dt_Woo_Helper {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

			// Utils

				include_once SAVON_MODULE_DIR . '/woocommerce/utils.php';


			// After theme setup

				add_action( 'savon_after_load_module_helpers', array ( $this, 'load_woo_module_support' ), 10 );


			// Main Content Section Setup

				// To Update Page Wrapper Start

					remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
					remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

					add_action( 'woocommerce_before_main_content', array ( $this, 'woo_output_content_wrapper' ), 11 );


				// To Update Page wrapper End

					remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

					add_action( 'woocommerce_after_main_content', array ( $this, 'woo_output_content_wrapper_end' ), 11 );


			// Bredcrumbs

				// Bredcrumb Title

					add_filter( 'savon_breadcrumb_title', array ( $this, 'breadcrumb_title_woo_module' ), 10, 1 );

				// Bredcrumb Breadcrumbs

					add_filter( 'savon_breadcrumbs', array ( $this, 'breadcrumbs_woo_module' ), 10, 1 );


			// Locate WooCommerce Template Files

				add_filter( 'woocommerce_locate_template', array ( $this, 'woocommerce_locate_template' ), 10, 3 );


			// Enqueue Files

				// Enqueue CSS Files

					add_action( 'savon_after_main_css', array ( $this, 'woo_after_main_css' ) );

				// Enqueue JS Files

					add_action( 'savon_after_enqueue_js', array ( $this, 'woo_after_main_js' ) );


			// Load Modules

				$this->woo_load_modules();


			// On Template Load

				add_action( 'template_redirect', array ( $this, 'woo_template_redirect' ), 10 );

        }

		/*
		* After theme setup
		*/
			function load_woo_module_support() {

				add_theme_support( 'woocommerce' );
				//add_theme_support( 'wc-product-gallery-zoom' );
				add_theme_support( 'wc-product-gallery-lightbox' );
				add_theme_support( 'wc-product-gallery-slider' );

				// To Remove Page Title
				add_filter( 'woocommerce_show_page_title', '__return_false' );

				// Disable WooCommerce Styles & Sidebar
				// add_filter( 'woocommerce_enqueue_styles', '__return_false' );
				remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

				// Defining Default Values
				add_theme_support( 'woocommerce', array(

					'thumbnail_image_width'         => 1000,
					'gallery_thumbnail_image_width' => 100,
					'single_image_width'            => 1000,

				) );
			}

		/*
		* Main Content Section Setup - To Update Page Wrapper Start
		*/
			function woo_output_content_wrapper() {

				?>
				<!-- ** Primary ** -->
					<section id="primary" class="<?php echo esc_attr( savon_get_primary_classes() ); ?>">

					<?php

			}

		/*
		* Main Content Section Setup - To Update Page Wrapper End
		*/
			function woo_output_content_wrapper_end() {

					if( is_shop() || is_product_category() || is_product_tag() ) {
						do_action( 'savon_woo_after_products_loop' );
					}

					?>

					</section><!-- ** Primary End ** -->

				<?php
				savon_template_part( 'sidebar', 'templates/sidebar' );

			}

		/*
		* Bredcrumbs - Bredcrumb Title
		*/
			function breadcrumb_title_woo_module( $title ) {

				if( is_shop() ) {

					if( get_option('woocommerce_shop_page_id') == '' ) {
						$title = '<h1>'.esc_html__('Shop', 'savon').'</h1>';
					} else {
						$title = '<h1>'.get_the_title( get_option('woocommerce_shop_page_id') ).'</h1>';
					}

				} else if( is_product() ) {

					$title = '<h1>'.esc_html__('Shop', 'savon').'</h1>';

				} else if( is_product_category() ) {

					$title = '<h1>'.single_term_title( '', false ).'</h1>';

				} else if( is_product_tag() ) {

					$title = '<h1>'.single_term_title( '', false ).'</h1>';

				}

				return $title;

			}

		/*
		* Bredcrumbs - Bredcrumb Breadcrumbs
		*/
			function breadcrumbs_woo_module( $breadcrumbs ) {

				if( $shop_page_id = get_option('woocommerce_shop_page_id') ) {
					$shop_page_title = get_the_title( $shop_page_id );
					$shop_page_link  = get_the_permalink( $shop_page_id );
				} else {
					$shop_page_title = esc_html__('Shop', 'savon');
					$shop_page_link  = '#';
				}

				if( is_shop() ) {

					$breadcrumbs[] = '<span class="current">'.$shop_page_title.'</span>';

				} else if( is_product() ) {

					global $post;

					$terms = wc_get_product_terms(
						$post->ID,
						'product_cat',
						apply_filters(
							'woocommerce_breadcrumb_product_terms_args',
							array(
								'orderby' => 'parent',
								'order'   => 'DESC',
							)
						)
					);

					$breadcrumbs[] = isset($terms[0]) ? '<a href="'.get_term_link( $terms[0] ).'">'.$terms[0]->name.'</a>': '';
					$breadcrumbs[] = the_title( '<span class="current">', '</span>', false );

				} else if( is_product_category() ) {

					$breadcrumbs[] = '<a href="' . $shop_page_link . '">' . $shop_page_title . '</a>';
					$breadcrumbs[] = '<span class="current">'.single_term_title( '', false ).'</span>';

				} else if( is_product_tag() ) {

					$breadcrumbs[] = '<a href="' . $shop_page_link . '">' . $shop_page_title . '</a>';
					$breadcrumbs[] = '<span class="current">'.single_term_title( '', false ).'</span>';

				}

				return $breadcrumbs;

			}

		/*
		* Locate WooCommerce Template Files
		*/
			function woocommerce_locate_template( $template, $template_name, $template_path ) {

				global $woocommerce;

				$_template = $template;

				if ( ! $template_path ) $template_path = $woocommerce->template_url;

				$plugin_path  = SAVON_MODULE_DIR . '/woocommerce/templates/';

				// Look within passed path within the theme - this is priority
				$template = locate_template(
					array(
						$template_path . $template_name,
						$template_name
					)
				);

				// Modification: Get the template from this plugin, if it exists
				if ( ! $template && file_exists( $plugin_path . $template_name ) )
				$template = $plugin_path . $template_name;

				// Use default template
				if ( ! $template )
				$template = $_template;

				// Return what we found
				return $template;

			}

		/*
		* Enqueue CSS Files
		*/
			function woo_after_main_css() {

				/* Before Hook */

					do_action( 'savon_before_woo_css' );

					wp_register_style( 'savon-woo', SAVON_MODULE_URI . '/woocommerce/assets/css/default.css', array (), SAVON_THEME_VERSION, 'all' );
					wp_enqueue_style( 'savon-woo' );

				/* Main CSS */
					global $post;

					if( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() || ( isset( $post->ID ) && get_option( 'yith_wcwl_wishlist_page_id' ) == $post->ID ) ) {

						/* General CSS */

							$css = '';

							// Load common styles
								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/common.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$css .= "\n\n".ob_get_clean();

								}

							// Carousel Styles
								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/carousel.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$css .= "\n\n".ob_get_clean();

								}

							// Filter for inline styles
								$css = apply_filters( 'savon_woo_css', $css );

							if( !empty($css) ) {
								wp_add_inline_style( 'savon-woo', $css );
							}

						/* Quick View CSS */

							if( is_shop() || is_product_category() || is_product_tag() ) {

								$qv_css = '';

								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/single/assets/css/common.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$qv_css .= "\n\n".ob_get_clean();

								}

								if( !empty($qv_css) ) {
									wp_add_inline_style( 'yith-quick-view', $qv_css );
								}

							}

						/* Archive CSS */

							wp_register_style( 'savon-woo-archive', '', array (), SAVON_THEME_VERSION, 'all' );
							wp_enqueue_style( 'savon-woo-archive' );

							// Filter for inline styles
								$css = apply_filters( 'savon_woo_archive_css', '' );

							if( !empty($css) ) {
								wp_add_inline_style( 'savon-woo-archive', $css );
							}

					}

				/* Others CSS */
					if( is_cart() || is_checkout() || is_account_page() || ( isset( $post->ID ) && get_option( 'yith_wcwl_wishlist_page_id' ) == $post->ID ) ) {

						/* General CSS */

							wp_register_style( 'savon-woo-others', '', array (), SAVON_THEME_VERSION, 'all' );
							wp_enqueue_style( 'savon-woo-others' );

							$css = '';

							// Load cart styles
							if( is_cart() ) {

								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/cart.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$css .= "\n\n".ob_get_clean();

								}

							}

							// Load checkout styles
							if( is_checkout() ) {

								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/checkout.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$css .= "\n\n".ob_get_clean();

								}

							}

							// Load my account styles
							if( is_account_page() ) {

								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/myaccount.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$css .= "\n\n".ob_get_clean();

								}

							}

							// Load wishlist styles
							if( ( isset( $post->ID ) && get_option( 'yith_wcwl_wishlist_page_id' ) == $post->ID ) ) {

								$css_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/css/wishlist.css';

								if( file_exists ( $css_file_path ) ) {

									ob_start();
									include( $css_file_path );
									$css .= "\n\n".ob_get_clean();

								}

							}


							// Filter for inline styles
							$css = apply_filters( 'savon_woo_others_css', $css );

							if( !empty($css) ) {
								wp_add_inline_style( 'savon-woo-others', $css );
							}

					}

				/* After Hook */

					do_action( 'savon_after_woo_css' );

			}

		/*
		* Enqueue JS Files
		*/
			function woo_after_main_js() {

				/* Before Hook */

					do_action( 'savon_before_woo_js' );

				/* Main JS */

					if( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() ) {

						/* General JS */

							wp_register_script( 'savon-woo', '', array ('jquery'), false, true );
							wp_enqueue_script( 'savon-woo' );

							// JS Variables
								$woo_objects = apply_filters( 'savon_woo_objects', array (
									'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
								) );
								wp_localize_script('savon-woo', 'dtshopObjects', $woo_objects);

							$js = '';

							// Load common js
								$js_file_path = SAVON_MODULE_DIR . '/woocommerce/assets/js/common.js';

								if( file_exists ( $js_file_path ) ) {

									ob_start();
									include( $js_file_path );
									$js .= "\n\n".ob_get_clean();

								}

							// Inline JS Scripts
								$js = apply_filters( 'savon_woo_js', $js );

								if( !empty($js) ) {
									wp_add_inline_script( 'savon-woo', $js );
								}


						/* Archive JS */

							wp_register_script( 'savon-woo-archive', '', array ('jquery'), false, true );
							wp_enqueue_script( 'savon-woo-archive' );

							$js = apply_filters( 'savon_woo_archive_js', '' );

							if( !empty($js) ) {
								wp_add_inline_script( 'savon-woo-archive', $js );
							}

					}

				/* After Hook */

					do_action( 'savon_after_woo_js' );

			}

		/*
		* Load Modules
		*/
			function woo_load_modules() {

				/* Load Listing Helpers */

					include_once SAVON_MODULE_DIR. '/woocommerce/listings/index.php';


				/* Template Pages */

					include_once SAVON_MODULE_DIR. '/woocommerce/shop/index.php';
					include_once SAVON_MODULE_DIR. '/woocommerce/category/index.php';
					include_once SAVON_MODULE_DIR. '/woocommerce/tag/index.php';

				/* Product Single */

					include_once SAVON_MODULE_DIR. '/woocommerce/single/index.php';

				/* Others */

					include_once SAVON_MODULE_DIR. '/woocommerce/others/index.php';

			}

		/*
		* On Template Load
		*/
			function woo_template_redirect() {

				$sub_modules = array ();

				if( is_shop() || is_product_category() || is_product_tag() ) {

					/* Load Other Modules */
					$sub_modules = array (
						'sorter'   => 'listings/sorter/index',
						'includes' => 'listings/includes/index'
					);

				}

				if( is_product() ) {

					/* Load Other Modules */
					$sub_modules = array (
						'includes' => 'listings/includes/index'
					);

				}

				if( is_array( $sub_modules ) && !empty( $sub_modules ) ) {
					foreach( $sub_modules as $sub_module ) {

						if( $file_content = savon_woo_locate_file( $sub_module ) ) {
							include_once $file_content;
						}

					}
				}

			}

    }

}


if( !function_exists('dt_woo_helper') ) {
	function dt_woo_helper() {
		if ( class_exists( 'WooCommerce' ) ) {
			return Dt_Woo_Helper::instance();
		}
	}
}

dt_woo_helper();