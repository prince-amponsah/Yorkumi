<?php if ( !defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'wcsms_get_option' ) ) {
	/**
	 * @param $name
	 * @param $section
	 * @param array|string $default
	 *
	 * @return mixed
	 */
	function wcsms_get_option( $name, $section, $default = '' ) {
		$option = get_option( $section );

		if ( isset( $option[ $name ] ) ) {
			return $option[ $name ];
		}

		return $default;
	}
}

if ( ! function_exists( 'wcsms_save_selected_users' ) ) {
	/**
	 * @param $section
	 * @param array|string $default
	 *
	 * @return mixed
	 */
	function wcsms_save_selected_users( $value ) {
		$updated_option = update_option( 'wcsms_enable_bulksms_on_users', $value );
		$get_option = get_option( 'bulksms_settings' );
		$get_option['wcsms_enable_bulksms_on_users'] = $value;
		$update_get_option = update_option( 'bulksms_settings', $get_option );
		return $updated_option && $update_get_option;
	}
}

if ( ! function_exists( 'wcsms_add_actions' ) ) {
	/**
	 * @param array $hook_actions
	 */
	function wcsms_add_actions( $hook_actions ) {
		foreach ( $hook_actions as $hook ) {
			add_action( $hook['hook'], $hook['function_to_be_called'] );
		}
	}
}
