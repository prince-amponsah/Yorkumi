<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;

class Elementor_Header_Icons extends DTElementorWidgetBase {

	public function get_name() {
		return 'dt-header-icons';
	}

	public function get_title() {
		return esc_html__( 'Header Icons', 'designthemes-theme' );
	}

	public function get_style_depends() {
		return array( 'dt-header-icons', 'dt-header-carticons' );
	}

	public function get_script_depends() {
		return array( 'jquery-nicescroll', 'dt-header-icons' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'header_icons_general_section', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		) );

			$this->add_control( 'show_search_icon', array(
				'label'        => esc_html__( 'Show Search Icon', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'search_type', array(
				'label'       => esc_html__( 'Search Type', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose type of search form to use.', 'designthemes-theme'),
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Default', 'designthemes-theme'),
					'expand' => esc_html__( 'Expand', 'designthemes-theme' ),
					'overlay' => esc_html__( 'Overlay', 'designthemes-theme' )
				),
				'condition' => array( 'show_search_icon' => 'yes' )
			) );

			$this->add_control( 'show_userauthlink_icon', array(
				'label'        => esc_html__( 'Show Login / Logout Icon', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'show_cart_icon', array(
				'label'        => esc_html__( 'Show Cart Icon', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'cart_action', array(
				'label'       => esc_html__( 'Cart Action', 'designthemes-theme' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose how you want to display the cart content.', 'designthemes-theme'),
				'default'     => '',
				'options'     => array(
					''                    => esc_html__( 'None', 'designthemes-theme'),
					'notification_widget' => esc_html__( 'Notification Widget', 'designthemes-theme' ),
					'sidebar_widget'      => esc_html__( 'Sidebar Widget', 'designthemes-theme' ),
				),
				'condition' => array( 'show_cart_icon' => 'yes' )
	        ) );

			$this->add_control( 'show_wishlist_icon', array(
				'label'        => esc_html__( 'Show Wishlist Icon', 'designthemes-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

            $this->add_responsive_control( 'align', array(
                'label'        => esc_html__( 'Alignment', 'designthemes-theme' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','designthemes-theme'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','designthemes-theme'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','designthemes-theme'), 'icon' => 'eicon-h-align-right' ),
                ),
            ) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if( ( function_exists( 'is_woocommerce' ) && $settings['show_cart_icon'] == 'yes' ) || $settings['show_userauthlink_icon'] == 'yes' || $settings['show_search_icon'] == 'yes' ) {

			$output .= '<div class="dt-sc-header-icons-list">';

			if( $settings['show_search_icon'] == 'yes' ) {

				if( $settings['search_type'] == 'expand' ) {
					$output .= '<div class="dt-sc-header-icons-list-item search-item search-expand">';
				}elseif( $settings['search_type'] == 'overlay' ) {
					$output .= '<div class="dt-sc-header-icons-list-item search-item search-overlay">';
				} else {
					$output .= '<div class="dt-sc-header-icons-list-item search-item search-default">';
				}

					$output .= '<div class="dt-sc-search-menu-icon">';

						$output .= '<a href="javascript:void(0)" class="dt-sc-search-icon"><i class="dticon-search"></i></a>';

						if( $settings['search_type'] == 'expand' || $settings['search_type'] == 'overlay' ) {

							$output .= '<div class="dt-sc-search-form-container">';

								ob_start();
								get_search_form();
								$output .= ob_get_clean();

								$output .= '<div class="dt-sc-search-form-close"></div>';

							$output .= '</div>';

						} else {

							$output .= '<div class="dt-sc-search-form-container">';

								ob_start();
								get_search_form();
								$output .= ob_get_clean();

							$output .= '</div>';

						}

					$output .= '</div>';

				$output .= '</div>';

			}

			if( $settings['show_userauthlink_icon'] == 'yes' ) {

				$output .= '<div class="dt-sc-header-icons-list-item user-authlink-item">';

					if (is_user_logged_in()) {

						$current_user = wp_get_current_user();
						$user_info = get_userdata($current_user->ID);

						$output .= '<div class="dt-user-authlink-menu-icon">';
							$output .= '<a href="'.wp_logout_url().'"><span>'.get_avatar( $current_user->ID, 150).'<span class="icotype-label">'.esc_html__('Log Out', 'designthemes-theme').'</span></span></a>';
						$output .= '</div>';

					} else {
						$output .= '<div class="dt-user-authlink-menu-icon">';
							$output .= '<a href="'.wp_login_url(get_permalink()).'"><span><i class="dticon-user"></i><span class="icotype-label">'.esc_html__('Log In', 'designthemes-theme').'</span></span></a>';
						$output .= '</div>';
					}

				$output .= '</div>';

			}

			if( function_exists( 'is_woocommerce' ) && $settings['show_cart_icon'] == 'yes' ) {

				$output .= '<div class="dt-sc-header-icons-list-item cart-item">';

					$output .= '<div class="dt-sc-shop-menu-icon">';

						$output .= '<a href="'.esc_url( wc_get_cart_url() ).'">';
							$output .= '<span class="dt-sc-shop-menu-icon-wrapper">';
								$output .= '<span class="dt-sc-shop-menu-cart-inner">';
									$output .= '<span class="dt-sc-shop-menu-cart-icon"></span>';
									$output .= '<span class="dt-sc-shop-menu-cart-number">0</span>';
								$output .= '</span>';
								$output .= '<span class="dt-sc-shop-menu-cart-totals"></span>';
							$output .= '</span>';
						$output .= '</a>';

						if($settings['cart_action'] == 'notification_widget') {

							$output .= '<div class="dt-sc-shop-menu-cart-content-wrapper">';
								$output .= '<div class="dt-sc-shop-menu-cart-content">'.esc_html__('No products added!', 'designthemes-theme').'</div>';
							$output .= '</div>';

							set_site_transient( 'cart_action', 'notification_widget', 12 * HOUR_IN_SECONDS );

						} else if($settings['cart_action'] == 'sidebar_widget') {

							set_site_transient( 'cart_action', 'sidebar_widget', 12 * HOUR_IN_SECONDS );

						} else {

							set_site_transient( 'cart_action', 'none', 12 * HOUR_IN_SECONDS );

						}

					$output .= '</div>';

				$output .= '</div>';

			}

			if( $settings['show_wishlist_icon'] == 'yes' ) {

				if(class_exists('YITH_WCWL')) {

					$count = YITH_WCWL()->count_all_products();

					$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );

					$output .= '<div class="dt-sc-header-icons-list-item wishlist-item">';

						$output .= '<div class="dt-sc-wishlist-menu-icon">';
							$output .= '<a href="'.get_permalink($wishlist_page_id).'">';
								$output .= '<span>';
									$output .= '<i class="dticon-heart"></i>';
									$output .= '<span class="icotype-label">'.esc_html__('Wishlist', 'designthemes-theme').'</span>';
									$output .= '<span class="dt-sc-wishlist-count"> '.$count.'</span>';
								$output .= '</span>';
							$output .= '</a>';
						$output .= '</div>';

					$output .= '</div>';

				}

			}

			$output .= '</div>';

		}

		echo $output;

	}

}
