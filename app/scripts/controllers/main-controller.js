app.controller('MainController', function($rootScope, $scope, $timeout,
	itemTypesService, flashService, itemsService) {

	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});

	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});

	$scope.logout = function() {
		window.location.href = '?logout';
	};

	$scope.loadFlashes = function() {
		flashService.get()
			.then(function(FlashMessages){
				$scope.flashes = FlashMessages.getFlashMessages();
			})
			.then(function(){
				$timeout(function(){
					$scope.flashes = {};
				}, 3000);
			});
	};

	$scope.loadItemTypes = function() {
		itemTypesService.get().then(function(ItemTypes){
			$scope.itemTypes = ItemTypes.getItemTypes();
		});
	};

	$scope.loadItems = function() {
		itemsService.get().then(function(Items){
			$scope.items = Items.getItems();
		});
	};

	$scope.oneAtATime = true;

	$scope.loadItemTypes();
	$scope.loadFlashes();
	$scope.loadItems();
});