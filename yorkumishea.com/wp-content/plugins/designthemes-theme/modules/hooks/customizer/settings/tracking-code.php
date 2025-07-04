<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesTrackingCodeSettings' ) ) {
    class DesignThemesTrackingCodeSettings {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dt_theme_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            /**
             * Load Track code in theme.
             */
            add_action( 'wp_footer', array( $this, 'print_track_code' ), 9999 );
        }

        function default( $option ) {
            $option['enable_track_code'] = 0;
            $option['track_code']        = '';
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new DT_WP_Customize_Section(
                    $wp_customize,
                    'site-track-code-section',
                    array(
                        'title'    => esc_html__('Track Code', 'designthemes-theme'),
                        'panel'    => 'site-hook-main-panel',
                        'priority' => 25,
                    )
                )
            );

                /**
                 * Option : Enable Track Code
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[enable_track_code]', array(
                        'type'    => 'option',
                        'default' => '',
                    )
                );
                
                $wp_customize->add_control(
                    new DT_WP_Customize_Control_Switch(
                        $wp_customize, DT_CUSTOMISER_VAL . '[enable_track_code]', array(
                            'type'        => 'dt-switch',
                            'section'     => 'site-track-code-section',
                            'label'       => esc_html__( 'Enable Tracking Code', 'designthemes-theme' ),
                            'description' => esc_html__('YES! to enable site tracking code.', 'designthemes-theme'),
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                'off' => esc_attr__( 'No', 'designthemes-theme' )
                            )
                        )
                    )
                );

                /**
                 * Option : Track Code
                 */
                $wp_customize->add_setting(
                    DT_CUSTOMISER_VAL . '[track_code]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new DT_WP_Customize_Control(
                        $wp_customize, DT_CUSTOMISER_VAL . '[track_code]', array(
                            'type'        => 'textarea',
                            'section'     => 'site-track-code-section',
                            'label'       => esc_html__( 'Google Analytics Tracking Code', 'designthemes-theme' ),
                            'dependency'  => array( 'enable_track_code', '!=', '' ),
                            'description' => esc_html__('Either enter your Google tracking id (UA-XXXXX-X) here. If you want to offer your visitors the option to stop being tracked you can place the shortcode [dt_sc_privacy_google_tracking] somewhere on your site.', 'designthemes-theme'),
                        )
                    )
                );

        }

        function print_track_code() {
            $enable_code = dt_customizer_settings('enable_track_code');
            $code        = dt_customizer_settings('track_code');

            if( $enable_code && !empty( $code ) ) {

                $tracking_code = "<!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src='https://www.googletagmanager.com/gtag/js?id=".$code."'></script>
                <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '".$code."', { 'anonymize_ip': true });
                </script>";

				$UAID       = false;
				$extra_code = "";
				preg_match("!UA-[0-9]+-[0-9]+!", $tracking_code, $match);
                if(!empty($match) && isset($match[0])) $UAID = $match[0];
                
				if($UAID){
                    $extra_code = "<script>
                    if(document.cookie.match(/dtPrivacyGoogleTrackingDisabled/)){ window['ga-disable-{$UAID}'] = true; }
                    </script>";
                }

                echo ( ( $extra_code . $tracking_code ) );
            }
        }

    }
}

DesignThemesTrackingCodeSettings::instance();