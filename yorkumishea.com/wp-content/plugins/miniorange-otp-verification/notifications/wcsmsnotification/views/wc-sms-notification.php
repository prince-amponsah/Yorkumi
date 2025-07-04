<?php
/**
 * View file to show Customer SMS Notifications List
 *
 * @package miniorange-otp-verification/Notifications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Notifications\WcSMSNotification\Helper\MoWcAddOnUtility;


	echo '			<div id="MowcNotifSubTabContainer" class="mo-subpage-container ' . esc_attr( $wc_hidden ) . '">
						<form name="f" method="post" action="" id="mo_wc_sms_notif_settings">
							<input type="hidden" name="option" value="mo_wc_sms_notif_settings" />';
							wp_nonce_field( $nonce );
	echo '					<div class="mo-header">
								<p class="mo-heading flex-1">' . esc_html( mo_( 'WooCommerce SMS Notification Settings' ) ) . '</p>
								<u><i><a href="https://plugins.miniorange.com/how-to-configure-woocommerece-sms-notification" 
									target="_blank"
									class="font-bold flex items-center gap-mo-1 pr-mo-4">
									<span>
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none">
											<path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M2.25 19.5C2.25 19.0858 2.58579 18.75 3 18.75C5.02623 18.75 6.60313 18.8757 8.07234 19.2764C9.41499 19.6426 10.6314 20.2283 12 21.1041C13.3686 20.2283 14.585 19.6426 15.9277 19.2764C17.3969 18.8757 18.9738 18.75 21 18.75C21.4142 18.75 21.75 19.0858 21.75 19.5C21.75 19.9142 21.4142 20.25 21 20.25C19.0262 20.25 17.6031 20.3743 16.3223 20.7236C15.0494 21.0707 13.8738 21.6522 12.416 22.624C12.1641 22.792 11.8359 22.792 11.584 22.624C10.1262 21.6522 8.95056 21.0707 7.67766 20.7236C6.39687 20.3743 4.97377 20.25 3 20.25C2.58579 20.25 2.25 19.9142 2.25 19.5Z" fill="#22272F"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M21.9462 1.25L22 1.25C22.4142 1.25 22.75 1.58579 22.75 2V12.6571V12.6866C22.75 13.2123 22.75 13.6501 22.722 14.0072C22.6928 14.3786 22.6298 14.728 22.4671 15.0585C22.2126 15.5753 21.8306 15.9751 21.3258 16.2528C20.9986 16.4329 20.6396 16.5109 20.2578 16.5568C19.8861 16.6016 19.4236 16.6226 18.8626 16.6482L18.8339 16.6495C16.4047 16.76 14.701 17.1552 12.4056 18.6309C12.1585 18.7897 11.8415 18.7897 11.5944 18.6309C9.29896 17.1552 7.59527 16.76 5.16613 16.6495L5.13741 16.6482C4.57637 16.6226 4.11388 16.6016 3.74223 16.5568C3.3604 16.5109 3.00136 16.4329 2.67415 16.2528C2.16945 15.9751 1.78743 15.5753 1.53292 15.0585C1.37018 14.728 1.30718 14.3786 1.27802 14.0072C1.24998 13.6501 1.24999 13.2122 1.25 12.6866L1.25 12.6571V2C1.25 1.80109 1.32902 1.61032 1.46967 1.46967C1.61032 1.32902 1.80109 1.25 2 1.25L2.05378 1.25C4.23099 1.24998 5.95395 1.24997 7.54619 1.52913C9.05461 1.79359 10.4311 2.30412 12 3.25821C13.5689 2.30412 14.9454 1.79359 16.4538 1.52912C18.0461 1.24997 19.769 1.24998 21.9462 1.25ZM11.25 4.55773C9.8118 3.67896 8.60209 3.23713 7.28715 3.00659C6.00403 2.78163 4.60749 2.75388 2.75 2.75048V12.6571C2.75 13.2198 2.75054 13.5984 2.77342 13.8898C2.7957 14.1736 2.83559 14.3084 2.8786 14.3958C2.99728 14.6368 3.16199 14.8092 3.39734 14.9387C3.47818 14.9832 3.61591 15.0308 3.92156 15.0676C4.23108 15.1049 4.63737 15.1239 5.23434 15.151C7.46482 15.2526 9.21803 15.5917 11.25 16.6851V4.55773ZM12.75 16.6851C14.782 15.5917 16.5352 15.2526 18.7657 15.151C19.3626 15.1239 19.7689 15.1049 20.0784 15.0676C20.3841 15.0308 20.5218 14.9832 20.6027 14.9387C20.838 14.8092 21.0027 14.6368 21.1214 14.3958C21.1644 14.3084 21.2043 14.1736 21.2266 13.8898C21.2495 13.5984 21.25 13.2198 21.25 12.6571V2.75048C19.3925 2.75388 17.996 2.78163 16.7129 3.00659C15.3979 3.23713 14.1882 3.67896 12.75 4.55773V16.6851Z" fill="#22272F"/>
										</svg>
									</span>
									<span>Setup Guide</span>
								</a></i></u>
								<input type="submit" name="save" id="save" ' . esc_attr( $disabled ) . '
											class="mo-button inverted" value="' . esc_attr( mo_( 'Save Settings' ) ) . '">
							</div>
							<table class="mo-wcnotif-table bg-white">
								<thead>
									<tr>
										<th>SMS Type</th>
										<th>Recipient</th>
										<th></th>
										<th>SMS Body</th>			
									</tr>
								</thead>
								<tbody>';
									show_wc_notifications_table( $notification_settings );
	echo '						</tbody>
							</table>
						</form>
					</div>';
