app.controller('newItemController', ['$rootScope', '$scope', '$http', function($rootScope, $scope, $http) {
	var defaultAddingItem = {
		addNewItem : false,
		name : '',
		itemType: {},
		newTypeName: '',
		amount: '',
	};

	$scope.newItemForm = {};
	$scope.addingItem = defaultAddingItem;
	
	$scope.newItemTypeCheck = function() {
		var itemTypeId = $scope.addingItem.itemType.getId();
		if (itemTypeId === -1) {
			$scope.addingItem.addNewItem = true;
		} else {
			$scope.addingItem.addNewItem = false;
		}
	};

	$scope.saveNewItem = function() {
		$rootScope.loading = true;

		$http({
			method: 'POST',
			url: homeUrl + 'api.php',
			data: {
				action: 'save-new-item',
				data : $scope.addingItem,
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.success(function(response) {
			if (response.status === 'OK') {
				$scope.clearForm();
				$scope.loadItems();
			}
			$scope.loadItemTypes();
		})
		.finally(function() {
			$rootScope.loading = false;
			$scope.loadFlashes();
		});
	};

	$scope.clearForm = function() {
		$scope.newItemForm.$setPristine();

		$scope.addingItem.addNewItem = false;
		$scope.addingItem.name = '';
		$scope.addingItem.itemType = {};
		$scope.addingItem.newTypeName = '';
		$scope.addingItem.amount = '';

	};
}]);