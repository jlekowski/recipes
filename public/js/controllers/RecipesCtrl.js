angular.module('RecipesCtrl', []).controller('RecipesController', function($scope, $routeParams, $rootScope, Recipes) {
    console.info('RecipesCtrl');

    $scope.sortColumn = 'name';
    $scope.sortReverse = false;

    Recipes.get().success(function(response) {
        $scope.recipes = response;
    });

    $scope.selectRecipe = function(recipe) {
        $rootScope.recipe = recipe;
    };

    $scope.deleteRecipe = function(recipe, $event) {
        $scope.recipes.splice($scope.recipes.indexOf(recipe), 1);
        $($event.target).closest('tr').remove();
    };
});
