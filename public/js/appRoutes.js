angular.module('appRoutes', []).config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {

	$routeProvider
		// home page
//		.when('/', {
//			templateUrl: 'views/home.html',
//			controller: 'MainController'
//		})
//
//		// nerds page that will use the NerdController
//		.when('/nerds', {
//			templateUrl: 'views/nerd.html',
//			controller: 'NerdController'
//		})
		//
		.when('/', {
			templateUrl: 'views/test.html',
			controller: 'TestController'
		});

	$locationProvider.html5Mode(true);
}]);
