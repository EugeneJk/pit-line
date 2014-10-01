angular.module('forecast', [])
.controller('OverviewController', function($scope, $window) {
    $scope.data = null;
    $scope.init = function(initFunction){
        $scope.data = eval(initFunction)();
    };

    $scope.goToSelect = function(year,stage){
        $window.location.href = 'select.php?year=' + year + '&stage' + stage;
    };
});
