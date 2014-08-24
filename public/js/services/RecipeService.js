angular.module('RecipeService', []).factory('Recipe', ['$http', function($http) {
    return {
        get: function(id) {
            return $http.get('/recipes/' + id);
        },

        getIngredients: function(id) {
            return $http.get('/recipes/' + id + '/ingredients');
        },

        edit: function(data) {
            return $http.put('/recipes/' + data.id, data);
        },

        add: function(data) {
            return $http.post('/recipes', data);
        },

        delete: function(id) {
            return $http.delete('/recipes/' + id);
        }
    };
}]);
