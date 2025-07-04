<?php if ( !defined( 'ABSPATH' ) ) { exit; }

// use Twilio\Rest\Client;

class WCSMS_WooCommerce_Notification {

	public function send_sms_woocommerce_order_status_pending( $order_id ) {
		$this->send_customer_notification( $order_id, "pending" );
		$this->send_admin_notification( $order_id, "pending" );
	}

	public function send_sms_woocommerce_order_status_failed( $order_id ) {
		$this->send_customer_notification( $order_id, "failed" );
		$this->send_admin_notification( $order_id, "failed" );
	}

	public function send_sms_woocommerce_order_status_on_hold( $order_id ) {
		$this->send_customer_notification( $order_id, "on-hold" );
		$this->send_admin_notification( $order_id, "on-hold" );
	}

	public function send_sms_woocommerce_order_status_processing( $order_id ) {
		$this->send_customer_notification( $order_id, "processing" );
		$this->send_admin_notification( $order_id, "processing" );
	}

	public function send_sms_woocommerce_order_status_completed( $order_id ) {
		$this->send_customer_notification( $order_id, "completed" );
		$this->send_admin_notification( $order_id, "completed" );
	}

	public function send_sms_woocommerce_order_status_refunded( $order_id ) {
		$this->send_customer_notification( $order_id, "refunded" );
		$this->send_admin_notification( $order_id, "refunded" );
	}

	public function send_sms_woocommerce_order_status_cancelled( $order_id ) {
		$this->send_customer_notification( $order_id, "cancelled" );
		$this->send_admin_notification( $order_id, "cancelled" );
	}

	public function send_sms_woocommerce_order_status_changed( $order_id, $old_status, $new_status ) {
		// $this->wcsms_update_logs('Order status changed": old status: ' . $old_status . ' , new status: ' . $new_status );
	}

	public function woocommerce_payment_complete( $order_id ) {
		// $this->wcsms_update_logs('Payment completed' );
	}

	public function woocommerce_payment_complete_order_status( $order_id ) {
		// $this->wcsms_update_logs('Completed order status' );
	}

	protected function wcsms_twilio_send( $phone_no, $message, $isBulk = false ) {
    	require_once WCSMS_PLUGIN_DIR . 'includes/functions/twilio-send.php';
	}

	public function send_customer_notification( $order_id = null, $status = null ) {
		$enable_customer_sms = wcsms_get_option( 'wcsms_customer_enable_send_sms', 'wcsms_settings', '' );
		if ( $enable_customer_sms == "on" ) {
			if ( ! in_array( $status, wcsms_get_option( 'wcsms_customer_send_sms_on', 'wcsms_settings', [] ) ) ) {
				return;
			}

			$order = new WC_Order( $order_id );
			$order_number = method_exists($order, 'get_order_number') ? $order->get_order_number() : $order_id;

			$message = wcsms_get_option( 'wcsms_customer_sms_template_' . $status, 'customer_settings', '' );
			if ( empty( $message ) ) {
			$message = wcsms_get_option( 'wcsms_customer_sms_template_default', 'customer_settings', '' );
			}
			if ( empty( $message ) ) { return; }

			$message      = $this->replace_order_keyword( $message, $order, 'customer', $status );

			// cashapp, venmo, zelle
			$amount = $order->get_total();
			$currency = $order->get_currency();
			// // $total = $order->get_total(); // contains html entities
			// $total = trim(str_replace("&#036;", "$", strip_tags($order->get_formatted_order_total())));
			$total = "$amount $currency";

			$domain = !empty(parse_url(get_bloginfo('url'))) ? parse_url(get_bloginfo('url'))['host'] : null;
			$note = "Order {$order_number} from $domain";
			if ($status == "on-hold" && $order->get_payment_method() == "cashapp") {
				$cashapp_settings = get_option( 'woocommerce_cashapp_settings' ) ? get_option( 'woocommerce_cashapp_settings' ) : get_option( 'woocommerce_cashapp-pro_settings' );
				$receiver = $cashapp_settings['ReceiverCashApp'];
				$url = 'https://cash.app/'. $receiver . '/' . $amount;
				$message .= "\n". sprintf( esc_html__("Please send the %s easily to Cash App by clicking this link", WCSMS_PLUGIN_SLUG ), $total ) . ": " . esc_url($url) . "\n" . sprintf(esc_html__("Use - %s - as the transaction note.", WCSMS_PLUGIN_SLUG ) , esc_html($note));
			} else if ($status == "on-hold" && $order->get_payment_method() == "venmo") {
				$venmo_settings = get_option( 'woocommerce_venmo_settings' ) ? get_option( 'woocommerce_venmo_settings' ) : get_option( 'woocommerce_venmo-pro_settings' );
				$receiver = $venmo_settings['ReceiverVenmo'];
				$url = 'https://venmo.com/'. $receiver . "?txn=pay&amount=" . $amount . "&note=" . urlencode( $note );
				$message .= "\n". sprintf( esc_html__("Please send the %s easily to Venmo by clicking this link", WCSMS_PLUGIN_SLUG ), $total ) . ": " . esc_url($url). "\n" . sprintf(esc_html__("Use - %s - as the transaction note.", WCSMS_PLUGIN_SLUG ) , esc_html($note));
			} else if ($status == "on-hold" && $order->get_payment_method() == "zelle") {
				$zelle_settings = get_option( 'woocommerce_zelle_settings' ) ? get_option( 'woocommerce_zelle_settings' ) : get_option( 'woocommerce_zelle-pro_settings' );
				$message .= "\n". sprintf( esc_html__( 'Here are the Zelle details you should know to complete the %s order', WCSMS_PLUGIN_SLUG ), $total ) . ': ';
				if ($zelle_settings['ReceiverZelleOwner']) {
					$message .= sprintf( esc_html__( '%s Name', WCSMS_PLUGIN_SLUG ), 'Zelle' ) . ': '. esc_html( $zelle_settings['ReceiverZelleOwner'] ). "\n";
				}
				if ($zelle_settings['ReceiverZELLEEmail']) {
					$message .= sprintf( esc_html__( '%s Email', WCSMS_PLUGIN_SLUG ), 'Zelle' ) . ': '. esc_html( $zelle_settings['ReceiverZELLEEmail'] ). "\n";
				}
				if ($zelle_settings['ReceiverZELLENo']) {
					$message .= sprintf( esc_html__( '%s Phone', WCSMS_PLUGIN_SLUG ), 'Zelle' ) . ': '. esc_html( $zelle_settings['ReceiverZELLENo'] ). ".";
				}
				$message .= "\n". sprintf( esc_html__("Use - %s - as the transaction note.", WCSMS_PLUGIN_SLUG ) , esc_html($note));
			} else if ($status == "on-hold" && $order->get_payment_method() == "momo") {
				$momo_settings = get_option( 'woocommerce_momo_settings' ) ? get_option( 'woocommerce_momo_settings' ) : get_option( 'woocommerce_momo-pro_settings' );
				$message .= "\n". sprintf( esc_html__( 'Here are the MOMO details you should know to complete the %s order', WCSMS_PLUGIN_SLUG ), $total ) . ': '.
					sprintf( esc_html__( '%s Name', WCSMS_PLUGIN_SLUG ), $momo_settings['title'] ) . ': '. esc_html( $momo_settings['ReceiverMOMONoOwner'] ). "\n".
					sprintf( esc_html__( '%s Email', WCSMS_PLUGIN_SLUG ), $momo_settings['title'] ) . ': '. esc_html( $momo_settings['ReceiverMOMOEmail'] ). "\n" .
					sprintf( esc_html__( '%s Phone', WCSMS_PLUGIN_SLUG ), $momo_settings['title'] ) . ': '. esc_html( $momo_settings['ReceiverMOMONo'] ). '. '. "\n" .
					sprintf( esc_html__("Use - %s - as the transaction note.", WCSMS_PLUGIN_SLUG ) , esc_html($note));
			}

			$customer_phone_no = $this->get_order_phone_number( $order );

			if ( empty($customer_phone_no) || $customer_phone_no == false || strlen($customer_phone_no) < 10 ) {
				$customer_phone_no = $order->get_billing_phone();
			}
			// $customer_phone_no = preg_replace('/^[0]/', '1', $customer_phone_no);
			if ( $order_id && $customer_phone_no && $message) {
				$this->send_sms( $order_id, $customer_phone_no, $message);
			}

		}
	}

	public function send_admin_notification( $order_id = null, $status = null ) {
		$enable_admin_sms = wcsms_get_option( 'wcsms_admin_enable_send_sms', 'wcsms_settings', '' );
		if ( $enable_admin_sms == "on" ) {
			//v1.1.18 add selection for sending admin notification on which status
			if ( ! in_array( $status, wcsms_get_option( 'wcsms_admin_send_sms_on', 'wcsms_settings', [] ) ) ) {
				return;
			}

			$order = new WC_Order( $order_id );
			$message    = wcsms_get_option( 'wcsms_admin_sms_template', 'admin_settings', '' );
			if ( empty( $message ) ) {
				$message = __( '[shop_name] : You have a new order with order ID [order_id] and order amount [order_currency] [order_amount]. The order is now [order_status].', WCSMS_PLUGIN_SLUG );
			}
			if ( empty( $message ) ) { return; }

			$message    = $this->replace_order_keyword( $message, $order, 'admin', $status );
			$admin_phone = trim( wcsms_get_option( 'wcsms_admin_sms_recipients', 'wcsms_settings', '' ) );
			//Get default country v1.1.17
			$admin_country = wcsms_get_option('wcsms_woocommerce_country_code', 'wcsms_settings', '' );

			//If multiple number, need to call check and get phone number multiple times
			if ( $admin_phone != '' ) {
				$phone_no_array = explode( ",", $admin_phone );
				foreach ( $phone_no_array as $number ) {
					if ( $number != '' ) {
						//Get default country v1.1.17
						$phone_with_country_code = $this->plus_on_phone_number($number, $admin_country);
						if ( $phone_with_country_code !== false ) {
							// $this->wcsms_update_logs('Admin\'s phone number (' . $number . ') in country (' . $admin_country . ') converted to ' . $phone_with_country_code );
						} else {
							$phone_with_country_code = $number;
						}
						$admin_phone_no = $this->phone_number_processing( $phone_with_country_code );
						$admin_phone_no = str_replace( ',', ' ', $admin_phone_no );
						if ( $order_id && $admin_phone_no && $message) {
							$this->send_sms( $order_id, $admin_phone_no, $message);
						}
					}
				}
			}
		}
	}

	public function send_sms( $order_id, $phone_no, $message) {
		$message = wp_kses_post( $message );
		$admin_phone = trim( wcsms_get_option( 'wcsms_admin_sms_recipients', 'wcsms_settings', '' ) );
		// $this->wcsms_log( 'Sending SMS message: ' . $message );

		$enable_reply_to_email = wcsms_get_option( 'wcsms_enable_reply_to_email', 'wcsms_settings', '' );
		if ($enable_reply_to_email == 'on') {
			$message .= "\n" . sprintf( esc_html__( 'To reply, contact %s', WCSMS_PLUGIN_SLUG ), esc_html( get_bloginfo( 'admin_email' ) ) );
		} else if ( $admin_phone != '' ) {
			$message .= "\n" . sprintf( esc_html__( 'To reply, contact %s', WCSMS_PLUGIN_SLUG ), esc_html( trim( $admin_phone ) ) );
		}

		$phone_no = esc_html( wp_kses_post( $phone_no ));
		if ( !$phone_no || !$message ) {
			echo('-> <span style="color:red; font-weight: bolder;">skipped</span>: Phone number: <strong>' . $phone_no . '</strong> or Message: <strong>' . $message . '</strong> missing');
			return;
		}
		// $this->wcsms_update_logs( "Sending SMS from: $admin_phone to: $phone_no --- message: $message" );


		$enable_default_phone = wcsms_get_option( 'wcsms_enable_assigned_phone_number', 'wcsms_settings', '' );
		if ( $enable_default_phone == 'off' ) {
			// $twilio_account_sid = esc_html( wcsms_get_option( 'wcsms_twilio_account_sid', 'wcsms_settings', '' ) );
			// $twilio_auth_token = esc_html( wcsms_get_option( 'wcsms_twilio_auth_token', 'wcsms_settings', '' ) );
			// $twilio_phone_no  = esc_html( wcsms_get_option( 'wcsms_twilio_phone_number', 'wcsms_settings', '') );

			// if ( $twilio_account_sid && $twilio_auth_token && $twilio_phone_no ) {
			// 	$this->wcsms_update_logs('Attempting to send SMS to ' . $phone_no . ', message: ' . $message );
			// 	try {
			// 		$twilio = new Client( $twilio_account_sid, $twilio_auth_token );
			// 		$twilio_response = $twilio->messages->create(
			// 			$this->plus_on_phone_number( $phone_no ), array( 'from' => $twilio_phone_no,
			// 			'body' => wp_kses_post( "$message\n" . sprintf( __("Reply %s to stop alerts", WCSMS_PLUGIN_SLUG), 'STOP' ) )
			// 			) );

			// 		$this->wcsms_update_logs('-> SMS Sent successfully to ' . $phone_no . ' SMS response from SMS gateway: ' . $twilio_response );
			// 	} catch ( Exception $e ) {
			// 		$this->wcsms_update_logs('-> Failed to send SMS to ' . $phone_no . ', error: ' . $e->getMessage() );
			// 	}
			// } else {
			// 	$this->wcsms_update_logs('Twilio account SID, Auth Token or Twilio phone number is not set.' );
			// 	// wp_die( 'Twilio account SID, Auth Token or Twilio phone number is not set in your Woocommerce SMS PRO plugin. <a href="' . admin_url( 'admin.php?page=wcsms-settings' ) . '" class="button button-secondary">' . __( 'Go Back', WCSMS_PLUGIN_SLUG ) . '</a>' );
			// }
			$this->wcsms_twilio_send( $phone_no, $message );
		} else {
			// $order_id = "10019325"; // 10019326, 10019327
			$order = new WC_Order( $order_id );
			// /cart/?order_again=
			// echo( get_site_url() . "/cart/?order_again=" . $order_id );

			$data = '{
				"phone_no":"' . $phone_no . '",
				"message":"' . urlencode($message) . '",
				"site":"' . urlencode(get_site_url()) . '",
				"order":"' . urlencode($order) . '"
			}';
			$url = 'https://api.theafricanboss.com/plugins/sms.php';

			// $this->wcsms_update_logs('Attempting to send SMS to ' . $phone_no . ', message: ' . $message );
			$twilio_response = wp_remote_post( $url, array(
				'method'      => 'POST',
				'timeout'     => 45,
				'sslverify' => false,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array( 'Content-Type: application/json' ),
				'body'        => $data,
				'cookies'     => array()
				)
			);

			// echo 'Response:<pre>';
			// print_r( $twilio_response );
			// echo '</pre>';
			// print_r( $twilio_response['body'] );
			// print_r( wp_remote_retrieve_body( $twilio_response ) );

			if ( !is_wp_error( $twilio_response ) && 200 === wp_remote_retrieve_response_code( $twilio_response ) ) {
				$this->wcsms_update_logs('-> SMS Sent successfully to ' . $phone_no );
			} else if ( !is_wp_error( $twilio_response ) && 200 !== wp_remote_retrieve_response_code( $twilio_response ) ) {
				$decoded_twilio_response = json_decode( wp_remote_retrieve_body( $twilio_response ), true );
				$twilio_error = $decoded_twilio_response->message;
				// echo "Something went wrong: $twilio_error";
				$this->wcsms_update_logs('-> Failed to send SMS to ' . $phone_no . ', error: ' . $twilio_error . $twilio_response['body'] );
			} else if ( is_wp_error( $twilio_response ) ) {
				$twilio_error = $twilio_response->get_error_message();
				// echo "Something went wrong: $twilio_error";
				$this->wcsms_update_logs('-> Failed to send SMS to ' . $phone_no . ', error: ' . $twilio_error . $twilio_response['body'] );
			} else {
				$this->wcsms_update_logs('-> Failed to send SMS to ' . $phone_no );
			}

		}
	}

	protected function replace_bulkmessage( $message, $customer ) {
		$domain = !empty(parse_url(get_bloginfo('url'))) ? parse_url(get_bloginfo('url'))['host'] : null;
		$search = [
			'[shop_name]',
			'[shop_email]',
			'[shop_url]',
			'[first_name]',
			'[last_name]',
			'[customer_first_name]',
			'[customer_last_name]',
			'[customer_phone]',
			'[customer_email]',
			'[customer_company]',
			'[customer_address]',
			'[customer_city]',
			'[customer_state]',
			'[customer_country]',
			'[customer_postcode]'
		];
		$replace = [
			get_bloginfo( 'name' ),
			get_bloginfo( 'admin_email' ),
			$domain,
			$customer->first_name,
			$customer->last_name,
			get_user_meta( $customer->ID, 'billing_first_name', true ),
			get_user_meta( $customer->ID, 'billing_last_name', true ),
			get_user_meta( $customer->ID, 'billing_phone', true ),
			get_user_meta( $customer->ID, 'billing_email', true ),
			get_user_meta( $customer->ID, 'billing_company', true ),
			get_user_meta( $customer->ID, 'billing_address_1', true ),
			get_user_meta( $customer->ID, 'billing_city', true ),
			get_user_meta( $customer->ID, 'billing_state', true ),
			get_user_meta( $customer->ID, 'billing_country', true ),
			get_user_meta( $customer->ID, 'billing_postcode', true )
		];

		$message = str_replace( $search, $replace, $message );

		return wp_kses_post( $message );
	}

	protected function replace_customer_bulkmessage( $template_message, $order_id ) {
		$order = new WC_Order( $order_id );
		$order_number = method_exists($order, 'get_order_number') ? $order->get_order_number() : $order_id;

		$data  = $order->get_data();

		$items      = $order->get_items();
		$product_names   = '';
		$products_with_qty = '';
		foreach ( $items as $item ) {
			$product_names   .= ', ' . $item->get_name();
			$products_with_qty .= ', ' . $item->get_name() . ' X ' . $item->get_quantity();
		}
		if ( $product_names ) {
			$product_names   = substr( $product_names, 2 );
			$products_with_qty = substr( $products_with_qty, 2 );
		}

		$amount = $order->get_total();
		$currency = $order->get_currency();
		// $total = $order->get_total();
		// $total = $order->get_formatted_order_total();
		$total = "$amount $currency";

		$domain = !empty(parse_url(get_bloginfo('url'))) ? parse_url(get_bloginfo('url'))['host'] : null;
		$note = "Order {$order_number} from $domain";
		if ($order->get_payment_method() == 'cashapp') {
			$cashapp_settings = get_option( 'woocommerce_cashapp_settings' ) ? get_option( 'woocommerce_cashapp_settings' ) : get_option( 'woocommerce_cashapp-pro_settings' );
			$receiver = $cashapp_settings['ReceiverCashApp'];
			$payment_url = 'https://cash.app/'. $receiver . '/' . $amount;
		} else if ($order->get_payment_method() == 'venmo') {
			$venmo_settings = get_option( 'woocommerce_venmo_settings' ) ? get_option( 'woocommerce_venmo_settings' ) : get_option( 'woocommerce_venmo-pro_settings' );
			$receiver = $venmo_settings['ReceiverVenmo'];
			$payment_url = 'https://venmo.com/'. $receiver . "?txn=pay&amount=" . $amount . "&note=" . urlencode( $note );
		} else if ($order->get_payment_method() == 'zelle') {
			$zelle_settings = get_option( 'woocommerce_zelle_settings' ) ? get_option( 'woocommerce_zelle_settings' ) : get_option( 'woocommerce_zelle-pro_settings' );
			$payment_url = esc_html__( '. Send Zelle payment to', WCSMS_PLUGIN_SLUG ) . ': ';
			if ($zelle_settings['ReceiverZelleOwner']) {
				$payment_url .= sprintf( esc_html__( '%s Name', WCSMS_PLUGIN_SLUG ), 'Zelle' ) . ': '. esc_html( $zelle_settings['ReceiverZelleOwner'] ). " ";
			}
			if ($zelle_settings['ReceiverZELLEEmail']) {
				$payment_url .= sprintf( esc_html__( '%s Email', WCSMS_PLUGIN_SLUG ), 'Zelle' ) . ': '. esc_html( $zelle_settings['ReceiverZELLEEmail'] ). " ";
			}
			if ($zelle_settings['ReceiverZELLENo']) {
				$payment_url .= sprintf( esc_html__( '%s Phone', WCSMS_PLUGIN_SLUG ), 'Zelle' ) . ': '. esc_html( $zelle_settings['ReceiverZELLENo'] ). ".";
			}
		} else {
			$payment_url = $order->get_checkout_payment_url();
		}

		$search = [
			'[shop_name]',
			'[shop_email]',
			'[shop_url]',
			'[first_name]',
			'[last_name]',
			'[customer_first_name]',
			'[customer_last_name]',
			'[customer_phone]',
			'[customer_email]',
			'[customer_company]',
			'[customer_address]',
			'[customer_city]',
			'[customer_state]',
			'[customer_country]',
			'[customer_postcode]',
			'[order_id]',
			'[order_number]',
			'[order_amount]',
			'[order_currency]',
			'[order_status]',
			'[order_shipping_method]',
			'[order_payment_method]',
			'[order_items]',
			'[order_items_with_qty]',
			'[order_items_count]',
			'[order_date]',
			'[order_url]',
			'[order_cancel_url]',
			'[order_payment_url]',
		];
		$replace = [
			get_bloginfo( 'name' ),
			get_bloginfo( 'admin_email' ),
			$domain,
			$order->get_billing_first_name(),
			$order->get_billing_last_name(),
			$order->get_billing_first_name(),
			$order->get_billing_last_name(),
			$order->get_billing_phone(),
			$order->get_billing_email(),
			$order->get_billing_company(),
			$order->get_billing_address_1(),
			$order->get_billing_city(),
			$order->get_billing_state(),
			$order->get_billing_country(),
			$order->get_billing_postcode(),
			$order_id,
			$order_number,
			$order->get_total(),
			$order->get_currency(),
			$order->get_status(),
			$order->get_shipping_method(),
			$order->get_payment_method_title(),
			$product_names,
			$products_with_qty,
			count($items),
			$order->get_date_created()->date( 'm-d-Y' ),
			$order->get_checkout_order_received_url(), // Generates a URL to view an order
			$order->get_cancel_order_url(), // Generates a URL so that a customer can cancel their (unpaid - pending) order.
			$payment_url, // Generates a URL so that a customer can pay for their (unpaid - pending) order
		];

		$message = str_replace( $search, $replace, $template_message );

		return wp_kses_post( $message );
	}

	public function send_bulksms_notification() {
		$message    = wcsms_get_option( 'wcsms_bulk_sms_template', 'bulksms_settings', '' );
		$user_role    = wcsms_get_option( 'wcsms_enable_bulksms_on_user_roles', 'bulksms_settings', '' );
		if ( empty( $message ) || empty( $user_role ) ) {
			return;
		}

		$user_ids_array    = wcsms_get_option( 'wcsms_enable_bulksms_on_users', 'bulksms_settings', '' );
		// print_r( $user_ids_array );
		$users_array = get_users( array( 'role' => $user_role ) );
		// $users_array = get_users( "&role= $user_role");

		$enable_email = wcsms_get_option( 'wcsms_enable_bulksms_with_email', 'bulksms_settings', '' );
		// ini_set('max_execution_time', 0);
		set_time_limit(0);
		// ini_set('display_errors', '1');


		if ( ! empty( $user_ids_array ) ) {
			$limit = wcsms_get_option( 'wcsms_bulk_sms_limit', 'bulksms_settings', '' );
			if ( $user_role == 'customer' ) {
				echo '<h1>Bulk SMS/Emails status</h1>';
				$count = 1;
				global $wpdb;
				foreach ( $user_ids_array as $g_order_id ) {
					unset($user_ids_array[$g_order_id]);
					wcsms_save_selected_users( $user_ids_array );

					$order_id = null;
					$user_id = null;
					$user_first_name = null;
					$user_last_name  = null;
					$user_email  = null;
					$user_phone_no  = null;

					if ( substr( $g_order_id, 0, 1 ) == 'g' ) {
						$order_id = esc_html(substr( $g_order_id, 1 ));
						echo '<p>--- Order #' . $order_id . ' ---</p>';
						$user_first_name = $wpdb->get_row($wpdb->prepare("SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_first_name'", $order_id))->meta_value;
						$user_last_name = $wpdb->get_row($wpdb->prepare("SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_last_name'", $order_id))->meta_value;
						$user_email = $wpdb->get_row($wpdb->prepare("SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_email'", $order_id))->meta_value;
						$user_phone_no = $wpdb->get_row($wpdb->prepare("SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_phone'", $order_id))->meta_value;
					} else {
						$user_id = $g_order_id;
						$customer_info = get_userdata( $user_id );
						if ( ! empty( get_user_meta( $user_id, 'billing_phone', true ) ) ) {
							$user_phone_no = get_user_meta( $user_id, 'billing_phone', true );
						} else if ( ! empty( $customer_info->user_phone ) || ! empty( $customer_info->phone ) ) {
							$user_phone_no = $customer_info->user_phone ? $customer_info->user_phone : $customer_info->phone;
						}
						if ( ! empty( get_user_meta( $user_id, 'billing_email', true ) ) ) {
							$user_email = get_user_meta( $user_id, 'billing_email', true );
						} else if ( ! empty( $customer_info->user_email ) || ! empty( $customer_info->email ) ) {
							$user_email = $customer_info->user_email ? $customer_info->user_email : $customer_info->email;
						}
						$user_first_name = get_user_meta( $user_id, 'billing_first_name', true );
						$user_last_name  = get_user_meta( $user_id, 'billing_last_name', true );
					}

					if ( $enable_email == 'on' ) {
						if ( $user_email == '' || $message == '' ) {
							echo '<p>' . $count . ". " . esc_html( $user_first_name ) . " ". esc_html( $user_last_name ) . ": <span style='color:red; font-weight: bolder;'>error</span> Missing <strong>email {$user_email}</strong> or <strong>message {$message}</strong> to send. Skipping sending email";
						} else {
							echo '<p>' . $count . ". " . esc_html( $user_first_name ) . " ". esc_html( $user_last_name ) . ': <strong>' . $user_email .'</strong> ';
							if ($user_email && $message && $user_first_name ) {
								if ( $order_id ) {
									$this->send_bulkemail($user_email, $this->replace_customer_bulkmessage( $message, $order_id ), esc_html( $user_first_name ));
								} else if ($customer_info ) {
										$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $customer_info ), esc_html( $user_first_name ));
								}
							}
							echo '</p>';
						}
					}

                    if ( ! $user_phone_no ) {
						echo '<p>' . $count . ". " . esc_html( $user_first_name ) . " ". esc_html( $user_last_name ) .
						': <span style="color:red; font-weight: bolder;">error</span> <strong>No phone number found. Skipping SMS and sending email instead</strong> ';
						if ($user_email && $message && $user_first_name ) {
							if ( $order_id ) {
								$this->send_bulkemail($user_email, $this->replace_customer_bulkmessage( $message, $order_id ), esc_html( $user_first_name ));
							} else if ($customer_info ) {
									$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $customer_info ), esc_html( $user_first_name ));
							}
						}
					} else {
						echo '<p>' . $count . ". " . esc_html( $user_first_name ) . " ". esc_html( $user_last_name ) .
						': <strong>' . $user_phone_no .'</strong> ';

						$user_phone_no = $this->phone_number_processing( $user_phone_no );
						if ( $user_phone_no == '' || $message == '' ) {
							echo ' <span style="color:red; font-weight: bolder;">error</span> <strong>Missing phone number or message to send. Skipping SMS and sending email instead</strong>';
							if ($user_email && $message && $user_first_name ) {
								if ( $order_id ) {
									$this->send_bulkemail($user_email, $this->replace_customer_bulkmessage( $message, $order_id ), esc_html( $user_first_name ));
								} else if ($customer_info ) {
										$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $customer_info ), esc_html( $user_first_name ));
								}
							}
						} else {
							if ( $order_id ) {
								if ($user_phone_no && $message ) {
									$this->send_bulksms($user_phone_no, $this->replace_customer_bulkmessage( $message, $order_id ));
								}
							} else {
								if ($user_phone_no && $message && $customer_info ) {
									$this->send_bulksms($user_phone_no, $this->replace_bulkmessage( $message, $customer_info ));
								}
							}
						}
					}

					echo '</p>';
					if ( $count == $limit ) {
						return;
					}
					$count++;
				}
			} else {
				echo '<h1>Bulk SMS/Emails status</h1>';
				$count = 1;
				foreach ( $user_ids_array as $userid ) {
					unset($user_ids_array[$userid]);
					wcsms_save_selected_users( $user_ids_array );

					$user = get_userdata( $userid );
					if ( $enable_email == 'on' ) {
						$user_email = get_user_meta( $userid, 'billing_email', true ) ? get_user_meta( $userid, 'billing_email', true ) : $user->user_email;
						if ( $user_email == '' || $message == '' ) {
							echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) . ": <span style='color:red; font-weight: bolder;'>error</span> Missing <strong>email {$user_email}</strong> or <strong>message {$message}</strong> to send. Skipping sending email";
						} else {
							if ($user_email && $message && $user ) {
								echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) . ': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $user ), esc_html( $user->first_name ));
								echo '</p>';
							}
						}
					}

					$user_phone_no = get_user_meta( $userid, 'billing_phone', true ) ? get_user_meta( $userid, 'billing_phone', true ) : get_user_meta( $userid, 'phone', true );
					if ( ! $user_phone_no ) {
						echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
						': <span style="color:red; font-weight: bolder;">error</span> <strong>No phone number found. Skipping SMS and sending email instead</strong> ';
							$user_email = get_user_meta( $userid, 'billing_email', true ) ? get_user_meta( $userid, 'billing_email', true ) : $user->user_email;
							if ($user_email && $message && $user ) {
								echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) . ': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $user ), esc_html( $user->first_name ));
								echo '</p>';
							}
					} else {
						echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
						': <strong>' . $user_phone_no .'</strong> ';

						// $message    = $this->replace_bulkmessage( $message, $user );
						$user_phone_no = $this->phone_number_processing( $user_phone_no );
						if ($user_phone_no && $message && $user ) {
							$this->send_bulksms($user_phone_no, $this->replace_bulkmessage( $message, $user ));
						} else {
							echo ' <span style="color:red; font-weight: bolder;">error</span> <strong>Missing phone number or message to send. Skipping SMS and sending email instead</strong>';
							$user_email = get_user_meta( $userid, 'billing_email', true ) ? get_user_meta( $userid, 'billing_email', true ) : $user->user_email;
							if ($user_email && $message && $user ) {
								echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) . ': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $user ), esc_html( $user->first_name ));
								echo '</p>';
							}
						}
					}

					echo '</p>';
					if ( $count == $limit ) {
						return;
					}
					$count++;
				}
			}
		} else if ( ! empty( $users_array ) ) {
			if ( $user_role == 'customer' ) {
				echo '<h1>Bulk SMS/Emails status</h1>';
				$count = 1;
				foreach ( $users_array as $customer ) {
					// echo '<p>--- Order #' . $order_id . ' ---</p>';
					if ( $enable_email == 'on' ) {
						$user_email = get_user_meta( $customer->ID, 'billing_email', true ) ? get_user_meta( $customer->ID, 'billing_email', true ) : $customer->user_email;
						if ( $user_email == '' || $message == '' ) {
							echo '<p>' . $count . ". " . esc_html( $customer->first_name ) . " ". esc_html( $customer->last_name ) . ": <span style='color:red; font-weight: bolder;'>error</span> Missing <strong>email {$user_email}</strong> or <strong>message {$message}</strong> to send. Skipping sending email";
						} else {
							if ($user_email && $message && $customer ) {
								echo '<p>' . $count . ". " . esc_html( $customer->first_name ) . " ". esc_html( $customer->last_name ) .
								': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $customer ),  esc_html( $customer->first_name ));
								echo '</p>';
							}
						}
					}

					$customer_phone_no = get_user_meta( $customer->ID, 'billing_phone', true ) ? get_user_meta( $customer->ID, 'billing_phone', true ) : get_user_meta( $customer->ID, 'phone', true );
					if ( ! $customer_phone_no ) {
						echo '<p>' . $count . ". " . esc_html( $customer->first_name ) . " ". esc_html( $customer->last_name ) .
						': <span style="color:red; font-weight: bolder;">error</span> <strong>No phone number found. Skipping SMS and sending email instead</strong> ';
						$user_email = get_user_meta( $customer->ID, 'billing_email', true ) ? get_user_meta( $customer->ID, 'billing_email', true ) : $customer->user_email;
						if ($user_email && $message && $customer ) {
							echo '<p>' . $count . ". " . esc_html( $customer->first_name ) . " ". esc_html( $customer->last_name ) .
							': <strong>' . $user_email .'</strong> ';
							$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $customer ),  esc_html( $customer->first_name ));
							echo '</p>';
						}
					} else {
						echo '<p>' . $count . ". " . esc_html( $customer->first_name ) . " ". esc_html( $customer->last_name ) .
						': <strong>' . $customer_phone_no .'</strong> ';

						// $message    = $this->replace_bulkmessage( $message, $customer );
						$customer_phone_no = $this->phone_number_processing( $customer_phone_no );
						if ($customer_phone_no && $message && $customer ) {
							$this->send_bulksms($customer_phone_no, $this->replace_bulkmessage( $message, $customer ));
						} else {
							echo ' <span style="color:red; font-weight: bolder;">error</span> <strong>Missing phone number or message to send. Skipping SMS and sending email instead</strong>';
							$user_email = get_user_meta( $customer->ID, 'billing_email', true ) ? get_user_meta( $customer->ID, 'billing_email', true ) : $customer->user_email;
							if ($user_email && $message && $customer ) {
								echo '<p>' . $count . ". " . esc_html( $customer->first_name ) . " ". esc_html( $customer->last_name ) .
								': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $customer ),  esc_html( $customer->first_name ));
								echo '</p>';
							}
						}
					}

					echo '</p>';
					$count++;
				}
			} else {
				echo '<h1>Bulk SMS/Emails status</h1>';
				$count = 1;
				foreach ( $users_array as $user ) {
					if ( $enable_email == 'on' ) {
						$user_email = get_user_meta( $user->ID, 'billing_email', true ) ? get_user_meta( $user->ID, 'billing_email', true ) : $user->user_email;
						if ( $user_email == '' || $message == '' ) {
							echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) . ": <span style='color:red; font-weight: bolder;'>error</span> Missing <strong>email {$user_email}</strong> or <strong>message {$message}</strong> to send. Skipping sending email";
						} else {
							if ($user_email && $message && $user ) {
								echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
								': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $user ), esc_html( $user->first_name ));
								echo '</p>';
							}
						}
					}

					$user_phone_no = get_user_meta( $user->ID, 'billing_phone', true ) ? get_user_meta( $user->ID, 'billing_phone', true ) : get_user_meta( $user->ID, 'phone', true );
					if ( ! $user_phone_no ) {
						echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
						': <span style="color:red; font-weight: bolder;">error</span> <strong>No phone number found. Skipping SMS and sending email instead</strong> ';
							$user_email = get_user_meta( $user->ID, 'billing_email', true ) ? get_user_meta( $user->ID, 'billing_email', true ) : $user->user_email;
							if ($user_email && $message && $user ) {
								echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
								': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $user ), esc_html( $user->first_name ));
								echo '</p>';
							}
					} else {
						echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
						': <strong>' . $user_phone_no .'</strong> ';

						// $message    = $this->replace_bulkmessage( $message, $user );
						$user_phone_no = $this->phone_number_processing( $user_phone_no );
						if ($user_phone_no && $message && $user ) {
						$this->send_bulksms($user_phone_no, $this->replace_bulkmessage( $message, $user ));
						} else {
							echo ' <span style="color:red; font-weight: bolder;">error</span> <strong>Missing phone number or message to send. Skipping SMS and sending email instead</strong>';
							$user_email = get_user_meta( $user->ID, 'billing_email', true ) ? get_user_meta( $user->ID, 'billing_email', true ) : $user->user_email;
							if ($user_email && $message && $user ) {
								echo '<p>' . $count . ". " . esc_html( $user->first_name ) . " ". esc_html( $user->last_name ) .
								': <strong>' . $user_email .'</strong> ';
								$this->send_bulkemail($user_email, $this->replace_bulkmessage( $message, $user ), esc_html( $user->first_name ));
								echo '</p>';
							}
						}
					}

					echo '</p>';
					$count++;
				}
			}
		} else {
			echo "No users with the role of $user_role found";
		}
	}

	public function send_bulksms($phone_no, $message) {
		$message = wp_kses_post( $message );
		$admin_phone = trim( wcsms_get_option( 'wcsms_admin_sms_recipients', 'wcsms_settings', '' ) );

		$enable_reply_to_email = wcsms_get_option( 'wcsms_enable_reply_to_email', 'wcsms_settings', '' );
		if ($enable_reply_to_email == 'on') {
			$message .= "\n" . sprintf( esc_html__( 'To reply, contact %s', WCSMS_PLUGIN_SLUG ), esc_html( get_bloginfo( 'admin_email' ) ) );
		} else if ( $admin_phone != '' ) {
			$message .= "\n" . sprintf( esc_html__( 'To reply, contact %s', WCSMS_PLUGIN_SLUG ), esc_html( trim( $admin_phone ) ) );
		}

		$phone_no = esc_html( wp_kses_post( $phone_no ));
		if ( !$phone_no || !$message ) {
			echo('-> <span style="color:red; font-weight: bolder;">skipped</span>: Phone number: <strong>' . $phone_no . '</strong> or Message: <strong>' . $message . '</strong> missing');
			return;
		}

		// $twilio_account_sid = esc_html( wcsms_get_option( 'wcsms_twilio_account_sid', 'wcsms_settings', '' ) );
		// $twilio_auth_token = esc_html( wcsms_get_option( 'wcsms_twilio_auth_token', 'wcsms_settings', '' ) );
		// $twilio_phone_no  = esc_html( wcsms_get_option( 'wcsms_twilio_phone_number', 'wcsms_settings', '') );

		// if ( $twilio_account_sid && $twilio_auth_token && $twilio_phone_no ) {
		// 	$this->wcsms_update_logs('Attempting to send SMS to ' . $phone_no . ', message: ' . $message );
		// 	try {
		// 		$twilio = new Client( $twilio_account_sid, $twilio_auth_token );
		// 		$mediaUrl = wcsms_get_option( 'wcsms_bulk_sms_image', 'bulksms_settings', '' );
		// 		if ( $mediaUrl ) {
		// 			$twilio_response = $twilio->messages->create(
		// 				$this->plus_on_phone_number( $phone_no ),
		// 				array(
		// 					'from' => $twilio_phone_no,
		// 					'body' => wp_kses_post( "$message\n" . sprintf( __("Reply %s to stop alerts", WCSMS_PLUGIN_SLUG), 'STOP' ) ),
		// 					'mediaUrl' => $mediaUrl,
		// 				)
		// 			);
		// 		} else {
		// 			$twilio_response = $twilio->messages->create(
		// 				$this->plus_on_phone_number( $phone_no ),
		// 				array(
		// 					'from' => $twilio_phone_no,
		// 					'body' => wp_kses_post( "$message\n" . sprintf( __("Reply %s to stop alerts", WCSMS_PLUGIN_SLUG), 'STOP' ) ),
		// 				)
		// 			);
		// 		}
		// 		echo('-> SMS Sent successfully to ' . $phone_no . ' SMS response from SMS gateway: ' . $twilio_response );
		// 		$this->wcsms_update_logs('-> SMS Sent successfully to ' . $phone_no . ' SMS response from SMS gateway: ' . $twilio_response );
		// 	} catch ( Exception $e ) {
		// 		echo('-> <span style="color:red; font-weight: bolder;">error</span> Failed to send SMS to ' . $phone_no . ', error: ' . $e->getMessage() );
		// 		$this->wcsms_update_logs('-> Failed to send SMS to ' . $phone_no . ', error: ' . $e->getMessage() );
		// 	}
		// } else {
		// 	$this->wcsms_update_logs('Twilio account SID, Auth Token or Twilio phone number is not set.' );
		// 	wp_die( 'Twilio account SID, Auth Token or Twilio phone number is not set in your Woocommerce SMS PRO plugin. <a href="' . admin_url( 'admin.php?page=wcsms-settings' ) . '" class="button button-secondary">' . __( 'Go Back', WCSMS_PLUGIN_SLUG ) . '</a>' );
		// }
		$this->wcsms_twilio_send( $phone_no, $message, true );
	}

	public function send_bulkemail($email, $message, $name) {
		$message = wp_kses_post( $message );
		$email = esc_html( wp_kses_post( $email ));
		$domain = !empty(parse_url(get_bloginfo('url'))) ? parse_url(get_bloginfo('url'))['host'] : null;

		if ( $email && $message ) {
			// wp_mail
			$headers = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>';
			$headers[] = 'Reply-To: ' . get_option( 'admin_email' );

			$name = esc_html( wp_kses_post( ", {$name}" ));

			$subject = get_bloginfo( 'name' ) . ' sent you a message' . $name;
			$email_message = wp_kses_post( "<p>" . sprintf( __( "Hi %s", WCSMS_PLUGIN_SLUG ), $name ) . "</p>" .
			"<p>" . __( "I just wanted to let you know that you might be receiving the following SMS from us:", WCSMS_PLUGIN_SLUG) . "</p>" .
			"<p>" . sprintf( __( "SMS:<br> %s", WCSMS_PLUGIN_SLUG ), $message ) . "</p>" . "<p>" . __( "Regards,", WCSMS_PLUGIN_SLUG) . "</p>" . "<p>" . get_bloginfo( 'name' ) . "<br>" . $domain . "</p>" );

			$message = wp_mail( $email, $subject, $email_message, $headers );
			if ( $message ) {
				echo('-> Email Sent successfully to ' . $email . ' with the following message: ' . $email_message );
				$this->wcsms_update_logs('-> Email Sent successfully to ' . $email);
			} else {
				echo('-> <span style="color:red; font-weight: bolder;">error</span> Failed to send email to ' . $email . ', error: ' . $message );
				$this->wcsms_update_logs('-> Failed to send email to ' . $email . ', error: ' . $message );
			}
		} else {
			echo('-> <span style="color:red; font-weight: bolder;">error</span> Missing email or message to send.' );
			$this->wcsms_update_logs('-> Missing email or message to send.' );
		}
	}

	public function wcsms_update_logs( $message ) {
		$current_logs = get_option( "wcsms_logs" );
		// date function at https://www.w3schools.com/php/phptryit.asp?filename=tryphp_func_gmdate
		// $current_datetime = gmdate(DATE_RFC822);
		// $current_datetime = gmdate( time() );
		$current_datetime = date( 'Y-m-d H:i:s' );
		$new_logs = "$current_datetime $message \n" . $current_logs;

		// $logs_array = explode( "\n", $new_logs );
		// if ( count( $logs_array ) > 100 ) {
		// 	$logs_array = array_slice( $logs_array, 0, 100 );
		// 	$new_logs = implode( "\n", $logs_array );
		// }

		update_option( "wcsms_logs", esc_html( $new_logs ) );
	}

	public function wcsms_log( $message, $level = 'info' ) {
		// logs at admin.php?page=wc-status&tab=logs
		if ( !empty($message) && wcsms_fs()->is_plan__premium_only('pro') ) {
			$logger = wc_get_logger();
			$logger->log( $level, wp_strip_all_tags(wp_kses_post($message)), array( 'source' => 'wc-sms' ) );
		}
	}

	private function plus_on_phone_number( $phone_number, $country = null ) {
		if ( empty($phone_number) ) return '';
		$woo_country    = strtoupper(wcsms_get_option( 'wcsms_woocommerce_country_code', 'wcsms_settings', '' )); // Get default country v1.1.17

		$country_code = '';
		if ( !empty( $country ) ) {
			$country_code = WC()->countries->get_country_calling_code( $country );
			// // https://wp-kama.com/plugin/woocommerce/function/WC_Countries::get_country_calling_code
			// $WC_Countries = new WC_Countries();
			// $country_code = $WC_Countries->get_country_calling_code( $country );
			if ( !empty( $country_code ) ) {
				$phone_number = "$country_code$phone_number";
			}
		}

		if ( strpos($phone_number, '+') === false ) {
			if ( $woo_country == 'US' || strlen($phone_number) == 10 ) {
				$phone_number = "+1$phone_number";
			} else if ( !empty( $woo_country ) && $woo_country != 'US' ) {
				$country_code = WC()->countries->get_country_calling_code( $woo_country );
				if ( !empty( $country_code ) ) {
					$phone_number = "$country_code$phone_number";
				} else {
					$phone_number = "+$phone_number";
				}
			} else {
				$phone_number = "+$phone_number";
			}
		}
		return esc_html( trim($phone_number) );
	}

	public function get_order_phone_number( $order = array() ) {
		if( empty($order) || ! is_a( $order, 'WC_Order' ) ) return '';

		$country = $order->get_billing_country();
		$phone_number = $order->get_billing_phone();

		$country_code = WC()->countries->get_country_calling_code( $country );
		if ( !empty( $country_code ) ) {
			$phone_number = "$country_code$phone_number";
		}

		return esc_html( $phone_number );
	}

	protected function replace_order_keyword( $message, $order, $user_type, $order_status ) {
		/** @var WC_Order $order */
		$order_id = $order->get_id();
		$order_number = method_exists($order, 'get_order_number') ? $order->get_order_number() : $order_id;

		$items      = $order->get_items();
		$product_names   = '';
		$products_with_qty = '';
		foreach ( $items as $item ) {
			$product_names   .= ', ' . $item->get_name();
			$products_with_qty .= ', ' . $item->get_name() . ' X ' . $item->get_quantity();
		}
		if ( $product_names ) {
			$product_names   = substr( $product_names, 2 );
			$products_with_qty = substr( $products_with_qty, 2 );
		}

		$search = [
			'[shop_name]',
			'[shop_email]',
			'[shop_url]',
			'[first_name]',
			'[last_name]',
			'[order_id]',
			'[order_number]',
			'[order_currency]',
			'[order_amount]',
			'[order_status]',
			'[order_items]',
			'[order_items_with_qty]',
			'[customer_first_name]',
			'[customer_last_name]',
			'[customer_phone]',
			'[customer_email]',
			'[customer_company]',
			'[customer_address]',
			'[customer_country]',
			'[customer_city]',
			'[customer_state]',
			'[customer_postcode]',
			'[payment_method]'
		];

		$domain = !empty(parse_url(get_bloginfo('url'))) ? parse_url(get_bloginfo('url'))['host'] : null;
		$replace = [
			get_bloginfo( 'name' ),
			get_bloginfo( 'admin_email' ),
			$domain,
			$order->get_billing_first_name(),
			$order->get_billing_last_name(),
			$order_id,
			$order_number,
			$order->get_currency(),
			$order->get_total(),
			$order->get_status(),
			$product_names,
			$products_with_qty,
			$order->get_billing_first_name(),
			$order->get_billing_last_name(),
			$order->get_billing_phone(),
			$order->get_billing_email(),
			$order->get_billing_company(),
			$order->get_billing_address_1(),
			$order->get_billing_country(),
			$order->get_billing_city(),
			$order->get_billing_state(),
			$order->get_billing_postcode(),
			$order->get_payment_method()
		];
		$message = str_replace( $search, $replace, $message );

		return wp_kses_post( $message );
	}

	protected function phone_number_processing( $phone_no ) {
		$updated_phone_no = '';
		if ( $phone_no != '' ) {
			$phone_no_array = explode( ",", $phone_no );
			foreach ( $phone_no_array as $number ) {
				if ( $number != '' ) {
					$number      = preg_replace( "/[^0-9,.]/", "", $number );
					$updated_phone_no .= ',' . $number;
				}
			}
			$updated_phone_no = substr( $updated_phone_no, 1 );
		}

		return esc_html( $updated_phone_no );
	}

	protected function get_additional_billing_fields() {
		$default_billing_fields  = [
			'billing_first_name',
			'billing_last_name',
			'billing_company',
			'billing_address_1',
			'billing_address_2',
			'billing_city',
			'billing_state',
			'billing_country',
			'billing_postcode',
			'billing_phone',
			'billing_email'
		];
		$additional_billing_field = [];
		$billing_fields      = array_filter( get_option( 'wc_fields_billing', [] ) );
		foreach ( $billing_fields as $field_key => $field_info ) {
			if ( ! in_array( $field_key, $default_billing_fields ) && $field_info['enabled'] ) {
				array_push( $additional_billing_field, $field_key );
			}
		}
		return esc_html( $additional_billing_field );
	}
}
