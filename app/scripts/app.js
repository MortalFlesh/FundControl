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