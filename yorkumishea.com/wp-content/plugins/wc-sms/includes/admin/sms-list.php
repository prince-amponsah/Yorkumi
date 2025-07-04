<?php if ( !defined( 'ABSPATH' ) ) { exit; }

// use Twilio\Rest\Client;

_e('<div class="wrap">');

echo '<h1>' . sprintf( __( 'Most recent %s', WCSMS_PLUGIN_SLUG ), $GLOBALS['title'] ) . '</h1>';

$twilio_account_sid = esc_html( wcsms_get_option( 'wcsms_twilio_account_sid', 'wcsms_settings', '' ) );
$twilio_auth_token = esc_html( wcsms_get_option( 'wcsms_twilio_auth_token', 'wcsms_settings', '' ) );
$twilio_phone_no  = esc_html( wcsms_get_option( 'wcsms_twilio_phone_number', 'wcsms_settings', '') );

if ( $twilio_account_sid && $twilio_auth_token && $twilio_phone_no ) {
    try {
        // $twilio = new Client( $twilio_account_sid, $twilio_auth_token );
        // $list = $twilio->messages->read([
        // //   "dateSentAfter" => new \DateTime('2021-01-15T01:23:45Z'),
        // //   "dateSentBefore" => new \DateTime('2021-01-17T01:23:45Z')
        // ], 1000);
        // foreach ($list as $sms) {
        //     // echo '<pre>'; print_r($sms); echo '</pre>';
        //     if ($sms->dateSent) {
        //         echo "$sms->status: $sms->from --> $sms->to sent on " . $sms->dateSent->format('F d, Y') . " SID: <a href='https://console.twilio.com/us1/monitor/logs/sms?frameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2FSMb362468bd5977e10ed1a8ef4d9fc4aca%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1&currentFrameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2F$sms->sid%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1' target='_blank'>$sms->sid</a><br>";
        //     } else {
        //         echo "$sms->status: $sms->from --> $sms->to<br>";
        //     }
        //     if ($sms->errorMessage) echo "<span style='color:red'>Error $sms->errorCode: $sms->errorMessage</span><br>";
        //     echo "$sms->body<br>";
        //     echo '<br>';
        // }

        $args = array(
            'headers'     => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode( "{$twilio_account_sid}:{$twilio_auth_token}" ),
            ),
            // 'timeout'     => '45',
        );
        $twilio_response = wp_remote_get( "https://api.twilio.com/2010-04-01/Accounts/{$twilio_account_sid}/Messages.json?From={$twilio_phone_no}&PageSize=100", $args );
        if ( ! is_wp_error( $twilio_response ) ) {
            // $response_code = wp_remote_retrieve_response_code( $twilio_response );
            $response_message = wp_remote_retrieve_response_message( $twilio_response );
            $response = wp_remote_retrieve_body( $twilio_response );
            $result = json_decode( $response, true );
            // // echo '<pre>'; print_r($result); echo '</pre>';
            // {
            //     "first_page_uri": "/2010-04-01/Accounts/AC***/Messages.json?PageSize=2&Page=0",
            //     "end": 1,
            //     "previous_page_uri": null,
            //     "messages": [
            //         {
            //             "body": "MESSAGE",
            //             "num_segments": "5",
            //             "direction": "outbound-api",
            //             "from": "+1***",
            //             "date_updated": "Tue, 15 Aug 2023 07:33:29 +0000",
            //             "price": "-0.03950",
            //             "error_message": null,
            //             "uri": "/2010-04-01/Accounts/AC***/Messages/SM***.json",
            //             "account_sid": "AC***",
            //             "num_media": "0",
            //             "to": "+1***",
            //             "date_created": "Tue, 15 Aug 2023 07:33:28 +0000",
            //             "status": "undelivered",
            //             "sid": "SM***",
            //             "date_sent": "Tue, 15 Aug 2023 07:33:29 +0000",
            //             "messaging_service_sid": "MG***",
            //             "error_code": 30034,
            //             "price_unit": "USD",
            //             "api_version": "2010-04-01",
            //             "subresource_uris": {
            //                 "media": "/2010-04-01/Accounts/AC***/Messages/SM***/Media.json",
            //                 "feedback": "/2010-04-01/Accounts/AC***/Messages/SM***/Feedback.json"
            //             }
            //         },
            //         {
            //             "body": "MESSAGE",
            //             "num_segments": "1",
            //             "direction": "outbound-api",
            //             "from": "+1***",
            //             "date_updated": "Tue, 15 Aug 2023 06:57:38 +0000",
            //             "price": "-0.00790",
            //             "error_message": null,
            //             "uri": "/2010-04-01/Accounts/AC***/Messages/SM***.json",
            //             "account_sid": "AC***",
            //             "num_media": "0",
            //             "to": "+1***",
            //             "date_created": "Tue, 15 Aug 2023 06:57:37 +0000",
            //             "status": "delivered",
            //             "sid": "SM***",
            //             "date_sent": "Tue, 15 Aug 2023 06:57:37 +0000",
            //             "messaging_service_sid": "MG***",
            //             "error_code": null,
            //             "price_unit": "USD",
            //             "api_version": "2010-04-01",
            //             "subresource_uris": {
            //                 "media": "/2010-04-01/Accounts/AC***/Messages/SM***/Media.json",
            //                 "feedback": "/2010-04-01/Accounts/AC***/Messages/SM***/Feedback.json"
            //             }
            //         }
            //     ],
            //     "uri": "/2010-04-01/Accounts/AC***/Messages.json?PageSize=2&Page=0",
            //     "page_size": 2,
            //     "start": 0,
            //     "next_page_uri": "/2010-04-01/Accounts/AC***/Messages.json?PageSize=2&Page=1&PageToken=PASM***",
            //     "page": 0
            // }
            $list = $result['messages'];
            if ( !empty($list) && is_array($list) ) {
                foreach ($list as $sms) {
                    // echo '<pre>'; print_r($sms); echo '</pre>';
					$status = $sms['status'];
					$error_code = $sms['error_code'];
					$error_message = $sms['error_message'];
					if ( !empty($error_code) ) {
                        echo "<span style='color:red'>❌ Error {$error_code} {$sms['status']}: {$sms['from']} --> {$sms['to']} sent on {$sms['date_sent']} SID: <a href='https://console.twilio.com/us1/monitor/logs/sms?frameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2FSMb362468bd5977e10ed1a8ef4d9fc4aca%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1&currentFrameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2F{$sms['sid']}%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1' target='_blank'>{$sms['sid']}</a></span><br>";
                        // echo json_encode($sms);
						echo "{$sms['body']}<br>";
					} else if ( !empty($status) ) {
						// echo '<pre>'; print_r($sms); echo '</pre>';
						if (!empty($sms['date_sent'])) {
							echo "✔️ {$sms['status']}: {$sms['from']} --> {$sms['to']} sent on {$sms['date_sent']} SID: <a href='https://console.twilio.com/us1/monitor/logs/sms?frameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2FSMb362468bd5977e10ed1a8ef4d9fc4aca%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1&currentFrameUrl=%2Fconsole%2Fsms%2Flogs%2FAC***%2F{$sms['sid']}%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1' target='_blank'>{$sms['sid']}</a><br>";
						} else {
							echo "{$sms['status']}: {$sms['from']} --> {$sms['to']}<br>";
						}
						echo "{$sms['body']}<br>";
					} else {
						echo json_encode($sms) . "<br>";
                    }
                    echo '<br>';
                }
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
                // $errors_result = $result['errors'];
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
        } else {
            $error_message = $twilio_response->get_error_message();
            echo "Something went wrong. {$error_message}<br>";
            // throw new Exception( $error_message );
        }
    } catch ( Exception $e ) {
        echo '<p>No messages found due to error: ' . $e->getMessage() . '</p>';
    }
} else {
    echo '<p>No messages found. Missing Twilio Account SID & Twilio Auth Token</p>';
}

_e('</div>');