app.controller('MainController', function($rootScope, $scope, itemTypesService, flashService, $interval) {
	var flashesInterval;

	var getFlashes = function() {
		flashService.get().then(function(FlashMessages){
			$scope.flashes = FlashMessages.getFlashMessages();
		});
	};
	
	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});

	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});

	$scope.logout = function() {
		if (angular.isDefined(flashesInterval)) {
			$interval.cancel(flashesInterval);
			flashesInterval = undefined;
		}

		window.location.href = '?logout';
	};

	var scrollItems = [];

	for (var i = 1; i <= 100; i++) {
		scrollItems.push("Item " + i);
	}

	$scope.scrollItems = scrollItems;

	itemTypesService.get().then(function(ItemTypes){
		$scope.itemTypes = ItemTypes.getItemTypes();
	});

	getFlashes();
	if (logged) {
		flashesInterval = $interval(getFlashes, 5000);
	}
});