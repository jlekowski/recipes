angular.module('TestCtrl', []).controller('TestController', function($scope, $routeParams, Test) {
    Test.get().success(function(response) {
        $scope.recipes = response;
    });

    console.log($routeParams.id);
});
