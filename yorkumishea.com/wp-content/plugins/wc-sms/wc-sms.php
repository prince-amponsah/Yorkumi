<?php

/*
Plugin Name: SMS for WooCommerce
Plugin URI: https://theafricanboss.com/wc-sms
Description: Order SMS Notifications for Woocommerce
Version: 2.8.1.1
Requires PHP: 5.0
Requires at least: 5.0
Tested up to: 6.7.1
WC requires at least: 6.0.0
WC tested up to: 9.4.3
Author: theafricanboss
Author URI: https://theafricanboss.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: wc-sms
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
include_once ABSPATH . '/wp-admin/includes/plugin.php';
$plugin_data = get_plugin_data( __FILE__ );
define( 'WCSMS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WCSMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WCSMS_PLUGIN_DIR_URL', plugins_url( '/', __FILE__ ) );
define( 'WCSMS_PLUGIN_SLUG', explode( "/", WCSMS_PLUGIN_BASENAME )[0] );
define( 'WCSMS_PLUGIN_VERSION', WCSMS_PLUGIN_SLUG . '-' . $plugin_data['Version'] );
define( 'WCSMS_PLUGIN_TEXT_DOMAIN', $plugin_data['TextDomain'] );
define( 'WCSMS_UPGRADE_URL', 'https://theafricanboss.com/freemius/wc-sms' );
if ( function_exists( 'wcsms_fs' ) ) {
    wcsms_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'wcsms_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wcsms_fs() {
            global $wcsms_fs;
            if ( !isset( $wcsms_fs ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_9965_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_9965_MULTISITE', true );
                }
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wcsms_fs = fs_dynamic_init( array(
                    'id'             => '9965',
                    'slug'           => 'wc-sms',
                    'premium_slug'   => 'wc-sms-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_12a521adc557492bebb1c3a870366',
                    'is_premium'     => false,
                    'premium_suffix' => 'PRO',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                        'days'               => 3,
                        'is_require_payment' => true,
                    ),
                    'menu'           => array(
                        'slug'       => 'wcsms-settings',
                        'first-path' => 'admin.php?page=wcsms-settings',
                        'support'    => false,
                    ),
                    'is_live'        => true,
                ) );
            }
            return $wcsms_fs;
        }

        // Init Freemius.
        wcsms_fs();
        // Signal that SDK was initiated.
        do_action( 'wcsms_fs_loaded' );
    }
    if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        // deactivate_plugins( WCSMS_PLUGIN_BASENAME );
        require_once WCSMS_PLUGIN_DIR . 'includes/woo_notice.php';
    }
    // translations
    add_action( 'init', function () {
        load_plugin_textdomain( WCSMS_PLUGIN_SLUG, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    } );
    if ( is_admin() ) {
        add_action( 'plugin_action_links_' . WCSMS_PLUGIN_BASENAME, function ( $links ) {
            global $wcsms_fs;
            $settings_link = '<a href="' . admin_url( 'admin.php?page=wcsms-settings' ) . '">Settings</a>';
            $upgrade_url = wcsms_fs()->get_upgrade_url();
            $promo_links = '<a href="' . $upgrade_url . '" target="_blank" style="color: green; font-weight: bold;">Go Pro</a>';
            array_unshift( $links, $settings_link );
            $links[] = $promo_links;
            return $links;
        } );
        // add_action( 'admin_enqueue_scripts', function () {
        //     $currentScreen = get_current_screen();
        //     // var_dump($currentScreen);
        //     if ($currentScreen->id == 'toplevel_page_wcsms-settings' ) {
        //         wp_register_style( 'jquery-modal', WCSMS_PLUGIN_DIR_URL . 'assets/js/jquery.modal.min.js');
        //         wp_enqueue_style( 'jquery-modal' );
        //         wp_register_style( 'admin-css', WCSMS_PLUGIN_DIR_URL . 'assets/css/jquery.modal.min.css');
        //         wp_enqueue_style( 'admin-css' );
        //         wp_register_style( 'admin-scripts', WCSMS_PLUGIN_DIR_URL . 'assets/js/admin.js');
        //         wp_enqueue_style( 'admin-scripts' );
        //     } else {
        //         return;
        //     }
        // });
    }
    add_action( 'before_woocommerce_init', function () {
        if ( class_exists( Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
            Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
        }
    } );
    add_action( 'plugins_loaded', 'wcsms_woocommerce_init', PHP_INT_MAX );
    function wcsms_woocommerce_init() {
        include_once ABSPATH . '/wp-includes/pluggable.php';
        if ( class_exists( 'WC_Payment_Gateway' ) ) {
            // if ( ! class_exists( 'SplClassLoader', false ) ) { require_once plugin_dir_path( __FILE__ ) . 'twilio-php/vendor/autoload.php'; }
            require_once plugin_dir_path( __FILE__ ) . 'includes/functions/class-wcsms-register-interface.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/functions/class-wcsms-helper.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-wcsms-scripts.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/functions/class-wcsms-hooks.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/functions/class-wcsms-register.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/functions/class-wcsms-settings-functions.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcsms-settings.php';
            require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcsms-sms.php';
            //create notification instance
            $wcsms_notification = new WCSMS_WooCommerce_Notification();
            // if option does not exist, add option
            if ( !get_option( 'wcsms_logs' ) ) {
                add_option( 'wcsms_logs', '' );
            }
            //register hooks and settings
            $registerInstance = new WCSMS_WooCommerce_Register();
            $registerInstance->add( new WCSMS_WooCommerce_Hooks($wcsms_notification) )->add( new WCSMS_WooCommerce_Settings() )->add( new WCSMS_WooCommerce_Frontend_Scripts() )->load();
        } else {
            // deactivate_plugins( WCSMS_PLUGIN_BASENAME );
            require_once WCSMS_PLUGIN_DIR . 'includes/woo_notice.php';
        }
    }

}