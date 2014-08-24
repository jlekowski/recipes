angular.module('RecipeCtrl', []).controller('RecipeController', function($scope, $routeParams, $rootScope, Recipe) {
    console.info('RecipeCtrl');

    $scope.init = function () {
        if (!$scope.recipe) {
            $scope.recipe = $rootScope.recipe ? $rootScope.recipe : {};
        }

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

        $scope.ingredients = [{id: 1, name: "number1"}, {id: 2, name: "number2"}];
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

    $scope.save = function() {
        if ($scope.recipe.id) {
            Recipe.edit($scope.recipe).success(function() {
                console.info('edited');
            });
        } else {
            Recipe.add($scope.recipe).success(function(data, status, headers, config) {
                console.info('added');
                $scope.recipe.id = Number(headers('Location').match(/\d+$/)[0]);
            });
        }
    };

    $scope.addRecipeIngredient = function(recipeIngredient) {
        $('#recipe-ingredient-add-modal').modal('show').find('.modal-title').text('Add recipe ingredient');
        if (recipeIngredient) {
            $scope.recipeIngredient = recipeIngredient;
            console.info(recipeIngredient);
        }
    };

    $scope.saveRecipeIngredient = function() {
        console.info($scope.recipeIngredient);
    };

    $scope.deleteRecipeIngredient = function() {
        console.info($scope.recipeIngredient.id);
    };

    $scope.init();
});
