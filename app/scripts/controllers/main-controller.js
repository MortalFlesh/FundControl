app.controller('MainController', function($rootScope, $scope, $timeout, flashService,
	itemTypesService, itemsService, gainTypesService, gainsService) {

	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});

	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});

	$scope.logout = function() {
		window.location.href = homeUrl + '?logout';
	};

	$scope.loadFlashes = function() {
		flashService.get()
		.then(function(FlashMessages){
			$scope.flashes = FlashMessages.getFlashMessages();
		})
		.then(function(){
			$timeout(function(){
				$scope.flashes = {};
			}, 6000);
		});
		return $scope;
	};

	$scope.loadItemTypes = function() {
		if (logged) {
			itemTypesService.get().then(function(ItemTypes){
				$scope.itemTypes = ItemTypes.getItemTypes();
			});
		}
		return $scope;
	};

	$scope.loadItems = function() {
		if (logged) {
			itemsService.get().then(function(Items){
				$scope.items = Items.getItems();
			});
		}
		return $scope;
	};

	$scope.loadGainTypes = function() {
		if (logged) {
			gainTypesService.get().then(function(GainTypes){
				$scope.gainTypes = GainTypes.getGainTypes();
			});
		}
		return $scope;
	};

	$scope.loadGains = function() {
		if (logged) {
			gainsService.get().then(function(Gains){
				$scope.gains = Gains.getGains();
			});
		}
		return $scope;
	};

	$scope.oneAtATime = true;

	$scope
		.loadItemTypes().loadItems()
		.loadGainTypes().loadGains()
		.loadFlashes();
});