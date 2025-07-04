(function ($) {
    "use strict";
	$(document).ready(function () {
        if( $("#primary").hasClass("sidenav-sticky") ) {
            $('.sidenav-sticky .side-navigation').theiaStickySidebar({
                additionalMarginTop: 90,
                containerSelector: $('#primary')
            });    
        }
    });
})(jQuery);