jQuery.noConflict();

jQuery(document).ready(function($){
    "use strict";


    // Product Listing Isotope

    $('.products-apply-isotope').each(function() {
        if(!$('.products-apply-isotope').hasClass('swiper-wrapper')) {
            $('.products-apply-isotope').isotope({itemSelector : '.dt-col', transformsEnabled:false });
        }
    });


    // On window resize
    $(window).resize(function() {

        // Product Listing Isotope
        $('.products-apply-isotope').each(function() {
            if(!$('.products-apply-isotope').hasClass('swiper-wrapper')) {
                $('.products-apply-isotope').isotope({itemSelector : '.dt-col', transformsEnabled:false });
            }
        });

    });

    $('a.woocommerce-review-link').on('click', function( e ) {
        $( '.reviews_tab a' ).click();
        $('html, body').animate({
            scrollTop: $("#tab-reviews").offset().top - 100
        }, 1000);
        e.preventDefault();
    });

});