app.controller('MainController', function($rootScope, $scope, $timeout, flashService,
	itemTypesService, itemsService, gainTypesService, gainsService, userTabsService) {

	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});

	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});

	$scope.oneAtATime = true;

	//
	// flashes
	//

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

	//
	// items
	//

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

	//
	// gains
	//

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

	//
	// init
	//

	$scope
		.loadItemTypes().loadItems()
		.loadGainTypes().loadGains()
		.loadFlashes();

	//
	// user
	//

	$scope.logout = function() {
		window.location.href = homeUrl + '?logout';
	};
	
	$scope.userTabData = {
		month : {},
		all : {},
		byTypes : {},
	};

	$scope.loadUserTabMonth = function(){
		if (logged) {
			$rootScope.loading = true;

			userTabsService.get('month').then(function(UserTabMonth){
				console.log('UserTabMonth', UserTabMonth);
				
				$scope.userTabData['month'] = UserTabMonth;
				$rootScope.loading = false;
			});
		}
		return $scope;
	};

	$scope.loadUserTabAll = function(){
		if (logged) {
			console.log('todo - loadUserTabAll');
			$scope.userTabData['all'] = {'data': 'todo'};
			$rootScope.loading = false;
		}
		return $scope;
	};
	
	$scope.loadUserTabByTypes = function(){
		if (logged) {
			console.log('todo - loadUserTabByTypes');
			$scope.userTabData['byTypes'] = {'data': 'todo'};
			$rootScope.loading = false;
		}
		return $scope;
	};

	$scope.loadUserTabsData = function(tabName) {
		console.log('load - ' + tabName);

		if (isEmpty($scope.userTabData[tabName])) {
			switch(tabName) {
				case 'month': $scope.loadUserTabMonth(); break;
				case 'all': $scope.loadUserTabAll(); break;
				case 'byTypes': $scope.loadUserTabByTypes(); break;
			}
		}
	};

	//
	// other
	//

	function isEmpty(obj) {
		return Object.keys(obj).length === 0;
	}
});