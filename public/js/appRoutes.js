angular.module('appRoutes', []).config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {

    $routeProvider
        .when('/', {
            templateUrl: '/views/recipes.html',
            controller: 'RecipesController'
        }).when('/recipes/:id|/recipe', {
            templateUrl: '/views/recipe.html',
            controller: 'RecipeController'
        }).when('/ingredients', {
            templateUrl: '/views/ingredients.html',
            controller: 'IngredientsController'
        });

    $locationProvider.html5Mode(true);

    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);
