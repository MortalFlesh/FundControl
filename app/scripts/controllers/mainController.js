app.controller('MainController', function($rootScope, $scope, itemTypesService) {
	
	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});

	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});

	var scrollItems = [];

	for (var i = 1; i <= 100; i++) {
		scrollItems.push("Item " + i);
	}

	$scope.scrollItems = scrollItems;

	$scope.logout = function() {
		window.location.href = '?logout';
	};

	$scope.itemTypes = itemTypesService.get();
	console.log($scope.itemTypes);
});