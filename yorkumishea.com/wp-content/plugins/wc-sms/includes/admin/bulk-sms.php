<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
_e( '<div class="wrap">' );
echo '<h1>' . $GLOBALS['title'] . '</h1>';
$template_name = 'wcsms_bulk_sms_template';
$wcsms_send_action = 'wcsms_send_bulk_sms';
$redirect = esc_html( urlencode( $_SERVER['REQUEST_URI'] ) );
$message = wcsms_get_option( 'wcsms_bulk_sms_template', 'bulksms_settings', '' );
$user_role = wcsms_get_option( 'wcsms_enable_bulksms_on_user_roles', 'bulksms_settings', '' );
global $wcsms_fs;
$upgrade_url = wcsms_fs()->get_upgrade_url();
$submit_with_pro = '<br><a href="' . esc_url( $upgrade_url ) . '" class="button button-primary">' . __( 'UNLOCK Bulk SMS/Emails', WCSMS_PLUGIN_SLUG ) . '</a><br>';
if ( $message && $user_role ) {
    echo '<h2>' . esc_html__( 'Selected Message Template', WCSMS_PLUGIN_SLUG ) . '</h2>';
    echo '<p>' . esc_html__( $message, WCSMS_PLUGIN_SLUG ) . '</p>';
    echo '<a href="' . admin_url( 'admin.php?page=wcsms-settings#bulksms_settings&tab=bulksms_settings' ) . '" class="button button-secondary">' . esc_html__( 'Setup Bulk SMS/Emails', WCSMS_PLUGIN_SLUG ) . '</a>';
    $all_ids_array = wcsms_get_option( 'wcsms_enable_bulksms_on_users', 'bulksms_settings', '' );
    // print_r( $all_ids_array );
    $users_array = get_users( array(
        'role' => $user_role,
    ) );
    // $users_array = get_users( "&role= $user_role");
    if ( !empty( $all_ids_array ) && $user_role != "customer" ) {
        ?>

    <form action="<?php 
        echo admin_url( 'admin-post.php' );
        ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
        echo $wcsms_send_action;
        ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
        echo $redirect;
        ?>">
        <?php 
        wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
        ?>
        <?php 
        echo $submit_with_pro;
        ?>
    </form>

    <?php 
        echo '<h2>' . esc_html__( 'Selected List of ', WCSMS_PLUGIN_SLUG ) . count( $all_ids_array ) . '</h2>';
        echo '<ul>';
        $count = 0;
        foreach ( $all_ids_array as $userid ) {
            $customer_info = get_userdata( $userid );
            if ( !empty( get_user_meta( $userid, 'billing_phone', true ) ) ) {
                echo '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . get_user_meta( $userid, 'billing_phone', true ) . '</strong></li>';
            } else {
                if ( !empty( $customer_info->user_phone ) || !empty( $customer_info->phone ) ) {
                    echo ( '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . $customer_info->user_phone ? $customer_info->user_phone : $customer_info->phone . '</strong></li>' );
                } else {
                    echo '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . esc_html__( 'No Phone Number found - Will be skipped and email with SMS will be sent instead', WCSMS_PLUGIN_SLUG ) . '</strong></li>';
                }
            }
        }
        echo '</ul>';
        ?>

    <form action="<?php 
        echo admin_url( 'admin-post.php' );
        ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
        echo $wcsms_send_action;
        ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
        echo $redirect;
        ?>">
        <?php 
        wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
        ?>
        <?php 
        echo $submit_with_pro;
        ?>
    </form>

    <?php 
    } else {
        if ( !empty( $all_ids_array ) && $user_role == "customer" ) {
            ?>

    <form action="<?php 
            echo admin_url( 'admin-post.php' );
            ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
            echo $wcsms_send_action;
            ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
            echo $redirect;
            ?>">
        <?php 
            wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
            ?>
        <?php 
            echo $submit_with_pro;
            ?>
    </form>

    <?php 
            echo '<h2>' . esc_html__( 'Selected List of ', WCSMS_PLUGIN_SLUG ) . count( $all_ids_array ) . '</h2>';
            echo '<ul>';
            $count = 0;
            foreach ( $all_ids_array as $g_order_id ) {
                $user_phone = null;
                $user_first_name = null;
                if ( substr( $g_order_id, 0, 1 ) == 'g' ) {
                    $order_id = substr( $g_order_id, 1 );
                    $order = wc_get_order( $order_id );
                    $user_email = $order->get_billing_email();
                    $user_phone = $order->get_billing_phone();
                    $user_first_name = $order->get_billing_first_name();
                    $user_last_name = $order->get_billing_last_name();
                } else {
                    $user_id = $g_order_id;
                    $customer_info = get_userdata( $user_id );
                    if ( !empty( get_user_meta( $user_id, 'billing_phone', true ) ) ) {
                        $user_phone = get_user_meta( $user_id, 'billing_phone', true );
                    } else {
                        if ( !empty( $customer_info->user_phone ) || !empty( $customer_info->phone ) ) {
                            $user_phone = ( $customer_info->user_phone ? $customer_info->user_phone : $customer_info->phone );
                        }
                    }
                    if ( !empty( get_user_meta( $user_id, 'billing_email', true ) ) ) {
                        $user_email = get_user_meta( $user_id, 'billing_email', true );
                    } else {
                        if ( !empty( $customer_info->user_email ) || !empty( $customer_info->email ) ) {
                            $user_email = ( $customer_info->user_email ? $customer_info->user_email : $customer_info->email );
                        }
                    }
                    $user_first_name = ( $customer_info->first_name ? $customer_info->first_name : get_user_meta( $user_id, 'billing_first_name', true ) );
                    $user_last_name = ( $customer_info->last_name ? $customer_info->last_name : get_user_meta( $user_id, 'billing_last_name', true ) );
                }
                if ( $user_phone && $user_email ) {
                    echo '<li>' . esc_html( $user_first_name ) . " " . esc_html( $user_last_name ) . ' - <strong>' . $user_phone . '</strong> - <strong>' . $user_email . '</strong></li>';
                } else {
                    if ( !$user_phone && $user_email ) {
                        echo '<li>' . esc_html( $user_first_name ) . " " . esc_html( $user_last_name ) . ' - <strong>' . $user_email . '</strong> - <strong>' . esc_html__( 'No phone number found - Will be skipped and email with SMS will be sent instead', WCSMS_PLUGIN_SLUG ) . '</strong></li>';
                    } else {
                        echo '<li>' . esc_html( $user_first_name ) . " " . esc_html( $user_last_name ) . ' - <strong>' . esc_html__( 'No Phone Number or Email found - Will be skipped', WCSMS_PLUGIN_SLUG ) . '</strong></li>';
                    }
                }
            }
            echo '</ul>';
            ?>

    <form action="<?php 
            echo admin_url( 'admin-post.php' );
            ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
            echo $wcsms_send_action;
            ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
            echo $redirect;
            ?>">
        <?php 
            wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
            ?>
        <?php 
            echo $submit_with_pro;
            ?>
    </form>

    <?php 
        } else {
            if ( empty( $all_ids_array ) && $user_role == "customer" ) {
                ?>

    <form action="<?php 
                echo admin_url( 'admin-post.php' );
                ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
                echo $wcsms_send_action;
                ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
                echo $redirect;
                ?>">
        <?php 
                wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
                ?>
        <?php 
                echo $submit_with_pro;
                ?>
    </form>

    <?php 
                echo '<h2>' . esc_html__( 'Selected List of ', WCSMS_PLUGIN_SLUG ) . count( $users_array ) . '</h2>';
                echo '<ul>';
                $count = 0;
                foreach ( $users_array as $customer ) {
                    $customer_info = get_userdata( $customer->ID );
                    if ( !empty( get_user_meta( $customer->ID, 'billing_phone', true ) ) ) {
                        echo '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . get_user_meta( $customer->ID, 'billing_phone', true ) . '</strong></li>';
                    } else {
                        if ( !empty( $customer_info->user_phone ) || !empty( $customer_info->phone ) ) {
                            echo ( '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . $customer_info->user_phone ? $customer_info->user_phone : $customer_info->phone . '</strong></li>' );
                        } else {
                            echo '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . esc_html__( 'No Phone Number found - Will be skipped', WCSMS_PLUGIN_SLUG ) . '</strong></li>';
                        }
                    }
                }
                $wcsms_enable_guest_customers = wcsms_get_option( 'wcsms_enable_guest_customers', 'bulksms_settings', '' );
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
                    echo '<br><br><li><strong>Notice about guests below:</strong> they must be explicitly selected or will be skipped because <br>' . 'they are taken from guest orders and might be duplicate (a customer with 3 pending orders will be sent 3 different SMS/Emails messages instantly about their 3 orders and so on.)<br>' . '<a href="' . admin_url( 'admin.php?page=wcsms-settings#bulksms_settings&tab=bulksms_settings' ) . '">' . esc_html__( 'Select guest users here', WCSMS_PLUGIN_SLUG ) . '</a></li><br>';
                    global $wpdb;
                    foreach ( $selected_orders as $order ) {
                        $order_id = esc_html( $order->get_id() );
                        $billing_first_name = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_first_name'", $order_id ) )->meta_value;
                        $billing_last_name = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_last_name'", $order_id ) )->meta_value;
                        $billing_email = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_email'", $order_id ) )->meta_value;
                        $billing_phone = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '%s' && meta_key = '_billing_phone'", $order_id ) )->meta_value;
                        if ( $billing_phone && $billing_email ) {
                            echo '<li>' . esc_html( $billing_first_name ) . " " . esc_html( $billing_last_name ) . ' - <strong>' . $billing_phone . '</strong> - <strong>' . $billing_email . '</strong> - <span style="color:red">guest will be skipped.</span></li>';
                        } else {
                            if ( !$billing_phone && $billing_email ) {
                                echo '<li>' . esc_html( $billing_first_name ) . " " . esc_html( $billing_last_name ) . ' - <strong>' . $billing_email . '</strong> - <span style="color:red">guest will be skipped.</span></li>';
                            } else {
                                echo '<li>' . esc_html( $billing_first_name ) . " " . esc_html( $billing_last_name ) . ' - <strong>' . esc_html__( 'No Phone Number or Email found - Will be skipped', WCSMS_PLUGIN_SLUG ) . '</strong></li>';
                            }
                        }
                    }
                }
                echo '</ul>';
                ?>

    <form action="<?php 
                echo admin_url( 'admin-post.php' );
                ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
                echo $wcsms_send_action;
                ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
                echo $redirect;
                ?>">
        <?php 
                wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
                ?>
        <?php 
                echo $submit_with_pro;
                ?>
    </form>

    <?php 
            } else {
                if ( !empty( $users_array ) ) {
                    ?>

    <form action="<?php 
                    echo admin_url( 'admin-post.php' );
                    ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
                    echo $wcsms_send_action;
                    ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
                    echo $redirect;
                    ?>">
        <?php 
                    wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
                    ?>
        <?php 
                    echo $submit_with_pro;
                    ?>
    </form>

    <?php 
                    echo '<h2>' . esc_html__( 'Selected List of ', WCSMS_PLUGIN_SLUG ) . count( $users_array ) . '</h2>';
                    echo '<ul>';
                    $count = 0;
                    foreach ( $users_array as $customer ) {
                        $customer_info = get_userdata( $customer->ID );
                        if ( !empty( get_user_meta( $customer->ID, 'billing_phone', true ) ) ) {
                            echo '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . get_user_meta( $customer->ID, 'billing_phone', true ) . '</strong></li>';
                        } else {
                            if ( !empty( $customer_info->user_phone ) || !empty( $customer_info->phone ) ) {
                                echo ( '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . $customer_info->user_phone ? $customer_info->user_phone : $customer_info->phone . '</strong></li>' );
                            } else {
                                echo '<li>' . esc_html( $customer_info->first_name ) . " " . esc_html( $customer_info->last_name ) . ' - <strong>' . esc_html__( 'No Phone Number found - Will be skipped', WCSMS_PLUGIN_SLUG ) . '</strong></li>';
                            }
                        }
                    }
                    echo '</ul>';
                    ?>

    <form action="<?php 
                    echo admin_url( 'admin-post.php' );
                    ?>" method="POST">
        <input type="hidden" name="action" value="<?php 
                    echo $wcsms_send_action;
                    ?>">
        <input type="hidden" name="_wp_http_referer" value="<?php 
                    echo $redirect;
                    ?>">
        <?php 
                    wp_nonce_field( $wcsms_send_action, $template_name . '_nonce', FALSE );
                    ?>
        <?php 
                    echo $submit_with_pro;
                    ?>
    </form>

    <?php 
                } else {
                    echo '<h2>' . esc_html__( 'Selected List', WCSMS_PLUGIN_SLUG ) . '</h2>';
                    echo '<p>' . esc_html__( 'No user selected. Please select users first', WCSMS_PLUGIN_SLUG ) . '</p>';
                }
            }
        }
    }
} else {
    echo '<h2>' . esc_html__( 'Bulk Message Template', WCSMS_PLUGIN_SLUG ) . '</h2>';
    echo '<p>' . esc_html__( 'No template or user role has been saved yet. Please save your template or user role first', WCSMS_PLUGIN_SLUG ) . '</p>';
}
echo '<br><br><h2>' . esc_html__( 'Check SMS/Emails logs', WCSMS_PLUGIN_SLUG ) . '</h2>';
echo '<a href="' . admin_url( 'admin.php?page=wcsms_logs' ) . '" class="button button-secondary">' . esc_html__( 'SMS and/or Email logs', WCSMS_PLUGIN_SLUG ) . '</a>';
_e( '</div>' );