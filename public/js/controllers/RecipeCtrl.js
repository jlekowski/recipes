angular.module('RecipeCtrl', []).controller('RecipeController', function($scope, $routeParams, $rootScope, Recipe) {
    console.info('RecipeCtrl');

    $scope.init = function () {
        $scope.recipe = $rootScope.recipe ? $rootScope.recipe : {};

        if (typeof $scope.recipe.id === 'undefined' && $routeParams.id) {
            $scope.recipe.id = $routeParams.id;
        }

        if (typeof $scope.recipe.id !== 'undefined') {
            Recipe.get($scope.recipe.id).success(function(response) {
                $scope.recipe = response;
            });

            Recipe.getIngredients($scope.recipe.id).success(function(response) {
                $scope.recipeIngredients = response;
                $scope.calculateIngredientTotals();
            });
        }
    };

    $scope.getIngredientValueForWeight = function(recipeIngredient, value) {
        return Math.round(recipeIngredient[value] * recipeIngredient.weight) / 100;
    };

    $scope.calculateIngredientTotals = function() {
        var totals = {weight: 0, kcal: 0, protein: 0, fat: 0, carb: 0},
            recipeIngredient, i, j;
        for (i in $scope.recipeIngredients) {
            recipeIngredient = $scope.recipeIngredients[i];
            for (j in totals) {
                totals[j] += (j === 'weight')
                    ? Number(recipeIngredient[j])
                    : $scope.getIngredientValueForWeight(recipeIngredient, j);
            }
        }

        $scope.ingredientTotals = totals;
        $scope.calculateIngredientTotalsPer100();
    };

    $scope.calculateIngredientTotalsPer100 = function() {
        var totals = ['kcal', 'protein', 'fat', 'carb'],
            total, per100, i;

        for (i in totals) {
            total = totals[i];
            per100 = total + '100';
            $scope.ingredientTotals[per100] = Math.round($scope.ingredientTotals[total] / $scope.ingredientTotals.weight * 10000) / 100;
        }
    };

    console.log('$routeParams.id: ' + $routeParams.id);
//    console.log($rootScope.recipe);

    $scope.init();
});
