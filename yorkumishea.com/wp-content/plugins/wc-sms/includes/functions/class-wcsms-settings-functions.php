<?php if ( !defined( 'ABSPATH' ) ) { exit; }

if ( !class_exists( 'WCSMS_Settings_API' ) ):
class WCSMS_Settings_API {

    /**
     * settings sections array
     *
     * @var array
     */
    protected $settings_sections = array();

    /**
     * Settings fields array
     *
     * @var array
     */
    protected $settings_fields = array();

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    /**
     * Enqueue scripts and styles
     */
    function admin_enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
    }

    /**
     * Set settings sections
     *
     * @param array   $sections setting sections array
     */
    function set_sections( $sections ) {
        $this->settings_sections = $sections;

        return $this;
    }

    /**
     * Add a single section
     *
     * @param array   $section
     */
    function add_section( $section ) {
        $this->settings_sections[] = $section;

        return $this;
    }

    /**
     * Set settings fields
     *
     * @param array   $fields settings fields array
     */
    function set_fields( $fields ) {
        $this->settings_fields = $fields;

        return $this;
    }

    function add_field( $section, $field ) {
        $defaults = array(
            'name'  => '',
            'label' => '',
            'desc'  => '',
            'type'  => 'text'
        );

        $arg = wp_parse_args( $field, $defaults );
        $this->settings_fields[$section][] = $arg;

        return $this;
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     */
    function admin_init() {
        //register settings sections
        foreach ( $this->settings_sections as $section ) {
            if ( false == get_option( $section['id'] ) ) {
                add_option( $section['id'] );
            }

            if ( isset($section['desc']) && !empty($section['desc']) ) {
                $section['desc'] = '<div class="inside">'.$section['desc'].'</div>';
//                $callback = create_function('', 'echo "'.str_replace('"', '\"', $section['desc']).'";');
                $callback = create_function('', _e(str_replace('"', '\"', $section['desc'])));
            } else if ( isset( $section['callback'] ) ) {
                $callback = $section['callback'];
            } else {
                $callback = null;
            }

            add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
        }

        //register settings fields
        foreach ( $this->settings_fields as $section => $field ) {
            foreach ( $field as $option ) {

                $type = isset( $option['type'] ) ? $option['type'] : 'text';

                $args = array(
                    'id'                => $option['name'],
                    'label_for'         => $args['label_for'] = "{$section}[{$option['name']}]",
                    'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
                    'name'              => $option['label'],
                    'section'           => $section,
                    'size'              => isset( $option['size'] ) ? $option['size'] : null,
                    'options'           => isset( $option['options'] ) ? $option['options'] : '',
                    'std'               => isset( $option['default'] ) ? $option['default'] : '',
                    'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
                    'type'              => $type,
                    'rows'              => isset( $option['rows'] ) ? $option['rows'] : null,
                    'cols'              => isset( $option['cols'] ) ? $option['cols'] : null,
                    'css'               => isset( $option['css'] ) ? $option['css'] : null,
                    'attr'               => isset( $option['attr'] ) ? $option['attr'] : null,
                );

                add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], array( $this, 'callback_' . $type ), $section, $section, $args );
            }
        }

        // creates our settings in the options table
        foreach ( $this->settings_sections as $section ) {
            register_setting( $section['id'], $section['id'], array( $this, 'wcsms_sanitize_options' ) );
        }
    }

    /**
     * Get field description for display
     *
     * @param array   $args settings field args
     */
    public function get_field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
            $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        } else {
            $desc = '';
        }

        return $desc;
    }

    /**
     * Displays a text field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_text( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $type  = isset( $args['type'] ) ? $args['type'] : 'text';

        $html  = sprintf( '<input ' . $args['attr'] . ' type="%1$s" class="%2$s-text" id="' . $args['id'] . '" name="%3$s[%4$s]" value="%5$s"/>', $type, $size, $args['section'], $args['id'], $value );
        $html  .= $this->get_field_description( $args );

        _e($html);
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_textarea( $args ) {

        $value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $rows  = isset( $args['rows'] ) && !is_null( $args['rows'] ) ? $args['rows'] : '5';
        $cols  = isset( $args['cols'] ) && !is_null( $args['cols'] ) ? $args['cols'] : '55';
        $css  = isset( $args['css'] ) && !is_null( $args['css'] ) ? 'style="'.$args['css'].';"' : '';

        $html  = sprintf( '<textarea ' . $args['attr'] . ' rows="'.$rows.'" cols="'.$cols.'" class="%1$s-text" style="height:80px" '.$css.' id="%3$s" name="%2$s[%3$s]">%4$s</textarea>', $size, $args['section'], $args['id'], $value );
        $html  .= $this->get_field_description( $args );

        _e($html);
    }

    /**
     * Displays a url field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_url( $args ) {
        $this->callback_text( $args );
    }

    /**
     * Displays a number field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_number( $args ) {
        $this->callback_text( $args );
    }

    /**
     * Displays a checkbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_checkbox( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html  = '<fieldset>';
        // $html  .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
        // $html  .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        // $html  .= sprintf( '<input ' . $args['attr'] . ' type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );

        $html  .= sprintf( '<label for="%1$s[%2$s]">', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html  .= sprintf( '<input ' . $args['attr'] . ' type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
        $html  .= sprintf( '%1$s</label>', $args['desc'] );
        $html  .= '</fieldset>';

        _e($html);
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_multicheck( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';

        foreach ( $args['options'] as $key => $label ) {
            $checked = isset( $value[$key] ) ? $value[$key] : '0';
        // $html    .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
        // $html    .= sprintf( '<input ' . $args['attr'] . ' type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );

            $html    .= sprintf( '<label for="%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html    .= sprintf( '<input ' . $args['attr'] . ' type="checkbox" class="checkbox ' . $args['id'] . '" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html    .= sprintf( '%1$s</label><br>',  $label );
        }

        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';

        _e($html);
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_radio( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';

        foreach ( $args['options'] as $key => $label ) {
            // $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">',  $args['section'], $args['id'], $key );
            // $html .= sprintf( '<input ' . $args['attr'] . ' type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );

            $html .= sprintf( '<label for="%1$s[%2$s][%3$s]">',  $args['section'], $args['id'], $key );
            $html .= sprintf( '<input ' . $args['attr'] . ' type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '%1$s</label><br>', $label );
        }

        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';

        _e($html);
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_select( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $html  = sprintf( '<select ' . $args['attr'] . ' id="%2$s[%3$s]" name="%2$s[%3$s]" class="%1$s">', $size, $args['section'], $args['id'] );

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
        }

        $html .= sprintf( '</select>' );
        $html .= $this->get_field_description( $args );

        _e($html);
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     * @return string
     */
    function callback_html( $args ) {
        _e($this->get_field_description( $args ));
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_wysiwyg( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';

        _e('<div style="max-width: ' . $size . ';">');

        $editor_settings = array(
            'teeny'         => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10
        );

        if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
            $editor_settings = array_merge( $editor_settings, $args['options'] );
        }

        wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

        _e('</div>');

        _e($this->get_field_description( $args ));
    }

    /**
     * Displays a file upload field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_file( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $id    = $args['section']  . '[' . $args['id'] . ']';
        $label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File' );

        $html  = sprintf( '<input type="text" class="%1$s-text wcsms-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= '<input type="button" class="button wcsms-browse" value="' . $label . '" />';
        $html  .= $this->get_field_description( $args );

        _e($html);
    }

    /**
     * Displays a password field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_password( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input ' . $args['attr'] . ' type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= $this->get_field_description( $args );

        _e($html);
    }

    /**
     * Displays a color picker field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_color( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input ' . $args['attr'] . ' type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
        $html  .= $this->get_field_description( $args );

        _e($html);
    }

    /**
     * Sanitize callback for Settings API
     */
    function wcsms_sanitize_options( $options ) {
        foreach( $options as $option_slug => $option_value ) {
            $sanitize_callback = $this->get_sanitize_callback( $option_slug );

            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) ) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach( $this->settings_fields as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug ) {
                    continue;
                }

                // Return the callback name
                return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
            }
        }

        return false;
    }

    /**
     * Get the value of a settings field
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    function get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }

        return $default;
    }

    /**
     * Show navigations as tab
     *
     * Shows all the settings section labels as tab
     */
    function show_navigation() {
        $html = '<h2 class="nav-tab-wrapper">';

        foreach ( $this->settings_sections as $tab ) {
            $html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
        }

        $html .= '</h2>';

        _e($html);
    }

    /**
     * Show the section settings forms
     *
     * This function displays every sections in a different form
     */
    function show_forms() { ?>
        <div class="container metabox-holder">
            <style>
                .wcsms-shortcodes {
                    width:100%; padding: 1em;
                }
                .wcsms-settings-form {
                    width:100%; padding: 1em;
                }

                @media (min-width: 1024px) {
                    .align-top {
                        display: flex;
                        flex-direction: row;
                        align-items: flex-start;
                    }
                    .wcsms-shortcodes {
                        width:45%;
                    }
                    .wcsms-settings-form {
                        width:45%;
                    }
                }
            </style>

            <div class="wcsms-dialog">
                <dialog id="favDialog">
                <form method="dialog">
                    <p>
                    <label>Select where to start checking</label>
                    <input type="number" id="check-start" name="check-start" value="0">
                    </p>
                    <div>
                    <button value="cancel">Cancel</button>
                    <button id="confirmBtn" value="default">Confirm</button>
                    </div>
                </form>
                </dialog>
                <p class="output"></p>

                <output></output>
            </div>

			<?php foreach ( $this->settings_sections as $form ) { ?>
				<div id="<?php _e($form['id']); ?>" class="group align-top" style="display: none;">
					<form method="post" action="options.php" class="wcsms-settings-form">
						<?php
						do_action( 'wsa_form_top_' . $form['id'], $form );
						settings_fields( $form['id'] );
						do_settings_sections( $form['id'] );
						do_action( 'wsa_form_bottom_' . $form['id'], $form );
						?>
						<div style="padding-left: 10px">
							<?php submit_button(); ?>
						</div>
					</form>


                    <?php echo '<div class="wcsms-shortcodes">' . $this->display_shortcodes() . '</div>'; ?>

				</div>
			<?php } ?>
        </div>
        <?php
        $this->script();
    }

    function display_shortcodes() {
        $domain = !empty(parse_url(get_bloginfo('url'))) ? parse_url(get_bloginfo('url'))['host'] : null;

		$shortcodes_html = '<br><br>
		<h1>' . esc_html__( 'Shortcodes with Output examples', WCSMS_PLUGIN_SLUG ) . '</h1><br>
		<h2>' . esc_html__( 'Shop Details', WCSMS_PLUGIN_SLUG ) . '</h2>
		<code>[shop_name]</code>    : ' . get_bloginfo( 'name' ) . '<br>
		<code>[shop_email]</code>    : ' . get_bloginfo( 'admin_email' ) . '<br>
		<code>[shop_url]</code>    : ' . $domain . '<br>
		<h2>' . esc_html__( 'User Details (for customers and non-customers)', WCSMS_PLUGIN_SLUG ) . '</h2>';

        // global $current_user;
		$current_user = wp_get_current_user();
		$shortcodes_html .= '
		<code>[first_name]</code>    : ' . $current_user->first_name . '<br>
		<code>[last_name]</code>    : ' . $current_user->last_name . '<br><br>
		<p><span style="color:red;">-></span> <em>' . esc_html__( 'A user can have a profile name but use a different name when shopping (buying for someone else or using another card)', WCSMS_PLUGIN_SLUG ) . '</em></p>
		<h2>' . esc_html__( 'Customer Details (from billing info during checkout)', WCSMS_PLUGIN_SLUG ) . '</h2>';

		$current_user_id = $current_user->ID;
		$shortcodes_html .= '
		<code>[customer_first_name]</code>    : ' . get_user_meta( $current_user_id, 'billing_first_name', true ) . '<br>
		<code>[customer_last_name]</code>    : ' . get_user_meta( $current_user_id, 'billing_last_name', true ) . '<br>
		<code>[customer_phone]</code>    : ' . get_user_meta( $current_user_id, 'billing_phone', true ) . '<br>
		<code>[customer_email]</code>    : ' . get_user_meta( $current_user_id, 'billing_email', true ) . '<br>
		<code>[customer_company]</code>    : ' . get_user_meta( $current_user_id, 'billing_company', true ) . '<br>
		<code>[customer_address]</code>    : ' . get_user_meta( $current_user_id, 'billing_address_1', true ) . '<br>
		<code>[customer_city]</code>    : ' . get_user_meta( $current_user_id, 'billing_city', true ) . '<br>
		<code>[customer_state]</code>    : ' . get_user_meta( $current_user_id, 'billing_state', true ) . '<br>
		<code>[customer_country]</code>    : ' . get_user_meta( $current_user_id, 'billing_country', true ) . '<br>
		<code>[customer_postcode]</code>    : ' . get_user_meta( $current_user_id, 'billing_postcode', true ) . '<br>';

		$shortcodes_html .= '<h2>' . __( 'Order Details', WCSMS_PLUGIN_SLUG ) . '</h2>';

		$orders = wc_get_orders( array('type' => 'shop_order') );
		$order = $orders[0];
		if ( $order ) {
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

            $order_id = $order->get_id();
			$order_number = method_exists($order, 'get_order_number') ? $order->get_order_number() : $order_id;

            $amount = $order->get_total();
            $currency = $order->get_currency();
            // $total = "$amount $currency";
            // $total = $order->get_formatted_order_total();
            $total = $order->get_total();

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
				$payment_url = esc_html__( 'Send Zelle payment to', WCSMS_PLUGIN_SLUG ) . ': ';
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

			$shortcodes_html .= '
			<code>[order_id]</code>    : ' . $order_id . '<br>
			<code>[order_number]</code>    : ' . $order_number . '<br>
			<code>[order_currency]</code>    : ' . $order->get_currency() . '<br>
			<code>[order_amount]</code>    : ' . $order->get_total() . '<br>
			<code>[order_currency]</code>    : ' . $order->get_currency() . '<br>
			<code>[order_status]</code>    : ' . $order->get_status() . '<br>
			<code>[order_items]</code>    : ' . $product_names . '<br>
			<code>[order_items_with_qty]</code>    : ' . $products_with_qty . '<br>
			<code>[order_items_count]</code>    : ' . count($order->get_items()) . '<br>
			<code>[order_shipping_method]</code>    : ' . $order->get_shipping_method() . '<br>
			<code>[order_payment_method]</code>    : ' . $order->get_payment_method_title() . '<br>
			<code>[order_date]</code>    : ' . $order->get_date_created()->date( 'm-d-Y' ) . '<br>
			<code>[order_url]</code>    : <a href="' . $order->get_checkout_order_received_url() . '" target="_blank">' . $order->get_checkout_order_received_url() . '</a><br>
			<code>[order_cancel_url]</code>    : <a href="' . $order->get_cancel_order_url() . '" target="_blank">' . $order->get_cancel_order_url() . '</a><br>
			<code>[order_payment_url]</code>    : <a href="' . $payment_url . '" target="_blank">' . $payment_url . '</a><br>
            ';
		} else {
			$shortcodes_html .= '
			<code>[order_id]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_number]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_currency]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_amount]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_currency]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_status]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_items]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_items_with_qty]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_items_count]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_shipping_method]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_payment_method]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_date]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_url]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_cancel_url]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
			<code>[order_payment_url]</code>    : ' . esc_html__( 'No order found', WCSMS_PLUGIN_SLUG ) . '<br>
            ';
		}
        return $shortcodes_html;
    }

    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script() {
        ?>
        <script>
            jQuery(document).ready(function($) {

                 $('#select-all-users').click(function() {
                    var selectedElements = document.getElementsByClassName( "wcsms_enable_bulksms_on_users" );
                    for (var i = 0; i < selectedElements.length; i++) {
                        selectedElements[i].checked = true;
                    }
                    $('.count-selected-users').html(`${selectedElements.length}`);
                });

                 $('#unselect-all-users').click(function() {
                    var selectedElements = document.getElementsByClassName( "wcsms_enable_bulksms_on_users" );
                    for (var i = 0; i < selectedElements.length; i++) {
                        selectedElements[i].checked = false;
                    }
                    $('.count-selected-users').html(`0`);
                });

                var selectedElements = document.getElementsByClassName( "wcsms_enable_bulksms_on_users" );
                var countSelectedUsers = 0;
                for (var i = 0; i < selectedElements.length; i++) {
                    if (selectedElements[i].checked == true) {
                        countSelectedUsers++;
                    }
                }
                $('.count-selected-users').html(`${countSelectedUsers}`);
                $('.wcsms_enable_bulksms_on_users').click(function() {
                    var selectedElements = document.getElementsByClassName( "wcsms_enable_bulksms_on_users" );
                    var countSelectedUsers = 0;
                    for (var i = 0; i < selectedElements.length; i++) {
                        if (selectedElements[i].checked == true) {
                            countSelectedUsers++;
                        }
                    }
                    $('.count-selected-users').html(`${countSelectedUsers}`);
                });

                char_counters = $(".bulk_sms_characters_counter");
                char_counters.each(function(index, value) {
                    // console.log($(this).parent().parent().find("textarea").val().length);
                    var textarea = $(this).parent().parent().find("textarea");
                    var char_length = textarea.val().length;
                    $(char_counters[index]).text(char_length);
                    textarea.keyup(function() {
                        var char_length = textarea.val().length;
                        $(char_counters[index]).text(char_length);
                    });
                });

                $('form').submit(function(e) {
                    $(':disabled').each(function(e) {
                        $(this).hide();
                        $(this).removeAttr('disabled');
                    })
                });

                $('#sms-dialog').click(function() {
                    var start = 0;
                    const startEl = document.getElementById('check-start');
                    const favDialog = document.getElementById('favDialog');
                    const confirmBtn = favDialog.querySelector('#confirmBtn');
                    const outputBox = document.querySelector('p.output');
                    // If a browser doesn't support the dialog, then hide the dialog contents by default.
                    if (typeof favDialog.showModal !== 'function') {
                      favDialog.hidden = true;
                        outputBox.innerHtml = "Sorry, the <dialog> API is not supported by this browser.";
                        console.log("Sorry, the <dialog> API is not supported by this browser.");
                      /* a fallback script to allow this dialog/form to function for legacy browsers that do not support <dialog> could be provided here.
                       */
                       return;
                    }

                    if (typeof favDialog.showModal === "function") {
                      favDialog.showModal();
                    } else {
                      outputBox.innerHtml = "Sorry, the <dialog> API is not supported by this browser.";
                      console.log("Sorry, the <dialog> API is not supported by this browser.");
                    }

                    // input sets the value of the submit button
                    startEl.addEventListener('change', function onChange(e) {
                        // confirmBtn.value = startEl.value;
                        // outputParagraphBox.innerHtml = startEl.value;
                        console.log(startEl.value);
                        start = parseInt(startEl.value);
                    });
                    // "Confirm" button of form triggers "close" on dialog because of [method="dialog"]
                    favDialog.addEventListener('close', function onClose() {
                        // outputParagraphBox.innerHtml = startEl.value;
                        console.log(startEl.value);
                        var selectedElements = document.getElementsByClassName( "wcsms_enable_bulksms_on_users" );
                        start = parseInt(startEl.value);
                        if ( start < selectedElements.length ) {
                            var end = start + parseInt(document.getElementById("bulksms_settings[wcsms_bulk_sms_limit]").value);
                            if (selectedElements.length < end ) {
                                end = selectedElements.length;
                            }
                            var lastElement;
                            console.log(start, end);
                            for (var i = start; i < end; i++) {
                                console.debug(i, selectedElements[i]);
                                selectedElements[i].checked = true;
                                lastElement = selectedElements[i];
                            }
                            console.log(lastElement);
                            lastElement.scrollIntoView();
                            // document.getElementById("submit").scrollIntoView();
                        } else {
                            outputBox.innerHtml = `<strong>Your starting point at ${start} is above ${selectedElements.length}, the number of available users. Try again</strong>`;
                            outputBox.scrollIntoView();
                        }
                    });
                });

                //Initiate Color Picker
                $('.wp-color-picker-field').wpColorPicker();

                // Switches option sections
                $('.group').hide();
                var activetab = '';
                if (typeof(localStorage) != 'undefined' ) {
                    activetab = localStorage.getItem("activetab");
                }
                if (activetab != '' && $(activetab).length ) {
                    $(activetab).fadeIn();
                } else {
                    $('.group:first').fadeIn();
                }
                $('.group .collapsed').each(function(){
                    $(this).find('input:checked').parent().parent().parent().nextAll().each(
                    function(){
                        if ($(this).hasClass('last')) {
                            $(this).removeClass('hidden');
                            return false;
                        }
                        $(this).filter('.hidden').removeClass('hidden');
                    });
                });

                if (activetab != '' && $(activetab + '-tab').length ) {
                    $(activetab + '-tab').addClass('nav-tab-active');
                }
                else {
                    $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                }
                $('.nav-tab-wrapper a').click(function(evt) {
                    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active').blur();
                    var clicked_group = $(this).attr('href');
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", $(this).attr('href'));
                    }
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                    evt.preventDefault();
                });

                $('.tab-href').click(function(evt) {
                    // get href value
                    var href = $(this).attr('href').replace('<?php echo admin_url( 'admin.php?page=wcsms-settings#' ); ?>', '');
                    console.log(href);
                    $('.nav-tab-active').removeClass('nav-tab-active');
                    var tab = `#${href}-tab`;
                    console.log(tab);
                    $(tab).addClass('nav-tab-active').blur();
                    console.log($(tab));
                    var clicked_group = $(tab).attr('href');
                    console.log(clicked_group);
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", $(tab).attr('href'));
                    }
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                    evt.preventDefault();
                });

                $('.wcsms-browse').on('click', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    // Create the media frame.
                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('uploader_title'),
                        button: {
                            text: self.data('uploader_button_text'),
                        },
                        type : 'image', //audio, video, application/pdf, ... etc
                        multiple: false,
                        // allowLocalEdits: true,
                        // displaySettings: true,
                        // displayUserSettings: true,
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();

                        self.prev('.wcsms-url').val(attachment.url);
                    });

                    // Finally, open the modal
                    file_frame.open();
                });
        });
        </script>

        <style type="text/css">
            .counter {
                color: #0073aa;
                font-weight: bold;
            }
            /** WordPress 3.8 Fix **/
            .form-table th { padding: 20px 10px; }
            #wpbody-content .metabox-holder { padding-top: 5px; }
        </style>
        <?php
    }

}
endif;
