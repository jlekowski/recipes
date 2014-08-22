angular.module('MainCtrl', []).controller('MainController', function($scope, $rootScope) {
    console.info('MainCtrl');
    $rootScope.appName = 'MainCtrl :)';
});
