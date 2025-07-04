jQuery.noConflict();

jQuery(document).ready(function($){
    "use strict";

    var currentWidth = window.innerWidth || document.documentElement.clientWidth;

    if(currentWidth < 1200) {
        $('.product-layout-controller').parents('.product-loop-sorting-item').addClass('hidden');
    }

    if(currentWidth < 768) {
        $('.product-display-controller').parents('.product-loop-sorting-item').addClass('hidden');
    }

    if($('#primary').hasClass('page-with-sidebar')) {
        $('.product-layout-controller').parents('.product-loop-sorting-item').addClass('hidden');
    }


    // Product Change Layout
    if( $('.product-change-layout').length ){
        $('.product-change-layout').find('span').on('click', function(e){

            var this_item = $(this);

            this_item.parents('.container').find('ul.products').addClass('product-loader');


            this_item.parents('.product-change-layout').find('span').removeClass('active');
            this_item.addClass('active');

            if(this_item.parents('section').hasClass('page-with-sidebar')) {

                var $column = this_item.data('column');
                if($column == 1) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12';
                } else if($column == 2) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-6 dt-col-qxlg-6 dt-col-lg-6';
                } else if($column == 3) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4';
                } else if($column == 4) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4';
                }

            } else {

                var $column = this_item.data('column');
                if($column == 1) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12';
                } else if($column == 2) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-6 dt-col-hxlg-6 dt-col-lg-6';
                } else if($column == 3) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4';
                } else if($column == 4) {
                    var $column_class = 'dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-3 dt-col-lg-3';
                }

            }

            var $holder = this_item.parents('.container').find('ul.products .dt-col');

            $holder.removeClass('dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-6 dt-col-qxlg-6 dt-col-lg-6 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-6 dt-col-hxlg-6 dt-col-lg-6 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-3 dt-col-lg-3 first');
            $holder.addClass($column_class);

            setTimeout( function(){
                this_item.parents('.container').find('ul.products').removeClass('product-loader');

                // Product Listing Isotope
                $('.products-apply-isotope').each(function() {
                    if(!$(this).hasClass('swiper-wrapper')) {
                        $(this).isotope({itemSelector : '.dt-col', transformsEnabled:false });
                    }
                });
            }, 400 );

            e.preventDefault();

        });
    }

    // Product List Options
    if( $('.product-list-options').length ){
        $('.product-list-options').find('span').on('click', function(e){

            var this_item = $(this);

            this_item.parents('.container').find('ul.products').addClass('product-loader');


            this_item.parents('.product-list-options').find('span').removeClass('active');
            this_item.addClass('active');


            var $list_option = this_item.data('list-option');
            if($list_option == 'right-thumb') {
                var $list_option_class = 'product-list-right-thumb';
            } else {
                var $list_option_class = 'product-list-left-thumb';
            }

            var $holder = this_item.parents('.container').find('ul.products li.product:not(.product-category)');

            $holder.removeClass('product-list-left-thumb product-list-right-thumb');
            $holder.addClass($list_option_class);

            setTimeout( function(){
                this_item.parents('.container').find('ul.products').removeClass('product-loader');
            }, 600 );

            e.preventDefault();

        });
    }

    // Product Change Display View
    if( $('.product-change-display').length ){
        $('.product-change-display').find('span').on('click', function(e){

            var this_item = $(this);

            this_item.parents('.container').find('ul.products').addClass('product-loader');

            this_item.parents('.product-change-display').find('span').removeClass('active');
            this_item.addClass('active');

            var $display = this_item.data('display');

            if($display == 'list') {
                this_item.parents('.product-loop-sorting').find('.product-layout-controller').addClass('hidden');
                this_item.parents('.product-loop-sorting').find('.product-list-options-controller').removeClass('hidden');
            } else {
                this_item.parents('.product-loop-sorting').find('.product-layout-controller').removeClass('hidden');
                this_item.parents('.product-loop-sorting').find('.product-list-options-controller').addClass('hidden');
            }
            this_item.parents('.product-loop-sorting').find('.product-change-layout span').removeClass('active');
            this_item.parents('.product-loop-sorting').find('.product-change-layout span[data-column=4]').addClass('active');

            this_item.parents('.product-loop-sorting').find('.product-list-options span').removeClass('active');
            this_item.parents('.product-loop-sorting').find('.product-list-options span[data-list-option=left-thumb]').addClass('active');


            var $holder = this_item.parents('.container').find('ul.products li.product');

            $.each( $holder, function( i, val ) {

                $(val).removeClass('product-grid-view product-list-view product-list-left-thumb product-list-right-thumb');

                if(($display == 'list' && $(val).hasClass('product-category')) || $display == 'grid') {

                    $(val).addClass('product-grid-view');

                    $(val).find('.dt-col').removeClass('dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-6 dt-col-qxlg-6 dt-col-lg-6 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-6 dt-col-hxlg-6 dt-col-lg-6 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-3 dt-col-lg-3 first');

                    if(this_item.parents('section').hasClass('page-with-sidebar')) {
                        $(val).find('.dt-col').addClass('dt-col dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4');
                    } else {
                        $(val).find('.dt-col').addClass('dt-col dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-3 dt-col-lg-3');
                    }

                } else {

                    $(val).addClass('product-list-view product-list-left-thumb');

                    $(val).find('.dt-col').removeClass('dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-6 dt-col-qxlg-6 dt-col-lg-6 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-12 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-6 dt-col-hxlg-6 dt-col-lg-6 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-4 dt-col-lg-4 dt-col-xs-12 dt-col-sm-6 dt-col-md-6 dt-col-qxlg-4 dt-col-hxlg-3 dt-col-lg-3 first');
                    $(val).find('.dt-col').addClass('dt-col-xs-12 dt-col-sm-12 dt-col-md-12 dt-col-lg-12');

                }

            });

            setTimeout( function(){
                this_item.parents('.container').find('ul.products').removeClass('product-loader');

                // Product Listing Isotope
                $('.products-apply-isotope').each(function() {
                    if(!$(this).hasClass('swiper-wrapper')) {
                        $(this).isotope({itemSelector : '.dt-col', transformsEnabled:false });
                    }
                });
            }, 400 );

            e.preventDefault();

        });
    }

});