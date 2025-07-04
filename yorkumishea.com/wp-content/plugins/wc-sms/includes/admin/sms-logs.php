<?php if ( !defined( 'ABSPATH' ) ) { exit; }

_e('<div class="wrap">');

echo '<h1>' . __( 'SMS logs', WCSMS_PLUGIN_SLUG ) . '</h1>';

$current_logs = get_option( "wcsms_logs" );
echo '<pre>' . esc_html( $current_logs ) . '</pre>';

_e('</div>');
