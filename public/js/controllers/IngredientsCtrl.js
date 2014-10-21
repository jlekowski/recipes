angular.module('IngredientsCtrl', []).controller('IngredientsController', function($scope, $rootScope, Ingredients) {
    console.info('IngredientsCtrl');

    $scope.init = function () {
        if (!$scope.ingredients) {
            Ingredients.getAll().success(function(response) {
                $rootScope.ingredients = response;
            });
        }
    };

    $scope.sortColumn = 'name';
    $scope.sortReverse = false;

    $scope.addIngredient = function(ingredient) {
        // @todo Modal title in the view
        if (ingredient) {
            $scope.selectedIngredient = ingredient;
            $('#ingredient-add-modal').modal('show').find('.modal-title').text('Edit ingredient');
        } else {
            $scope.selectedIngredient = {kcal: '', protein: '', fat: '', carb: ''};
            $('#ingredient-add-modal').modal('show').find('.modal-title').text('Add ingredient');
        }
    };

    $scope.save = function() {
        var promise;
        if (typeof $scope.selectedIngredient.id === 'undefined') {
            promise = Ingredients.add($scope.selectedIngredient).success(function(data, status, headers) {
                var ingredient;
                $scope.selectedIngredient.id = headers('Location').match(/\d+$/)[0];

                ingredient = $.extend({}, $scope.selectedIngredient);
                $scope.ingredients.push(ingredient);
            });
        } else {
            promise = Ingredients.edit($scope.selectedIngredient).success(function(data, status, headers) {
                for (var i in $scope.ingredients) {
                    if ($scope.ingredients[i].id === $scope.selectedIngredient.id) {
                        $scope.ingredients[i] = $.extend({}, $scope.selectedIngredient);
                        break;
                    }
                }
            });
        }

        promise.then(function() {
            $('#ingredient-add-modal').modal('hide');
        });
    };

    $scope.confirmDeleteIngredient = function(ingredient) {
        $scope.selectedIngredient = ingredient;
        $('#ingredient-delete-modal').modal('show');
    };

    $scope.deleteIngredient = function() {
        Ingredients.delete($scope.selectedIngredient.id).success(function() {
            $scope.ingredients.splice($scope.ingredients.indexOf($scope.selectedIngredient), 1);
            $('#ingredient-delete-modal').modal('hide');
        });
    };

    $scope.calculatePer100 = function($el) {
        var $this = $(this),
            divide;

        if ($.trim($this.val()).match(/^\d+(\.\d+)?\/\d+(\.\d+)?$/) === null) {
            return;
        }

        divide = $this.val().split('/');
        $this.val(Math.round(divide[0] / divide[1] * 10000) / 100);
    };


    $scope.init();
});
