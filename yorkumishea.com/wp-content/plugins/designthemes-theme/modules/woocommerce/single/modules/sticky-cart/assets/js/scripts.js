jQuery.noConflict();

jQuery(document).ready(function($){

    "use strict";

    $('body').on('click', '.dt-sc-shop-single-sticky-addtocart-section a.product_type_variable.add_to_cart_button', function (e) {
        $('html, body').animate({
            scrollTop: $('.summary.entry-summary').offset().top
        }, 800);
        e.preventDefault();
    });

    var stickyAddToCartToggle = function () {

        var $trigger = $('.entry-summary .cart');
        var $stickyBtn = $('.dt-sc-shop-single-sticky-addtocart-container');

        if ($stickyBtn.length <= 0 || $trigger.length <= 0 || ($(window).width() <= 768 && $stickyBtn.hasClass('mobile-off'))) return;

        var summaryOffset = $trigger.offset().top + $trigger.outerHeight();
        var $scrollToTop = $('#toTop');

        var windowScroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        var documentHeight = $(document).height();

        if (summaryOffset < windowScroll && windowScroll + windowHeight != documentHeight) {
            $stickyBtn.addClass('dt-sc-shop-sticky-enabled');
            $scrollToTop.addClass('dt-sc-shop-sticky-enabled');

        } else if (windowScroll + windowHeight == documentHeight || summaryOffset > windowScroll) {
            $stickyBtn.removeClass('dt-sc-shop-sticky-enabled');
            $scrollToTop.removeClass('dt-sc-shop-sticky-enabled');
        }

    };

    stickyAddToCartToggle();

    $(window).scroll(stickyAddToCartToggle);

});