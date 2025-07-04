<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class WCSMS_WooCommerce_Settings implements WCSMS_Register_Interface {
    private $settings_api;

    function __construct() {
        $this->settings_api = new WCSMS_Settings_API();
    }

    public function register() {
        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( "admin_post_wcsms_send_bulk_sms", array($this, 'wcsms_bulk_sms') );
    }

    function admin_init() {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );
        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        $parent_slug = 'wcsms-settings';
        $capability = 'manage_options';
        $contact_url = "mailto:info@theafricanboss.com?subject=WC%20SMS%20Plugin%20Support&body=Hello%2C%0D%0A%0D%0A";
        global $wcsms_fs;
        $account_url = wcsms_fs()->get_account_url();
        $upgrade_url = wcsms_fs()->get_upgrade_url();
        add_submenu_page(
            'woocommerce',
            'WooCommerce SMS',
            'WooCommerce SMS',
            'manage_woocommerce',
            'wcsms-settings',
            array($this, 'wcsms_main_page')
        );
        add_menu_page(
            $parent_slug,
            'WC SMS',
            $capability,
            $parent_slug,
            array($this, 'wcsms_main_page'),
            'dashicons-format-chat',
            56
        );
        add_submenu_page(
            $parent_slug,
            'Bulk SMS/Emails',
            '<span style="background: green; color: white;">Preview before sending</span>',
            $capability,
            'wcsms-bulk-sms',
            array($this, 'wcsms_bulksms_page'),
            null
        );
        add_submenu_page(
            $parent_slug,
            'Twilio Messages',
            'Twilio SMS List',
            $capability,
            'wcsms-sms-list',
            array($this, 'wcsms_smslist_page'),
            null
        );
        add_submenu_page(
            $parent_slug,
            'SMS/Emails Logs',
            'SMS/Emails Logs',
            $capability,
            'wcsms_logs',
            array($this, 'wcsms_smslogs_page'),
            null
        );
        add_submenu_page(
            $parent_slug,
            'Our Plugins',
            '<span style="color:#afa">Must-have Plugins</span>',
            $capability,
            admin_url( "plugin-install.php?s=theafricanboss&tab=search&type=author" ),
            null,
            null
        );
        add_submenu_page(
            $parent_slug,
            'Review Send Order SMS on Woocommerce',
            'Review',
            $capability,
            'https://wordpress.org/support/plugin/wc-sms/reviews/?filter=5',
            null,
            null
        );
        add_submenu_page(
            $parent_slug,
            'Feature my store',
            'Get Featured',
            $capability,
            'https://theafricanboss.com/featured',
            null,
            null
        );
        add_submenu_page(
            $parent_slug,
            'Account',
            'Account',
            $capability,
            $account_url,
            null,
            null
        );
        add_submenu_page(
            $parent_slug,
            'Contact',
            'Support Email',
            $capability,
            $contact_url,
            null,
            null
        );
        // add_submenu_page( $parent_slug , 'Upgrade' , 'Upgrade' , $capability  , $upgrade_url , null , null );
        // add_submenu_page(
        //     $parent_slug,
        //     'Help',
        //     'Help',
        //     $capability,
        //     'wcsms_help_page',
        //     array( $this, 'wcsms_help_page'),
        //     null
        // );
        // add_submenu_page(
        //     $parent_slug,
        //     'Recommended',
        //     'Recommended',
        //     $capability,
        //     'wcsms_recommended_page',
        //     array( $this, 'wcsms_recommended_page'),
        //     null
        // );
    }

    function wcsms_main_page() {
        _e( '<div class="wrap">' );
        echo '<h1>' . __( 'Send Order SMS Notifications', WCSMS_PLUGIN_SLUG ) . '</h1>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '<input type="hidden" value="' . join( ",", $this->get_additional_billing_fields() ) . '" id="wcsms_new_billing_field" />';
        _e( '</div>' );
    }

    function wcsms_bulksms_page() {
        require_once WCSMS_PLUGIN_DIR . 'includes/admin/bulk-sms.php';
    }

    function wcsms_smslogs_page() {
        require_once WCSMS_PLUGIN_DIR . 'includes/admin/sms-logs.php';
    }

    function wcsms_smslist_page() {
        require_once WCSMS_PLUGIN_DIR . 'includes/admin/sms-list.php';
    }

    function wcsms_recommended_page() {
        require_once WCSMS_PLUGIN_DIR . 'includes/admin/recommended.php';
    }

    function wcsms_help_page() {
        require_once WCSMS_PLUGIN_DIR . 'includes/admin/help.php';
    }

    function wcsms_bulk_sms() {
        $template_name = 'wcsms_bulk_sms_template';
        $wcsms_send_action = 'wcsms_send_bulk_sms';
        $referer = esc_html( urldecode( $_POST['_wp_http_referer'] ) );
        echo '<div class="wrap"><div style="padding: 10rem">';
        if ( !wp_verify_nonce( $_POST[$template_name . '_nonce'], $wcsms_send_action ) ) {
            wp_die( 'Invalid nonce.' . esc_html( var_export( $_POST, true ) ) );
        }
        if ( !isset( $referer ) ) {
            wp_die( 'Missing target.' . esc_html( var_export( $_POST, true ) ) );
        }
        $WCSMS_WooCommerce_Notification = new WCSMS_WooCommerce_Notification();
        $WCSMS_WooCommerce_Notification->send_bulksms_notification();
        // $url = add_query_arg( 'msg', 'sent', urldecode( $referer );
        // wp_safe_redirect( $referer;
        echo '<p style="margin-top: 50px;">
		<a style="padding: 1rem; border: none; background-color: black; color: white; text-decoration: none;"
		href="' . $referer . '">Go Back</a></p>';
        echo '</div>';
        exit;
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wcsms_settings',
                'title' => __( 'SMS Settings', WCSMS_PLUGIN_SLUG ),
            ),
            array(
                'id'    => 'customer_settings',
                'title' => __( 'Customer SMS', WCSMS_PLUGIN_SLUG ),
            ),
            array(
                'id'    => 'bulksms_settings',
                'title' => __( 'Bulk SMS/Emails <sup style="color:#c00">IMPROVED</sup>', WCSMS_PLUGIN_SLUG ),
            ),
            array(
                'id'    => 'admin_settings',
                'title' => __( 'Admin SMS', WCSMS_PLUGIN_SLUG ),
            ),
            array(
                'id'    => 'marketing_settings',
                'title' => __( 'Marketing SMS <sup style="color:#00c">COMING SOON</sup>', WCSMS_PLUGIN_SLUG ),
            )
        );
        return apply_filters( 'wcsms_setting_section', $sections );
    }

    // add_settings_section(
    //     'eg_setting_section',
    //     __( 'Example settings section in reading', WCSMS_PLUGIN_SLUG ),
    //     'wcsms_setting_section_callback_function',
    //     WCSMS_PLUGIN_SLUG
    // );
    // /**
    //  * Settings section display callback.
    //  *
    //  * @param array $args Display arguments.
    //  */
    // function wcsms_setting_section_callback_function( $args ) {
    //     // echo section intro text here
    //     echo '<p>id: ' . esc_html( $args['id'] ) . '</p>';                         // id: eg_setting_section
    //     echo '<p>title: ' . apply_filters( 'the_title', $args['title'] ) . '</p>'; // title: Example settings section in reading
    //     echo '<p>callback: ' . esc_html( $args['callback'] ) . '</p>';             // callback: eg_setting_section_callback_function
    // }
    /**
     * Returns all the settings fields
     * @return array settings fields
     */
    function get_settings_fields() {
        $newFeature = " <sup style='color:#c00;'>NEW FEATURE</sup>";
        $improvedFeature = " <sup style='color:#0c0;'>IMPROVED FEATURE</sup>";
        $comingSoon = " <sup style='color:#00c;'>COMING SOON</sup>";
        $additional_billing_fields = '';
        $additional_billing_fields_array = $this->get_additional_billing_fields();
        foreach ( $additional_billing_fields_array as $field ) {
            $additional_billing_fields .= ', [' . $field . ']';
        }
        if ( $additional_billing_fields ) {
            $additional_billing_fields_desc = '<br />Custom tags: ' . substr( $additional_billing_fields, 2 );
        }
        // get_available_payment_gateways
        $available_payment_methods = WC()->payment_gateways->get_available_payment_gateways();
        $paym_methods = array();
        $all_paym_methods = array();
        foreach ( $available_payment_methods as $method ) {
            $paym_methods[$method->id] = $method->get_title();
            $all_paym_methods[$method->id] = $method->id;
        }
        // wc_get_order_statuses
        $order_statuses = wc_get_order_statuses();
        $order_statuses_array = array();
        foreach ( $order_statuses as $key => $value ) {
            $key = str_replace( 'wc-', '', $key );
            $order_statuses_array[$key] = $value;
        }
        global $wcsms_fs;
        $upgrade_url = wcsms_fs()->get_upgrade_url();
        $pro = ' <a style="text-decoration:none" href="' . esc_url( $upgrade_url ) . '" target="_blank"><sup style="color:red">PRO</sup></a>';
        $edit_with_pro = ' <a style="text-decoration:none" href="' . esc_url( $upgrade_url ) . '" target="_blank"><sup style="color:red">' . __( 'EDIT WITH', WCSMS_PLUGIN_SLUG ) . ' PRO</sup></a>';
        // get all wordpress user roles
        $user_roles_array = wp_roles()->roles;
        $user_roles = array();
        foreach ( $user_roles_array as $key => $value ) {
            $user_roles[$key] = $value['name'];
        }
        // get all users with selected roles
        $user_role = wcsms_get_option( 'wcsms_enable_bulksms_on_user_roles', 'bulksms_settings', '' );
        $all_users_array = array();
        $users_settings = array(
            'name'  => 'wcsms_enable_bulksms_on_users',
            'label' => __( 'Send SMS notifications only to these users', WCSMS_PLUGIN_SLUG ),
            'desc'  => __( 'Please select a user role above then save to see all the users with that user role', WCSMS_PLUGIN_SLUG ),
            'type'  => 'html',
        );
        $customer_order_statuses = array(
            'name'  => 'wcsms_enable_bulksms_on_order_statuses',
            'label' => __( 'Send SMS notifications only to these customer order statuses', WCSMS_PLUGIN_SLUG ),
            'desc'  => __( 'Please select the Customer role above then save to see all the available order statuses', WCSMS_PLUGIN_SLUG ),
            'type'  => 'html',
        );
        if ( $user_role && $user_role != 'customer' ) {
            $all_users_array = get_users( array(
                'role' => $user_role,
            ) );
            $all_users = array();
            foreach ( $all_users_array as $user ) {
                $all_users[$user->ID] = $user->display_name;
            }
            if ( $all_users ) {
                $smsdialog = null;
                if ( count( $all_users ) > 10 ) {
                    $smsdialog = ' <a role="button" id="sms-dialog" style="display: inline-block; color:blue; background-color:white; padding: 5px; text-align: center; border: 1px dotted blue;">Select a starting point for checkboxes</a>';
                }
                $users_settings = array(
                    'name'    => 'wcsms_enable_bulksms_on_users',
                    'label'   => sprintf( __( 'Send SMS notifications only to these <span class="counter count-selected-users"></span>/%1$s users on this list.<br><a role="button" id="select-all-users" style="display: inline-block; color:green; background-color:white; padding: 5px; text-align: center; border: 1px solid green;">All</a> <a role="button" id="unselect-all-users" style="display: inline-block; color:red; background-color:white; padding: 5px; text-align: center; border: 1px solid red;">None</a> <span style="color:blue">Processed selected users will be unselected after processing</span>' . $smsdialog . $improvedFeature, WCSMS_PLUGIN_SLUG ), count( $all_users ) ),
                    'desc'    => sprintf( __( 'Choose which of these <span class="counter count-selected-users"></span>/%s users to send an SMS to', WCSMS_PLUGIN_SLUG ), count( $all_users ) ),
                    'type'    => 'multicheck',
                    'options' => $all_users,
                );
            } else {
                $users_settings = array(
                    'name'  => 'wcsms_enable_bulksms_on_users',
                    'label' => __( 'Send SMS notifications only to these users', WCSMS_PLUGIN_SLUG ),
                    'desc'  => __( 'No users found with the selected user role', WCSMS_PLUGIN_SLUG ),
                    'type'  => 'html',
                );
            }
        } else {
            if ( $user_role && $user_role == 'customer' ) {
                $wcsms_enable_guest_customers = wcsms_get_option( 'wcsms_enable_guest_customers', 'bulksms_settings', '' );
                $wcsms_enable_registered_customers = wcsms_get_option( 'wcsms_enable_registered_customers', 'bulksms_settings', '' );
                $all_users = array();
                $all_users_array = get_users( array(
                    'role' => $user_role,
                ) );
                if ( $wcsms_enable_registered_customers == "on" ) {
                    foreach ( $all_users_array as $user ) {
                        $all_users[$user->ID] = "registered: {$user->display_name}";
                    }
                }
                if ( $wcsms_enable_guest_customers == "on" ) {
                    $selected_customer_order_statuses = wcsms_get_option( 'wcsms_enable_bulksms_on_order_statuses', 'bulksms_settings', '' );
                    if ( $selected_customer_order_statuses ) {
                        $selected_orders = wc_get_orders( [
                            'limit'  => -1,
                            'status' => $selected_customer_order_statuses,
                            'type'   => 'shop_order',
                        ] );
                    } else {
                        $selected_orders = wc_get_orders( [
                            'limit' => -1,
                            'type'  => 'shop_order',
                        ] );
                    }
                    global $wpdb;
                    foreach ( $selected_orders as $order ) {
                        $order_id = esc_html( $order->get_id() );
                        $first_name = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_first_name'", $order_id ) )->meta_value;
                        $last_name = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_last_name'", $order_id ) )->meta_value;
                        $all_users["g{$order_id}"] = "guest: {$first_name} {$last_name}";
                    }
                }
                $customer_order_statuses = array(
                    'name'    => 'wcsms_enable_bulksms_on_order_statuses',
                    'label'   => __( 'Send SMS notifications only to customers with these order statuses (<span style="color:red">Select None to display All Customers</span>)', WCSMS_PLUGIN_SLUG ),
                    'desc'    => __( 'Choose which order statuses to send an SMS to then save for the users to show', WCSMS_PLUGIN_SLUG ),
                    'type'    => 'multicheck',
                    'options' => $order_statuses_array,
                );
                if ( $all_users ) {
                    $smsdialog = null;
                    if ( count( $all_users ) > 250 ) {
                        $smsdialog = ' <a role="button" id="sms-dialog" style="display: inline-block; color:blue; background-color:white; padding: 5px; text-align: center; border: 1px dotted blue;">Select a starting point for checkboxes</a>';
                    }
                    $users_settings = array(
                        'name'    => 'wcsms_enable_bulksms_on_users',
                        'label'   => sprintf( __( 'Send SMS notifications only to these <span class="counter count-selected-users"></span>/%1$s users on this list.<br><a role="button" id="select-all-users" style="display: inline-block; color:green; background-color:white; padding: 5px; text-align: center; border: 1px solid green;">All</a> <a role="button" id="unselect-all-users" style="display: inline-block; color:red; background-color:white; padding: 5px; text-align: center; border: 1px solid red;">None</a> <span style="color:blue">Processed selected users will be unselected after processing</span>' . $smsdialog . $improvedFeature, WCSMS_PLUGIN_SLUG ), count( $all_users ) ),
                        'desc'    => sprintf( __( 'Choose which of these <span class="counter count-selected-users"></span>/%s users to send an SMS to', WCSMS_PLUGIN_SLUG ), count( $all_users ) ),
                        'type'    => 'multicheck',
                        'options' => $all_users,
                    );
                } else {
                    $users_settings = array(
                        'name'  => 'wcsms_enable_bulksms_on_users',
                        'label' => __( 'Send SMS notifications only to these users' . $improvedFeature, WCSMS_PLUGIN_SLUG ),
                        'desc'  => __( 'No users found with the selected criteria', WCSMS_PLUGIN_SLUG ),
                        'type'  => 'html',
                    );
                }
            }
        }
        $upload_dir = wp_upload_dir();
        $wcsms_bulk_sms_image = wcsms_get_option( 'wcsms_bulk_sms_image', 'bulksms_settings', '' );
        $viewMediaUrl = null;
        if ( $wcsms_bulk_sms_image ) {
            $viewMediaUrl = "<br><a href='{$wcsms_bulk_sms_image}' target='_blank'>View Image</a>";
        }
        $settings_fields = array(
            'wcsms_settings'     => array(
                array(
                    'name'  => 'wcsms_log',
                    'label' => 'SMS sent',
                    'desc'  => '<a href="' . admin_url( 'admin.php?page=wcsms_logs' ) . '" class="button button-secondary">View all SMS sent</a>',
                    'type'  => 'html',
                ),
                // admin.php?page=wcsms_logs
                array(
                    'name'  => 'wcsms_admin_sms_recipients',
                    'label' => __( 'Admin Phone Number (format: +1234567890)', WCSMS_PLUGIN_SLUG ),
                    'desc'  => __( 'Mobile number to receive new order SMS. To send to multiple receivers, separate each entry with comma such as +1234567890, +9876543210', WCSMS_PLUGIN_SLUG ),
                    'type'  => 'text',
                ),
                array(
                    'name'    => 'wcsms_woocommerce_country_code',
                    'label'   => __( 'Admin Phone Country', WCSMS_PLUGIN_SLUG ),
                    'desc'    => __( 'Country associated with the phone submitted above', WCSMS_PLUGIN_SLUG ),
                    'type'    => 'select',
                    'options' => array(
                        'us'    => 'United States',
                        'ca'    => 'Canada',
                        'gb'    => 'United Kingdom',
                        'other' => __( 'Other', WCSMS_PLUGIN_SLUG ),
                    ),
                ),
                array(
                    'name'    => 'wcsms_customer_enable_send_sms',
                    'label'   => __( 'Enable Customer SMS Notifications', WCSMS_PLUGIN_SLUG ),
                    'desc'    => ' ' . __( 'Check to Enable / Uncheck to Disable', WCSMS_PLUGIN_SLUG ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),
                array(
                    'name'    => 'wcsms_admin_enable_send_sms',
                    'label'   => __( 'Enable Admin SMS Notifications', WCSMS_PLUGIN_SLUG ),
                    'desc'    => ' ' . __( 'Check to Enable / Uncheck to Disable', WCSMS_PLUGIN_SLUG ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),
                array(
                    'name'    => 'wcsms_enable_reply_to_email',
                    'label'   => __( 'Enable Reply to Email instead of Reply by SMS' . $newFeature, WCSMS_PLUGIN_SLUG ),
                    'desc'    => ' ' . __( 'Check for Email Replies / Uncheck for SMS replies. This adds a signature to each SMS telling them how to reply in case you do not want SMS replies (for example, "To reply, reach out to admin@email" instead of "To reply, reach out to +1234567890")', WCSMS_PLUGIN_SLUG ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),
                array(
                    'name'  => 'wcsms_twilio_header',
                    'label' => '',
                    'desc'  => '<h3>' . __( 'General Settings', WCSMS_PLUGIN_SLUG ) . '</h3>',
                    'type'  => 'html',
                ),
                array(
                    'name'    => 'wcsms_enable_assigned_phone_number',
                    'label'   => __( 'Use Assigned/Default Phone Number', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => ' ' . __( 'Check to Use a designated phone number', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_twilio_or',
                    'label' => '',
                    'desc'  => '<strong> - ' . __( 'Or use your own Twilio Configuration', WCSMS_PLUGIN_SLUG ) . ' - </strong>',
                    'type'  => 'html',
                ),
                array(
                    'name'  => 'wcsms_twilio_account_sid',
                    'label' => __( 'Twilio Account SID', WCSMS_PLUGIN_SLUG ),
                    'desc'  => __( 'Your Twilio Account SID. You can get it from <a href="https://console.twilio.com/" target="blank">here</a>', WCSMS_PLUGIN_SLUG ),
                    'type'  => 'text',
                ),
                array(
                    'name'  => 'wcsms_twilio_auth_token',
                    'label' => __( 'Twilio Auth Token', WCSMS_PLUGIN_SLUG ),
                    'desc'  => __( 'Your Twilio Auth Token. You can get it from <a href="https://console.twilio.com/" target="blank">here</a>', WCSMS_PLUGIN_SLUG ),
                    'type'  => 'password',
                ),
                array(
                    'name'  => 'wcsms_twilio_phone_number',
                    'label' => __( 'Twilio Phone Number', WCSMS_PLUGIN_SLUG ),
                    'desc'  => __( 'Your Twilio Phone Number. You can get it from <a href="https://console.twilio.com/" target="blank">here</a>', WCSMS_PLUGIN_SLUG ),
                    'type'  => 'text',
                ),
                array(
                    'name'  => 'wcsms_customer_header',
                    'label' => '',
                    'desc'  => '<h3>' . __( 'Send SMS to Customer', WCSMS_PLUGIN_SLUG ) . '</h3>',
                    'type'  => 'html',
                ),
                array(
                    'name'    => 'wcsms_customer_send_sms_on',
                    'label'   => __( 'Send customer SMS on', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Choose when to send an SMS to your customer', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'multicheck',
                    'default' => array(
                        'pending'    => 'pending',
                        'on-hold'    => 'on-hold',
                        'failed'     => 'failed',
                        'cancelled'  => 'cancelled',
                        'processing' => 'processing',
                    ),
                    'options' => $order_statuses_array,
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_edit_customer_templates',
                    'label' => 'Customer SMS Templates' . $pro,
                    'desc'  => '<a href="' . admin_url( 'admin.php?page=wcsms-settings#customer_settings' ) . '" class="button button-secondary tab-href customer_settings-tab">' . __( 'Edit Templates', WCSMS_PLUGIN_SLUG ) . '</a>' . $edit_with_pro,
                    'type'  => 'html',
                    'css'   => 'width:80%; pointer-events: none;',
                    'attr'  => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_paym_methods_header',
                    'label' => '',
                    'desc'  => '<h3>' . __( 'Send SMS by Payment Methods', WCSMS_PLUGIN_SLUG ) . '</h3>',
                    'type'  => 'html',
                ),
                array(
                    'name'    => 'wcsms_enable_on_woocommerce_gateways',
                    'label'   => __( 'Send SMS notifications only for these payment gateways', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Choose for which methods to send an SMS', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'multicheck',
                    'default' => $all_paym_methods,
                    'options' => $paym_methods,
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_admin_header',
                    'label' => '',
                    'desc'  => '<h3>' . __( 'Send SMS to Admin', WCSMS_PLUGIN_SLUG ) . '</h3>',
                    'type'  => 'html',
                ),
                array(
                    'name'    => 'wcsms_admin_send_sms_on',
                    'label'   => __( 'Send Admin SMS on', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Choose when to send an SMS to your admin', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'multicheck',
                    'default' => array(
                        'pending'    => 'pending',
                        'on-hold'    => 'on-hold',
                        'processing' => 'processing',
                    ),
                    'options' => $order_statuses_array,
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_edit_admin_templates',
                    'label' => 'Admin SMS Templates' . $pro,
                    'desc'  => '<a href="' . admin_url( 'admin.php?page=wcsms-settings#admin_settings' ) . '" class="button button-secondary tab-href admin_settings-tab">' . __( 'Edit Templates', WCSMS_PLUGIN_SLUG ) . '</a>' . $edit_with_pro,
                    'type'  => 'html',
                    'css'   => 'width:80%; pointer-events: none;',
                    'attr'  => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_marketing_header',
                    'label' => '',
                    'desc'  => '<h3>' . __( 'Send Follow-up/Marketing SMS to Customer after a sale occurs', WCSMS_PLUGIN_SLUG ) . $comingSoon . '</h3>',
                    'type'  => 'html',
                ),
                array(
                    'name'    => 'wcsms_marketing_enable_reorder_sms',
                    'label'   => __( 'Enable Save & Reorder SMS', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => ' ' . __( 'Check to Enable / Uncheck to Disable', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_marketing_enable_subscription_sms',
                    'label'   => __( 'Enable Subscribe & Reorder SMS', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => ' ' . __( 'Check to Enable / Uncheck to Disable', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_marketing_subscription_frequency',
                    'label'   => __( 'Subscription Frequency', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'How often does the customer receive an SMS', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'select',
                    'options' => array(
                        'weekly'     => ' Every Week',
                        'biweekly'   => ' Every 2 Weeks',
                        'triweekly'  => ' Every 3 Weeks',
                        'monthly'    => ' Every Month',
                        'quarterly'  => ' Every 3 Months',
                        'biannually' => ' Every 6 Months',
                    ),
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_marketing_enable_upsell_sms',
                    'label'   => __( 'Enable Upsell SMS', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => ' ' . __( 'Check to Enable / Uncheck to Disable', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'width:80%; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'  => 'wcsms_edit_marketing_templates',
                    'label' => 'Marketing SMS Templates' . $pro,
                    'desc'  => '<a href="' . admin_url( 'admin.php?page=wcsms-settings#marketing_settings' ) . '" class="button button-secondary tab-href marketing_settings-tab">' . __( 'Edit Templates', WCSMS_PLUGIN_SLUG ) . '</a>' . $edit_with_pro,
                    'type'  => 'html',
                    'css'   => 'width:80%; pointer-events: none;',
                    'attr'  => 'disabled',
                ),
            ),
            'admin_settings'     => array(array(
                'name'    => 'wcsms_admin_sms_template',
                'label'   => __( 'Admin SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                'type'    => 'textarea',
                'default' => __( '[shop_name] : You have a new order with order ID [order_id] and order amount [order_currency] [order_amount]. The order is now [order_status].', WCSMS_PLUGIN_SLUG ),
                'rows'    => '8',
                'cols'    => '500',
                'css'     => 'min-width:350px; pointer-events: none;',
                'attr'    => 'disabled',
            )),
            'bulksms_settings'   => array(
                array(
                    'name'    => 'wcsms_bulk_sms_template',
                    'label'   => __( 'Bulk Message Template & <a href="https://support.twilio.com/hc/en-us/articles/223134027-Twilio-support-for-opt-out-keywords-SMS-STOP-filtering-" target="_blank" rel="noopener noreferrer">Add Twilio Opt-In/Opt-Out Keywords</a>' . $improvedFeature, WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                    'default' => __( '[shop_name] : Celebrate the holidays with 15% off your next order, [first_name].', WCSMS_PLUGIN_SLUG ),
                ),
                array(
                    'name'        => 'wcsms_bulk_sms_image',
                    'label'       => __( 'Bulk Message Image URL (must be publicly available)' . $viewMediaUrl . $newFeature, WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'        => __( 'If you need to add an image to your text, please add its publicly available URL here', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'        => 'file',
                    'css'         => 'min-width:350px; pointer-events: none;',
                    'attr'        => 'disabled',
                    'placeholder' => __( $upload_dir['baseurl'], WCSMS_PLUGIN_SLUG ),
                ),
                array(
                    'name'    => 'wcsms_enable_bulksms_on_user_roles',
                    'label'   => __( 'Send SMS notifications only to these user roles', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Choose which user roles to send an SMS to', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'select',
                    'css'     => 'pointer-events: none;',
                    'attr'    => 'disabled',
                    'options' => $user_roles,
                ),
                $customer_order_statuses,
                array(
                    'name'    => 'wcsms_enable_guest_customers',
                    'label'   => __( 'Include unregistered guest customers (if customer role is selected)', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Check to include guests/Uncheck to disable', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_enable_registered_customers',
                    'label'   => __( 'Include registered guest customers (if customer role is selected)', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Check to include registered guests/Uncheck to disable', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_bulk_sms_limit',
                    'label'   => __( 'Select how many to process at a time (when you select all, the processed will be unselected)' . $newFeature, WCSMS_PLUGIN_SLUG ),
                    'desc'    => __( 'This only works if you select users. If you select none, the limit will not be applied', WCSMS_PLUGIN_SLUG ),
                    'type'    => 'select',
                    'css'     => 'pointer-events: none;',
                    'attr'    => 'disabled',
                    'default' => '250',
                    'options' => array(
                        '100'  => '100',
                        '250'  => '250',
                        '500'  => '500',
                        '1000' => '1000',
                        '1500' => '1500',
                        '2500' => '2500',
                    ),
                ),
                array(
                    'name'    => 'wcsms_enable_bulksms_with_email',
                    'label'   => __( 'Send Email as well to the selected users' . $newFeature, WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => __( 'Check to send emails/Uncheck to disable', WCSMS_PLUGIN_SLUG ) . $edit_with_pro,
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'css'     => 'pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                $users_settings
            ),
            'customer_settings'  => array(
                array(
                    'name'    => 'wcsms_customer_sms_template_default',
                    'label'   => __( 'Default Customer SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_pending',
                    'label'   => __( 'Pending SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_on-hold',
                    'label'   => __( 'On-hold SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_processing',
                    'label'   => __( 'Processing SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_completed',
                    'label'   => __( 'Completed SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_cancelled',
                    'label'   => __( 'Cancelled SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_refunded',
                    'label'   => __( 'Refunded SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_customer_sms_template_failed',
                    'label'   => __( 'Failed SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Thanks for your purchase, [billing_first_name]. Your order [order_id] is now [order_status].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                )
            ),
            'marketing_settings' => array(
                array(
                    'name'    => 'wcsms_marketing_sms_template_reorder',
                    'label'   => __( 'Order Again SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Would you like to save items from your last order [order_id] so you can easily order it next time?', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_marketing_sms_template_subscription_setup',
                    'label'   => __( 'Subscription SMS Setup Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Would you like to reorder items from your last order [order_id] [frequency]?', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_marketing_sms_template_subscription_sms',
                    'label'   => __( 'Subscription SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : Please pay here to confirm your recurrent order of items from order [order_id].', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                ),
                array(
                    'name'    => 'wcsms_marketing_sms_template_upsell',
                    'label'   => __( 'Upsell SMS Message', WCSMS_PLUGIN_SLUG ) . $pro,
                    'desc'    => 'Personalize your SMS with a <strong>[shortcode]</strong> Characters: <span class="counter bulk_sms_characters_counter"></span>' . $edit_with_pro,
                    'type'    => 'textarea',
                    'default' => __( '[shop_name] : While we get your order [order_id] ready, would you like to add [upsell] for [amount] to the delivery as well?', WCSMS_PLUGIN_SLUG ),
                    'rows'    => '8',
                    'cols'    => '500',
                    'css'     => 'min-width:350px; pointer-events: none;',
                    'attr'    => 'disabled',
                )
            ),
        );
        return apply_filters( 'wcsms_setting_fields', $settings_fields );
    }

    function plugin_page() {
        _e( '<div class="wrap">' );
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '<input type="hidden" value="' . join( ",", $this->get_additional_billing_fields() ) . '" id="usmsgh_new_billing_field" />';
        _e( '</div>' );
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ( $pages as $page ) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }

    function get_additional_billing_fields() {
        $default_billing_fields = array(
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
        );
        $additional_billing_field = [];
        $billing_fields = array_filter( get_option( 'wc_fields_billing', array() ) );
        foreach ( $billing_fields as $field_key => $field_info ) {
            if ( !in_array( $field_key, $default_billing_fields ) && $field_info['enabled'] ) {
                array_push( $additional_billing_field, $field_key );
            }
        }
        return $additional_billing_field;
    }

}
