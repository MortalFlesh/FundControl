app.controller('newItemController', ['$scope', function($scope) {
	$scope.userType = 'guest';
	$scope.addingItem = {
		addNewItem : false,
	};
	
	$scope.newItemTypeCheck = function() {
		var itemTypeId = $scope.addingItem.itemType.getId();
		if (itemTypeId === -1) {
			$scope.addingItem.addNewItem = true;
		} else {
			$scope.addingItem.addNewItem = false;
		}
	};
}]);