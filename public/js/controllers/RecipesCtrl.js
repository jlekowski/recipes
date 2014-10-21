angular.module('RecipesCtrl', []).controller('RecipesController', function($scope, $routeParams, $rootScope, Recipe, Recipes) {
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

    $scope.deleteRecipe = function() {
        Recipe.delete($scope.selectedRecipe.id).success(function() {
            $scope.recipes.splice($scope.recipes.indexOf($scope.selectedRecipe), 1);
            $('#recipe-delete-modal').modal('hide');
        });
    };

    $scope.confirmDeleteRecipe = function(recipe) {
        $scope.selectedRecipe = recipe;
        $('#recipe-delete-modal').modal('show');
    };

    $scope.init();
});
