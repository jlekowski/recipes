angular.module('RecipeCtrl', []).controller('RecipeController', function($scope, $routeParams, $rootScope, Recipe, Ingredient, RecipeIngredient) {
    console.info('RecipeCtrl');

    $scope.init = function () {
        if (!$scope.recipe) {
            $scope.recipe = {id: $routeParams.id};

            if (typeof $scope.recipe.id !== 'undefined') {
                Recipe.get($scope.recipe.id).success(function(response) {
                    $scope.recipe = response;
                });
            }
        }

        if (typeof $scope.recipe.id !== 'undefined') {
            // @todo Don't need to load if $rootScope.recipeIngredients[0].recipe_id === $scope.recipe.id
            Recipe.getIngredients($scope.recipe.id).success(function(response) {
                $rootScope.recipeIngredients = response;
                $scope.calculateIngredientTotals();
            });
        }

        if (!$scope.ingredients) {
            Ingredient.getAll().success(function(response) {
                $rootScope.ingredients = response;
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
                // @todo check if angular could round numbers
                totals[j] = Math.round(totals[j] * 100) / 100; // JS strange roundings
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
        // @todo Modal title in the view
        if (recipeIngredient) {
            $scope.recipeIngredient = recipeIngredient;
            $('#recipe-ingredient-add-modal').modal('show').find('.modal-title').text('Edit recipe ingredient');
        } else {
            $scope.recipeIngredient = {recipe_id: $scope.recipe.id};
            $('#recipe-ingredient-add-modal').modal('show').find('.modal-title').text('Add recipe ingredient');
        }
    };

    $scope.saveRecipeIngredient = function() {
        if (typeof $scope.recipeIngredient.id === 'undefined') {
            RecipeIngredient.add($scope.recipeIngredient).success(function(data, status, headers) {
                var recipeIngredient = {}, i;
                $scope.recipeIngredient.id = Number(headers('Location').match(/\d+$/)[0]);

                for (i in $scope.ingredients) {
                    if ($scope.ingredients[i].id === $scope.recipeIngredient.ingredient_id) {
                        recipeIngredient = $.extend($scope.ingredients[i], $scope.recipeIngredient);
                        break;
                    }
                }
                $rootScope.recipeIngredients.push(recipeIngredient);
                $('#recipe-ingredient-add-modal').modal('hide');
            });
        } else {
//            RecipeIngredient.edit($scope.recipeIngredient);
        }
        console.info($scope.recipeIngredient);
    };

    $scope.deleteRecipeIngredient = function() {
        console.info($scope.recipeIngredient.id);
    };

    $scope.init();
});