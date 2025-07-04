jQuery.noConflict();
jQuery(document).ready(function($) {

    "use strict";

    jQuery('.dtportfolio-container-fullpage').each(function() {

        var $setttings_obj = jQuery(this).attr('data-settings');
        var $setttings     = jQuery.parseJSON($setttings_obj);

        var $navigation = false;
        var $navigation_position = '';
        if($setttings['fullpage_navigation_position'] != '') {
            var $navigation = true;
            var $navigation_position = $setttings['fullpage_navigation_position'];
        }

        var $auto_scrolling = ($setttings['fullpage_disable_auto_scrolling'] == 'true') ? false : true;

        jQuery(this).fullpage({
            navigation        : $navigation,
            navigationPosition: $navigation_position,
            autoScrolling     : $auto_scrolling,
            scrollHorizontally: true
        });

    });

});