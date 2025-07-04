jQuery.noConflict();

jQuery(document).ready(function($){
    "use strict";

    // Color Picker
    if($('.dtshop-color-picker-alpha').length) {
        $('.dtshop-color-picker-alpha').wpColorPicker();
    }

});