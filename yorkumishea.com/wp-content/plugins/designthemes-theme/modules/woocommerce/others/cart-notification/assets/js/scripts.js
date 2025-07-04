jQuery.noConflict();

jQuery(document).ready(function($){
    "use strict";

    // After adding product to cart
    $('body').on('added_to_cart', function(e) {

        if($('.dt-sc-shop-cart-widget').hasClass('activate-sidebar-widget')) {

            $('.dt-sc-shop-cart-widget').addClass('dt-sc-shop-cart-widget-active');
            $('.dt-sc-shop-cart-widget-overlay').addClass('dt-sc-shop-cart-widget-active');

            // Nice scroll script

            var winHeight = $(window).height();
            var headerHeight = $('.dt-sc-shop-cart-widget-header').height();
            var footerHeight = $('.woocommerce-mini-cart-footer').height();

            var height = parseInt((winHeight-headerHeight-footerHeight), 10);

            $('.dt-sc-shop-cart-widget-content').height(height).niceScroll({ cursorcolor:"#000", cursorwidth: "5px", background:"rgba(20,20,20,0.3)", cursorborder:"none" });

        }

        if($('.dt-sc-shop-cart-widget').hasClass('cart-notification-widget')) {

            $('.dt-sc-shop-cart-widget').addClass('dt-sc-shop-cart-widget-active');
            $('.dt-sc-shop-cart-widget-overlay').addClass('dt-sc-shop-cart-widget-active');
            setTimeout( function(){
                $('.dt-sc-shop-cart-widget').removeClass('dt-sc-shop-cart-widget-active');
                $('.dt-sc-shop-cart-widget-overlay').removeClass('dt-sc-shop-cart-widget-active');
            }, 2400 );

        }

        e.preventDefault();
    });

    $('body').on('click', '.dt-sc-shop-cart-widget-close-button, .dt-sc-shop-cart-widget-overlay', function( e ) {
        $('.dt-sc-shop-cart-widget').removeClass('dt-sc-shop-cart-widget-active');
        $('.dt-sc-shop-cart-widget-overlay').removeClass('dt-sc-shop-cart-widget-active');
        e.preventDefault();
    });

});