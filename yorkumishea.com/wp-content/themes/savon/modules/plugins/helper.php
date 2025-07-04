<?php
require_once SAVON_MODULE_DIR . '/plugins/class-tgm-plugin-activation.php';

if( !function_exists('savon_register_required_plugins') ) {

    function savon_register_required_plugins() {

        $url = 'https://api.wordpress.org/plugins/info/1.0/unyson';
        $api_response = wp_remote_get( $url );
        if ( is_array( $api_response ) && ! is_wp_error( $api_response ) ) {
            if( isset($api_response['response']) && !empty($api_response['response']) ) {
                if ( 404 == $api_response['response']['code'] && 'Not Found' == $api_response['response']['message'] ) {
                    $unyson_plugin = array(
                        array(
                            'name'               => esc_html__('Unyson', 'savon'),
                            'slug'               => 'unyson',
                            'source'             => SAVON_MODULE_DIR . '/plugins/unyson.zip',
                            'required'           => true,
                            'version'            => '2.7.28',
                            'force_activation'   => false,
                            'force_deactivation' => false,
                        )
                    );
                } else {
                    $unyson_plugin = array(
                        array(
                            'name'     => esc_html__('Unyson', 'savon'),
                            'slug'     => 'unyson',
                            'required' => true,
                        )
                    );
                }
            }
        }

        $plugins = array(
            array(
                'name'               => esc_html__('DesignThemes Framework', 'savon'),
                'slug'               => 'designthemes-framework',
                'source'             => SAVON_MODULE_DIR . '/plugins/designthemes-framework.zip',
                'required'           => true,
                'version'            => '1.6',
                'force_activation'   => false,
                'force_deactivation' => false,
            ),    
            array(
                'name'               => esc_html__('DesignThemes Theme', 'savon'),
                'slug'               => 'designthemes-theme',
                'source'             => SAVON_MODULE_DIR . '/plugins/designthemes-theme.zip',
                'required'           => false,
                'version'            => '1.6',
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('DesignThemes Shop', 'savon'),
                'slug'               => 'designthemes-shop',
                'source'             => SAVON_MODULE_DIR . '/plugins/designthemes-shop.zip',
                'required'           => false,
                'version'            => '1.1',
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('DesignThemes Portfolio', 'savon'),
                'slug'               => 'designthemes-portfolio',
                'source'             => SAVON_MODULE_DIR . '/plugins/designthemes-portfolio.zip',
                'required'           => false,
                'version'            => '1.3',
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('DesignThemes Twitter', 'savon'),
                'slug'               => 'designthemes-twitter',
                'source'             => SAVON_MODULE_DIR . '/plugins/designthemes-twitter.zip',
                'required'           => false,
                'version'            => '1.0',
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('DesignThemes Flickr', 'savon'),
                'slug'               => 'designthemes-flickr',
                'source'             => SAVON_MODULE_DIR . '/plugins/designthemes-flickr.zip',
                'required'           => false,
                'version'            => '1.0',
                'force_activation'   => false,
                'force_deactivation' => false,
            ),            
            array(
                'name'     => esc_html__('Elementor', 'savon'),
                'slug'     => 'elementor',
                'required' => true,
            ),

            array(
                'name'     => esc_html__('Qi Addons For Elementor', 'savon'),
                'slug'     => 'qi-addons-for-elementor',
                'required' => true,
            ),

            array(
                'name'     => esc_html__('Woocommerce', 'savon'),
                'slug'     => 'woocommerce',
                'required' => true,
            ),

            array(
                'name'     => esc_html__('Contact Form 7', 'savon'),
                'slug'     => 'contact-form-7',
                'required' => false,
            )  
        );

        /*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */

    $plugins = array_merge( $unyson_plugin, $plugins );
	$config = array(
		'id'           => 'savon',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );        
    }

    add_action( 'tgmpa_register', 'savon_register_required_plugins' );
}