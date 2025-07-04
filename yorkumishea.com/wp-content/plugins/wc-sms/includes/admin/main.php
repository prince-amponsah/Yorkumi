<?php if ( !defined( 'ABSPATH' ) ) { exit; }

_e('<div class="wrap">');

echo '<h1>' . __( 'SMS for Woocommerce', WCSMS_PLUGIN_SLUG ) . '</h1>';

$this->settings_api->show_navigation();
$this->settings_api->show_forms();
echo '<input type="hidden" value="' . join(",", $this->get_additional_billing_fields()) . '" id="wcsms_new_billing_field" />';

_e('</div>');