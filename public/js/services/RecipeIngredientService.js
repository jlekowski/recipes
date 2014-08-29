angular.module('RecipeIngredientService', []).factory('RecipeIngredient', ['$http', function($http) {
    return {
        get: function(recipe_id, id) {
            return $http.get('/recipes/' + recipe_id + '/ingredients/' + id);
        },

        edit: function(data) {
            return $http.put('/recipes/' + data.recipe_id + '/ingredients/' + data.id, data);
        },

        add: function(data) {
            return $http.post('/recipes/' + data.recipe_id + '/ingredients', data);
        },

        delete: function(recipe_id, id) {
            return $http.delete('/recipes/' + recipe_id + '/ingredients/' + id);
        }
    };
}]);
