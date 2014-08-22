angular.module('RecipeService', []).factory('Recipe', ['$http', function($http) {

    return {
        get : function(id) {
            return $http.get('/recipes/' + id);
        },

        getIngredients : function(id) {
            return $http.get('/recipes/' + id + '/ingredients');
        },

        // call to POST and create a new geek
        create : function(data) {
            return $http.post('/recipe', data);
        },

        // call to DELETE a geek
        delete : function(id) {
            return $http.delete('/recipe/' + id);
        }
    }

}]);