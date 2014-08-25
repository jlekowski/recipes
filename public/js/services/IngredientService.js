angular.module('IngredientService', []).factory('Ingredient', ['$http', function($http) {
    return {
        get: function(id) {
            return $http.get('/ingredients/' + id);
        },

        getAll: function() {
            return $http.get('/ingredients');
        },

        edit: function(data) {
            return $http.put('/ingredients/' + data.id, data);
        },

        add: function(data) {
            return $http.post('/ingredients', data);
        },

        delete: function(id) {
            return $http.delete('/ingredients/' + id);
        }
    };
}]);
