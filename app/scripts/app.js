var app = angular.module('FundControlApp', [
	"ngRoute",
	"ngTouch",
	"mobile-angular-ui",
	"ui.bootstrap", // http://angular-ui.github.io/bootstrap/
]);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider.when('/', {templateUrl: homeUrl + "views/sections/home.php"});
	$routeProvider.when('/addItem', {templateUrl: homeUrl + "views/sections/addItem.php"});
	$routeProvider.when('/userInfo', {templateUrl: homeUrl + "views/sections/userInfo.php"});
	$routeProvider.when('/items', {templateUrl: homeUrl + "views/sections/items.php"});
	$routeProvider.when('/itemTypes', {templateUrl: homeUrl + "views/sections/itemTypes.php"});
});