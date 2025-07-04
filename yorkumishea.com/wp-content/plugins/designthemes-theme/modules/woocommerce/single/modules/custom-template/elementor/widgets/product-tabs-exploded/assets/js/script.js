( function( $ ) {

	var dtShopProductSingleTabsExploded = function($scope, $){

    if($('.dt-sc-content-scroll').length) {
        $('.dt-sc-content-scroll').niceScroll({ cursorcolor:"#000", cursorwidth: "2px", background:"rgba(20,20,20,0.3)", cursorborder:"none" });
    }

    $('.elementor-tab-title').each(function() {
      if($(this).parents('.elementor-toggle-item, .elementor-accordion-item').find('.dt-sc-content-scroll').length) {
          $(this).on('click', function( e ) {
            setTimeout( function(){
              window.dispatchEvent(new Event('resize'));
          }, 600 );
          });
      }
    });

    $('.woocommerce-tabs li a').each(function() {
      if($(this).parents('.elementor').find('.dt-sc-content-scroll').length) {
          $(this).on('click', function( e ) {
            setTimeout( function(){
              window.dispatchEvent(new Event('resize'));
          }, 600 );
          });
      }
    });

  };

  $(window).on('elementor/frontend/init', function(){
    elementorFrontend.hooks.addAction('frontend/element_ready/dt-shop-product-single-tabs-exploded.default', dtShopProductSingleTabsExploded);
  });

} )( jQuery );