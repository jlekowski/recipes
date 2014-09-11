angular.module('RecipeCtrl', []).controller('RecipeController', function($scope, $rootScope, $routeParams, $location, Recipe, Ingredient, RecipeIngredient) {
    console.info('RecipeCtrl');

    $scope.init = function () {
        $scope.recipeIngredients = {};

        if (!$scope.recipe || $scope.recipe.id != $routeParams.id) {
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
                $scope.recipeIngredients = response;
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
                var location = headers('Location');
                $scope.recipe.id = location.match(/\d+$/)[0];
                if ($rootScope.recipes) {
                    $rootScope.recipes.push($scope.recipe);
                }
                $rootScope.recipe = $scope.recipe;
                $location.path(location);
            });
        }
    };

    $scope.addRecipeIngredient = function(recipeIngredient) {
        // @todo Modal title in the view
        if (recipeIngredient) {
            $scope.selectedRecipeIngredient = recipeIngredient;
            // @todo maybe use a function to set selectedIngredientId
            findIngredientById( $scope.selectedRecipeIngredient.ingredient_id)
//            $scope.selectedIngredientId = $scope.selectedRecipeIngredient.ingredient_id;
            $('#recipe-ingredient-add-modal').modal('show').find('.modal-title').text('Edit recipe ingredient');
        } else {
            $scope.selectedRecipeIngredient = {recipe_id: $scope.recipe.id};
            $scope.selectedIngredientId = {};
            $('#recipe-ingredient-add-modal').modal('show').find('.modal-title').text('Add recipe ingredient');
        }
    };

    $scope.saveRecipeIngredient = function() {
        var promise;
        if (typeof $scope.selectedRecipeIngredient.id === 'undefined') {
            promise = RecipeIngredient.add($scope.selectedRecipeIngredient).success(function(data, status, headers) {
                var recipeIngredient = {}, i;
                $scope.selectedRecipeIngredient.id = headers('Location').match(/\d+$/)[0];

                for (i in $scope.ingredients) {
                    if ($scope.ingredients[i].id === $scope.selectedRecipeIngredient.ingredient_id) {
                        recipeIngredient = $.extend(true, $scope.ingredients[i], $scope.selectedRecipeIngredient);
                        break;
                    }
                }
                $scope.recipeIngredients.push(recipeIngredient);
            });
        } else {
            promise = RecipeIngredient.edit($scope.selectedRecipeIngredient).success(function(data, status, headers) {
                var i;
                for (i in $scope.recipeIngredients) {
                    if ($scope.recipeIngredients[i].id === $scope.selectedRecipeIngredient.id) {
                        $scope.recipeIngredients[i] = $scope.selectedRecipeIngredient;
                        break;
                    }
                }
            });
        }

        promise.then(function() {
            $scope.calculateIngredientTotals();
            $('#recipe-ingredient-add-modal').modal('hide');
        });
    };

    $scope.confirmDeleteRecipeIngredient = function(recipeIngredient) {
        $scope.selectedRecipeIngredient = recipeIngredient;
        $('#recipe-ingredient-delete-modal').modal('show');
    };

    $scope.deleteRecipeIngredient = function() {
        RecipeIngredient.delete($scope.selectedRecipeIngredient).success(function() {
            $scope.recipeIngredients.splice($scope.recipeIngredients.indexOf($scope.selectedRecipeIngredient), 1);
            $('#recipe-ingredient-delete-modal').modal('hide');
            $scope.calculateIngredientTotals();
        });
    };

    $scope.ingredientSelected = function () {
        $scope.selectedRecipeIngredient.ingredient_id = $scope.selectedIngredientId.id;
    };

    function findIngredientById(id) {
        console.info(id);
        for (var i in $scope.ingredients) {
            if ($scope.ingredients[i].id == id) {
                $scope.selectedIngredientId = $scope.ingredients[i];
                console.info($scope.selectedIngredientId);
                break;
            }
        }
    }

    $('#ingredient-add-modal').on('shown.bs.modal', function() {
        $(':text:first', this).focus();
    });

    $scope.init();
});
