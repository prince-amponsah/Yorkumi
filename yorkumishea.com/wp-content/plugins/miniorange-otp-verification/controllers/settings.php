<?php
/**
 * Controller for settings
 *
 * @package miniorange-otp-verification/controller
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\Tabs;
use OTP\Helper\PremiumFeatureList;
use OTP\Objects\TabDetails;

$page_list = admin_url() . 'edit.php?post_type=page';
$plan_type = MoUtility::micv() ? 'wp_otp_verification_upgrade_plan' : 'wp_otp_verification_basic_plan';

$nonce           = $admin_handler->get_nonce_value();
$moaction        = add_query_arg(
	array(
		'page' => $tab_details->tab_details[ Tabs::FORMS ]->menu_slug,
		'form' => 'configured_forms#configured_forms',
	)
);
$forms_list_page = add_query_arg(
	'page',
	$tab_details->tab_details[ Tabs::FORMS ]->menu_slug . '#form_search',
	remove_query_arg( array( 'form' ) )
);

$form_name             = isset( $_GET['form'] ) ? sanitize_text_field( wp_unslash( $_GET['form'] ) ) : false;  // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.NonceVerification.Recommended -- Reading GET parameter for checking the Form name, doesn't require nonce verification.
$show_configured_forms = 'configured_forms' === $form_name;

$otp_settings_tab = $tab_details->tab_details[ Tabs::OTP_SETTINGS ];
$otp_settings     = $otp_settings_tab->url;

$add_on_tab = $tab_details->tab_details[ Tabs::ADD_ONS ];
$addon      = $add_on_tab->url;

$premium_feature_list           = PremiumFeatureList::instance();
$both_email_and_phone_form_list = $premium_feature_list->get_both_email_phone_addon_forms();
$tab_details                    = TabDetails::instance();
$addon_tab                      = $tab_details->tab_details[ Tabs::ADD_ONS ];
$req_url                        = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ''; // phpcs:ignore -- false positive.
$addon_tab_url                  = add_query_arg( array( 'page' => $addon_tab->menu_slug ), $req_url );

$support = MoConstants::FEEDBACK_EMAIL;

require_once MOV_DIR . 'views/settings.php';
