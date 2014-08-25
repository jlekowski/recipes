angular.module('RecipesCtrl', []).controller('RecipesController', function($scope, $routeParams, $rootScope, Recipes) {
    console.info('RecipesCtrl');

    $scope.init = function () {
        if (!$scope.recipes) {
            Recipes.get().success(function(response) {
                $rootScope.recipes = response;
            });
        }
    };

    $scope.sortColumn = 'name';
    $scope.sortReverse = false;

    $scope.selectRecipe = function(recipe) {
        $rootScope.recipe = recipe;
    };

    $scope.deleteRecipe = function(recipe) {
        $scope.recipes.splice($scope.recipes.indexOf(recipe), 1);
    };

    $scope.init();
});
