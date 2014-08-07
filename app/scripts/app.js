var app = angular.module('FundControlApp', [
	"ngRoute",
	"ngTouch",
	"mobile-angular-ui"
]);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider.when('/', {templateUrl: "views/sections/home.php"});
	$routeProvider.when('/addItem', {templateUrl: "views/sections/addItem.php"});
	$routeProvider.when('/userInfo', {templateUrl: "views/sections/userInfo.php"});
	$routeProvider.when('/items', {templateUrl: "views/sections/items.php"});
	$routeProvider.when('/itemTypes', {templateUrl: "views/sections/itemTypes.php"});
});

/*
app.service('test', [
	'$rootScope', function($rootScope) {
		var login = function(evt, data) {
			console.log('login()');
		}
	}
]);
//*/

app.controller('MainController', function($rootScope, $scope/*, test*/) {

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
});