<?php if ( !defined( 'ABSPATH' ) ) { exit; }

$message = esc_html( $message );
$phone_no = esc_html( $phone_no );
$twilio_account_sid = esc_html( wcsms_get_option( 'wcsms_twilio_account_sid', 'wcsms_settings', '' ) );
$twilio_auth_token = esc_html( wcsms_get_option( 'wcsms_twilio_auth_token', 'wcsms_settings', '' ) );
$twilio_phone_no  = esc_html( wcsms_get_option( 'wcsms_twilio_phone_number', 'wcsms_settings', '') );

if ( $twilio_account_sid && $twilio_auth_token && $twilio_phone_no ) {
    // $this->wcsms_update_logs('Attempting to send SMS to ' . $phone_no . ', message: ' . $message );
    try {
        // $twilio = new Client( $twilio_account_sid, $twilio_auth_token );
        // $twilio_response = $twilio->messages->create(
        // 	$this->plus_on_phone_number( $phone_no ), array( 'mediaUrl' => $mediaUrl, 'from' => $twilio_phone_no,
        // 	'body' => wp_kses_post( "$message\n" . sprintf( __("Reply %s to stop alerts", WCSMS_PLUGIN_SLUG), 'STOP' ) )
        // 	) );

        $body = array(
            'Body' => wp_kses_post( "$message\n" . sprintf( __("Reply %s to stop alerts", WCSMS_PLUGIN_SLUG), 'STOP' ) ),
            'To' => $this->plus_on_phone_number( $phone_no ),
            'From' => $twilio_phone_no,
        );
        $mediaUrl = wcsms_get_option( 'wcsms_bulk_sms_image', 'bulksms_settings', '' );
        if ( $isBulk && $mediaUrl ) { $body['MediaUrl'] = array($mediaUrl); }
        $args = array(
            'headers'     => array( 'Authorization' => 'Basic ' . base64_encode( "{$twilio_account_sid}:{$twilio_auth_token}" ) ),
            'body'        => $body,
            // 'timeout'     => '45',
        );

        $twilio_response = wp_remote_post( "https://api.twilio.com/2010-04-01/Accounts/{$twilio_account_sid}/Messages.json", $args );
        if ( ! is_wp_error( $twilio_response ) ) {
            // $response_code = wp_remote_retrieve_response_code( $twilio_response );
            $response_message = wp_remote_retrieve_response_message( $twilio_response );
            $response = wp_remote_retrieve_body( $twilio_response );
            $sms = json_decode( $response, true );
            // echo '<pre>'; print_r($sms); echo '</pre>';

            /*
                {
                    "body": "MESSAGE",
                    "num_segments": "1",
                    "direction": "outbound-api",
                    "from": "+1***",
                    "date_updated": "Tue, 15 Aug 2023 20:30:53 +0000",
                    "price": null,
                    "error_message": null,
                    "uri": "/2010-04-01/Accounts/AC***sdfd/Messages/SM***sdf.json",
                    "account_sid": "AC***sdf",
                    "num_media": "0",
                    "to": "+1***",
                    "date_created": "Tue, 15 Aug 2023 20:30:53 +0000",
                    "status": "queued",
                    "sid": "SM***sdf",
                    "date_sent": null,
                    "messaging_service_sid": null,
                    "error_code": null,
                    "price_unit": "USD",
                    "api_version": "2010-04-01",
                    "subresource_uris": {
                        "media": "/2010-04-01/Accounts/AC***sdf/Messages/SM***sdf/Media.json"
                    }
                }
                Array
                (
                    [account_sid] => asdfasd5***asdf
                    [api_version] => 2010-04-01
                    [body] => Test : Celebrate
                Reply STOP to stop alerts
                    [date_created] => Thu, 11 Sep 2024 20:00:15 +0000
                    [date_sent] =>
                    [date_updated] => Thu, 11 Sep 2024 20:00:15 +0000
                    [direction] => outbound-api
                    [error_code] =>
                    [error_message] =>
                    [from] => +13545345345
                    [messaging_service_sid] =>
                    [num_media] => 0
                    [num_segments] => 1
                    [price] =>
                    [price_unit] => USD
                    [sid] => sms****daf
                    [status] => queued
                    [subresource_uris] => Array
                        (
                            [media] => /2010-04-01/Accounts/asdfasd5***asdf/Messages/sms****daf/Media.json
                        )

                    [to] => +654848
                    [uri] => /2010-04-01/Accounts/sdv8494884/Messages/sms****daf.json
                )

                OR

                Array
                (
                    [code] => 21211
                    [message] => Invalid 'To' Phone Number: +1987123XXXX
                    [more_info] => https://www.twilio.com/docs/errors/21211
                    [status] => 400
                )
            */
            $status = $sms['status'];
            if ($status === 'queued') {
                $twilio_code = $sms['error_code'];
                $twilio_message = $sms['error_message'];
            } else {
                $twilio_code = $sms['code'];
                $twilio_message = $sms['message'];
            }
            if ( !empty($twilio_code) ) {
                echo '<pre>'; print_r($sms); echo '</pre>';
                echo "<span style='color:red'>Error {$twilio_code}: {$twilio_message}</span><br>";
            } else if ( !empty($sms) && $status === 'queued' ) {
                if (!empty($sms['date_sent'])) {
                    echo "{$sms['status']}: {$sms['from']} --> {$sms['to']} sent on {$sms['date_sent']} SID: <a href='https://console.twilio.com/us1/monitor/logs/sms?frameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2FSMb362468bd5977e10ed1a8ef4d9fc4aca%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1&currentFrameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2F{$sms['sid']}%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1' target='_blank'>{$sms['sid']}</a><br>";
                } else {
                    echo "{$sms['status']}: {$sms['from']} --> {$sms['to']}<br>";
                }
                echo "{$sms['body']}<br>";
            } else if ( !empty($sms) && $status !== 'queued' ) {
                echo '<pre>'; print_r($sms); echo '</pre>';
                echo "{$twilio_message}<br>";
            } else {
                echo "No messages found. {$response_message}<br>";
                // // { "errors": [
                // // 		{
                // // 			"code": "REFUND_AMOUNT_INVALID",
                // // 			"detail": "The requested refund amount exceeds the amount available to refund.",
                // // 			"field": "amount_money.amount",
                // // 			"category": "REFUND_ERROR"
                // // 		}
                // // 	] }
                // $errors_result = $sms['errors'];
                // if ( !empty($errors_result) ) {
                //     $error_list = "<ul>";
                //     foreach ($errors_result as $error) {
                //         $error_list .= '<li>' . $error['category'] . ' ' . $error['code'] . ': ' . $error['detail'] . ' - ' . $error['field'] . '</li>';
                //         // $error_list .= '<li>' . $error['code'] . ': ' . $error['detail'] . '</li>';
                //     }
                //     $error_list .= '</ul>';
                // } else {
                //    echo "<p>{$response_message}</p>";
                // }
            }
            echo '<br>';
            if($isBulk) { echo( "-> SMS queued for $phone_no. SMS response: $response_message\n$response" ); }
            $this->wcsms_update_logs( "-> SMS queued for $phone_no. SMS response: $response_message\n$response" );
        } else {
            $error_message = $twilio_response->get_error_message();
            echo "❌ Something went wrong. {$error_message}<br>";
            // throw new Exception( $error_message );
            if($isBulk) { echo( "- ❌ ERROR: SMS queued for $phone_no. SMS response: $error_message" ); }
            $this->wcsms_update_logs( "- ❌ ERROR: SMS queued for $phone_no. SMS response: $error_message" );
        }
    } catch ( Exception $e ) {
        if($isBulk) { echo('- ❌ <span style="color:red; font-weight: bolder;">error</span> Failed to send SMS to ' . $phone_no . ', error: ' . $e->getMessage() ); }
        $this->wcsms_update_logs('- ❌ Failed to send SMS to ' . $phone_no . ', error: ' . $e->getMessage() );
    }
} else {
    $this->wcsms_update_logs('❌ Twilio account SID, Auth Token or Twilio phone number is not set.' );
    // wp_die( 'Twilio account SID, Auth Token or Twilio phone number is not set in your Woocommerce SMS PRO plugin. <a href="' . admin_url( 'admin.php?page=wcsms-settings' ) . '" class="button button-secondary">' . __( 'Go Back', WCSMS_PLUGIN_SLUG ) . '</a>' );
}