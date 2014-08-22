angular.module('appRoutes', []).config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {

    $routeProvider
        // home page
//        .when('/', {
//            templateUrl: 'views/home.html',
//            controller: 'MainController'
//        })
//
//        // nerds page that will use the NerdController
//        .when('/nerds', {
//            templateUrl: 'views/nerd.html',
//            controller: 'NerdController'
//        })
        //
        .when('/', {
            templateUrl: '/views/recipes.html',
            controller: 'RecipesController'
        }).when('/recipes/:id', {
            templateUrl: '/views/recipe.html',
            controller: 'RecipeController'
        });

    $locationProvider.html5Mode(true);

    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);
