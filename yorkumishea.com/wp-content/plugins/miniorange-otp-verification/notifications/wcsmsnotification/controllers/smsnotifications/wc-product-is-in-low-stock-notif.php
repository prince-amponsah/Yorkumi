<?php
/**
 * Load view for Low Stock Admin SMS Notification
 *
 * @package miniorange-otp-verification/Notifications
 */

use OTP\Helper\MoUtility;
use OTP\Helper\MoMessages;
use OTP\Notifications\WcSMSNotification\Helper\WooCommerceNotificationsList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$notification_settings = get_wc_option( 'notification_settings_option' );
$notification_settings = $notification_settings ? maybe_unserialize( $notification_settings )
												: WooCommerceNotificationsList::instance();

$sms_settings       = $notification_settings->get_wc_product_low_stock_notif();
$enable_disable_tag = $sms_settings->page;
$textarea_tag       = $sms_settings->page . '_smsbody';
$variable_tag       = $sms_settings->page . '_sms_tags';
$template_name      = $sms_settings->page . '_template_name';
$recipient_tag      = $sms_settings->page . '_recipient';
$recipient_value    = maybe_unserialize( $sms_settings->recipient );
$recipient_value    = is_array( $recipient_value ) ? implode( ';', $recipient_value ) : $recipient_value;
$enable_disable     = $sms_settings->is_enabled ? 'checked' : '';

require MSN_DIR . '/views/smsnotifications/wc-admin-sms-template.php';
