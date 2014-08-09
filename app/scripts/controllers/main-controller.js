app.controller('MainController', function($rootScope, $scope, $timeout, itemTypesService, flashService, FlashMessage) {

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

	$scope.addFlashMessage = function(message, type){
		var flashes = [];
		flashes.push(FlashMessage.build({message:message, type:type}));
		$scope.flashes = flashes;
	};

	var scrollItems = [];

	for (var i = 1; i <= 100; i++) {
		scrollItems.push("Item " + i);
	}

	$scope.scrollItems = scrollItems;

	$scope.loadItemTypes();
	$scope.loadFlashes();
});