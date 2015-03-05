app.controller('newGainController', ['$rootScope', '$scope', '$http', function($rootScope, $scope, $http) {
	var defaultAddingGain = {
		addNewGain : false,
		name : '',
		gainType: {},
		newTypeName: '',
		amount: '',
	};

	$scope.newGainForm = {};
	$scope.addingGain = defaultAddingGain;
	
	$scope.newGainTypeCheck = function() {
		var gainTypeId = $scope.addingGain.gainType.getId();
		if (gainTypeId === -1) {
			$scope.addingGain.addNewGain = true;
		} else {
			$scope.addingGain.addNewGain = false;
		}
	};

	$scope.saveNewGain = function() {
		$rootScope.loading = true;

		$http({
			method: 'POST',
			url: homeUrl + 'api.php',
			data: {
				action: 'save-new-gain',
				data : $scope.addingGain,
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.success(function(response) {
			if (response.status === 'OK') {
				$scope.clearForm();
				$scope.loadGains();
			}
			$scope.loadGainTypes();
		})
		.finally(function() {
			$rootScope.loading = false;
			$scope.loadFlashes();
		});
	};

	$scope.clearForm = function() {
		$scope.newGainForm.$setPristine();

		$scope.addingGain.addNewGain = false;
		$scope.addingGain.name = '';
		$scope.addingGain.gainType = {};
		$scope.addingGain.newTypeName = '';
		$scope.addingGain.amount = '';

	};
}]);