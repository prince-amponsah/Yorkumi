// Tabs Js
(function ($) {

	var dtTabsWidgetHandler = function($scope, $){

		var tabsElement = $scope.find('ul.dt-sc-tab-titles').each(function(){
			jQuery(this).dtTabs('> .dt-sc-tab-content', {
				effect: 'fade'
			});
		});

	};

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction('frontend/element_ready/dt-tabs.default', dtTabsWidgetHandler);

	});

})(jQuery);