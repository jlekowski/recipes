angular.module('RecipesService', []).factory('Recipes', ['$http', function($http) {

    return {
        // call to get all nerds
        get : function() {
            return $http.get('/recipes');
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