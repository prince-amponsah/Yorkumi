<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
        wp_body_open();

        // Hook to add additional content after body tag open.
        do_action( 'savon_hook_top' ); ?>

    <!-- **Wrapper** -->
    <div class="wrapper">

        <!-- ** Inner Wrapper ** -->
        <div class="inner-wrapper">

            <?php do_action( 'savon_hook_content_before' ); ?>

            <!-- ** Header Wrapper ** -->
            <div id="header-wrapper" class="<?php echo esc_attr( savon_get_header_wrapper_classes() ); ?>">

                <!-- **Header** -->
                    <?php do_action( 'savon_header' ); ?>
                <!-- **Header - End ** -->

                <!-- ** Slider ** -->
                    <?php do_action( 'savon_slider' ); ?>

                <!-- ** Slider End ** -->

                <!-- ** Breadcrumb ** -->
                    <?php do_action( 'savon_breadcrumb' ); ?>
                <!-- ** Breadcrumb End ** -->

            </div><!-- ** Header Wrapper - End ** -->

            <!-- **Main** -->
            <div id="main">
                <!-- ** Container ** -->
                <div class="container">