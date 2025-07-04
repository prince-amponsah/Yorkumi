<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesMailchimpWidget' ) ) {
    class DesignThemesMailchimpWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );

            add_action( 'wp_ajax_dt_theme_mailchimp_subscribe', array( $this, 'dt_theme_mailchimp_subscribe' ) );
            add_action( 'wp_ajax_nopriv_dt_theme_mailchimp_subscribe', array( $this, 'dt_theme_mailchimp_subscribe' ) );
        }

        function register_widgets( $widgets_manager ) {
            require DT_THEME_DIR_PATH. 'modules/shortcodes/elementor/widgets/mailchimp/class-widget-mailchimp.php';
            $widgets_manager->register( new \Elementor_Mailchimp() );
        }

        function register_widget_styles() {
            wp_register_style( 'dt-mailchimp',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/mailchimp/style.css', array(), DT_THEME_VERSION );
        }

        function register_widget_scripts() {
            wp_register_script( 'dt-mailchimp',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/mailchimp/script.js', array(), DT_THEME_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'dt-mailchimp' );
            wp_enqueue_script( 'dt-mailchimp' );
        }

        function dt_theme_mailchimp_subscribe() {

            $out    = '';
            $apiKey = $_REQUEST['mc_apikey'];
            $listId = $_REQUEST['mc_listid'];

            if($apiKey != '' && $listId != '') {
                $data = array();
                $data = array('email' => sanitize_email($_REQUEST['mc_email']), 'status' => 'subscribed');

                if($this->dt_theme_mailchimp_check_member_already_registered($data, $apiKey, $listId)) {
                    $out = '<span class="error-msg"><b>'.esc_html__('Error:', 'designthemes-theme').'</b> '.esc_html__('You have already subscribed with us !', 'designthemes-theme').'</span>';
                } else {
                    $out = $this->dt_theme_mailchimp_register_member($data, $apiKey, $listId);
                }
            } else {
                $out = '<span class="error-msg"><b>'.esc_html__('Error:', 'designthemes-theme').'</b> '.esc_html__('Please make sure valid mailchimp details are provided.', 'designthemes-theme').'</span>';
            }

            echo $out;
            die();
        }

        function dt_theme_mailchimp_check_member_already_registered($data, $apiKey, $listId) {

            $memberId = md5(strtolower($data['email']));
            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members';

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);
            curl_close($ch);

            $result_decode = json_decode($result, true);

            foreach($result_decode['members'] as $key => $value) {
                if($value['email_address'] == $data['email']) {
                    return true;
                }
            }

            return false;
        }

        function dt_theme_mailchimp_register_member($data, $apiKey, $listId) {

            $memberId = md5(strtolower($data['email']));
            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

            $temp = array( 'email_address' => $data['email'], 'status' => $data['status'] );
            $json = '';

            $json = json_encode( array( 'email_address' => $data['email'], 'status' => $data['status'] ));

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result_decode = json_decode($result, true);

            if($httpCode == 200) {
                $out = '<span class="success-msg">'.esc_html__('Success! Please check your inbox or spam folder.', 'designthemes-theme').'</span>';
            } else {
                $out = '<span class="error-msg"><b>'.$result_decode['title'].':</b> '.$result_decode['detail'].'</span>';
            }

            return $out;
        }
    }
}

DesignThemesMailchimpWidget::instance();