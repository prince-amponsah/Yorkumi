<?php

/**
 * WooCommerce - Single - Module - Social Share & Follow - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Customizer_Single_Social_Share_And_Follow' ) ) {

    class Dt_Shop_Customizer_Single_Social_Share_And_Follow {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'savon_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_show_sharer_facebook                = dt_customizer_settings('dt-single-product-show-sharer-facebook' );
            $settings['product_show_sharer_facebook']    = $product_show_sharer_facebook;

            $product_show_sharer_delicious               = dt_customizer_settings('dt-single-product-show-sharer-delicious' );
            $settings['product_show_sharer_delicious']   = $product_show_sharer_delicious;

            $product_show_sharer_digg                    = dt_customizer_settings('dt-single-product-show-sharer-digg' );
            $settings['product_show_sharer_digg']        = $product_show_sharer_digg;

            $product_show_sharer_twitter                 = dt_customizer_settings('dt-single-product-show-sharer-twitter' );
            $settings['product_show_sharer_twitter']     = $product_show_sharer_twitter;

            $product_show_sharer_linkedin                = dt_customizer_settings('dt-single-product-show-sharer-linkedin' );
            $settings['product_show_sharer_linkedin']    = $product_show_sharer_linkedin;

            $product_show_sharer_pinterest               = dt_customizer_settings('dt-single-product-show-sharer-pinterest' );
            $settings['product_show_sharer_pinterest']   = $product_show_sharer_pinterest;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Share
            */

                /**
                * Option : Sharer Description
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-description]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-description]', array(
                                'type'        => 'dt-description',
                                'label'       => esc_html__( 'Note: ', 'designthemes-theme'),
                                'section'     => 'woocommerce-single-page-sociable-share-section',
                                'description' => esc_html__( 'This option is applicable only for WooCommerce "Custom Template".', 'designthemes-theme')
                            )
                        )
                    );

                /**
                * Option : Show Facebook Sharer
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-facebook]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-facebook]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Facebook Sharer', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Delicious Sharer
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-delicious]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-delicious]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Delicious Sharer', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Digg Sharer
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-digg]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-digg]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Digg Sharer', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Twitter Sharer
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-twitter]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-twitter]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Twitter Sharer', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show LinkedIn Sharer
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-linkedin]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-linkedin]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show LinkedIn Sharer', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Pinterest Sharer
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-pinterest]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-sharer-pinterest]', array(
                                'type'    => 'dt-switch',
                                'label'   => esc_html__( 'Show Pinterest Sharer', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                    'off' => esc_attr__( 'No', 'designthemes-theme' )
                                )
                            )
                        )
                    );

            /**
            * Follow
            */

                /**
                * Option : Follow Description
                */
                    $wp_customize->add_setting(
                        DT_CUSTOMISER_VAL . '[dt-single-product-show-follow-description]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new DT_WP_Customize_Control_Switch(
                            $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-follow-description]', array(
                                'type'    => 'dt-description',
                                'label'   => esc_html__( 'Note :', 'designthemes-theme'),
                                'section' => 'woocommerce-single-page-sociable-follow-section',
                                'description'   => esc_html__( 'This option is applicable only for WooCommerce "Custom Template".', 'designthemes-theme'),
                            )
                        )
                    );

                    $social_follow = array (
                        'delicious'   => esc_html__('Delicious', 'designthemes-theme'),
                        'deviantart'  => esc_html__('Deviantart', 'designthemes-theme'),
                        'digg'        => esc_html__('Digg', 'designthemes-theme'),
                        'dribbble'    => esc_html__('Dribbble', 'designthemes-theme'),
                        'envelope'    => esc_html__('Envelope', 'designthemes-theme'),
                        'facebook'    => esc_html__('Facebook', 'designthemes-theme'),
                        'flickr'      => esc_html__('Flickr', 'designthemes-theme'),
                        'google-plus' => esc_html__('Google Plus', 'designthemes-theme'),
                        'gtalk'       => esc_html__('GTalk', 'designthemes-theme'),
                        'instagram'   => esc_html__('Instagram', 'designthemes-theme'),
                        'lastfm'      => esc_html__('Lastfm', 'designthemes-theme'),
                        'linkedin'    => esc_html__('Linkedin', 'designthemes-theme'),
                        'myspace'     => esc_html__('Myspace', 'designthemes-theme'),
                        'picasa'      => esc_html__('Picasa', 'designthemes-theme'),
                        'pinterest'   => esc_html__('Pinterest', 'designthemes-theme'),
                        'reddit'      => esc_html__('Reddit', 'designthemes-theme'),
                        'rss'         => esc_html__('RSS', 'designthemes-theme'),
                        'skype'       => esc_html__('Skype', 'designthemes-theme'),
                        'stumbleupon' => esc_html__('Stumbleupon', 'designthemes-theme'),
                        'technorati'  => esc_html__('Technorati', 'designthemes-theme'),
                        'tumblr'      => esc_html__('Tumblr', 'designthemes-theme'),
                        'twitter'     => esc_html__('Twitter', 'designthemes-theme'),
                        'viadeo'      => esc_html__('Viadeo', 'designthemes-theme'),
                        'vimeo'       => esc_html__('Vimeo', 'designthemes-theme'),
                        'yahoo'       => esc_html__('Yahoo', 'designthemes-theme'),
                        'youtube'     => esc_html__('Youtube', 'designthemes-theme')
                    );

                    foreach($social_follow as $socialfollow_key => $socialfollow) {

                        $wp_customize->add_setting(
                            DT_CUSTOMISER_VAL . '[dt-single-product-show-follow-'.$socialfollow_key.']', array(
                                'type' => 'option'
                            )
                        );

                        $wp_customize->add_control(
                            new DT_WP_Customize_Control_Switch(
                                $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-show-follow-'.$socialfollow_key.']', array(
                                    'type'    => 'dt-switch',
                                    'label'   => sprintf(esc_html__('Show %1$s Follow', 'designthemes-theme'), $socialfollow),
                                    'section' => 'woocommerce-single-page-sociable-follow-section',
                                    'choices' => array(
                                        'on'  => esc_attr__( 'Yes', 'designthemes-theme' ),
                                        'off' => esc_attr__( 'No', 'designthemes-theme' )
                                    )
                                )
                            )
                        );

                        $wp_customize->add_setting(
                            DT_CUSTOMISER_VAL . '[dt-single-product-follow-'.$socialfollow_key.'-link]', array(
                                'type' => 'option'
                            )
                        );

                        $wp_customize->add_control(
                            new DT_WP_Customize_Control(
                                $wp_customize, DT_CUSTOMISER_VAL . '[dt-single-product-follow-'.$socialfollow_key.'-link]', array(
                                    'type'       => 'text',
                                    'section'    => 'woocommerce-single-page-sociable-follow-section',
                                    'input_attrs' => array(
                                        'placeholder' => sprintf(esc_html__('%1$s Link', 'designthemes-theme'), $socialfollow)
                                    ),
                                    'dependency' => array ( 'dt-single-product-show-follow-'.$socialfollow_key, '==', '1' )
                                )
                            )
                        );

                    }

        }

    }

}


if( !function_exists('dt_shop_customizer_single_social_share_and_follow') ) {
	function dt_shop_customizer_single_social_share_and_follow() {
		return Dt_Shop_Customizer_Single_Social_Share_And_Follow::instance();
	}
}

dt_shop_customizer_single_social_share_and_follow();