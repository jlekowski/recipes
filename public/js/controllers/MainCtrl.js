angular.module('MainCtrl', []).controller('MainController', function($rootScope) {
    $rootScope.appName = 'Recipes';
    $rootScope.activeMenu = 'recipes';
});
