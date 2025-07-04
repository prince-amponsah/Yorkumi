( function( $ ) {

    var scriptLoaded = false;

	var dtShopProductSingleImages360Viewer = function($scope, $){

		if(scriptLoaded) {
			return;
		}

		scriptLoaded = true;


        // Gallery 360 viewer

        var productImage360Viewer = function () {

            if($('#dt-sc-product-image-360-viewer').length) {
                $('#dt-sc-product-image-360-viewer').dt360Viewer({
                    totalImages:$('#dt-sc-product-image-360-viewer').attr('data-count'),
                });
            }

        };

        productImage360Viewer();


        // Image gallery 360 enlarger

        $('body').on('click', '.dt-sc-product-image-360-viewer-enlarger', function (e) {

            $(this).parents('.dt-sc-product-image-360-viewer-holder').find('.dt-sc-product-image-360-viewer-container').addClass('dt-sc-product-image-360-popup-viewer');
            $(this).parents('.dt-sc-product-image-360-viewer-holder').find('.dt-sc-product-image-360-viewer').attr('id', 'dt-sc-product-image-360-viewer');

            var html_content = $(this).parents('.dt-sc-product-image-360-viewer-holder').find('.dt-sc-product-image-360-viewer-container')[0].outerHTML;
            $('body').append(html_content);

            $(this).parents('.dt-sc-product-image-360-viewer-holder').find('.dt-sc-product-image-360-viewer-container').removeClass('dt-sc-product-image-360-popup-viewer');
            $(this).parents('.dt-sc-product-image-360-viewer-holder').find('.dt-sc-product-image-360-viewer').removeAttr('id');

            productImage360Viewer();

            e.preventDefault();

        });

        $('body').on('click', '.dt-sc-product-image-360-viewer-close', function( e ) {
            $('.dt-sc-product-image-360-popup-viewer').remove();
            e.preventDefault();
        });

	};

    $(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction('frontend/element_ready/dt-shop-product-single-images-360-viewer.default', dtShopProductSingleImages360Viewer);
    });

    dtShopProductSingleImages360Viewer('', $);

} )( jQuery );