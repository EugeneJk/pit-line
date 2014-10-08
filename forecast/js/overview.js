angular.module('forecast', [])
.controller('OverviewController', function($scope, $window) {
    $scope.data = null;
    $scope.isFillResults = false;
    $scope.init = function(initFunction){
        $scope.data = eval(initFunction)();
    };

    $scope.goToSelect = function(year,stage){
        $window.location.href = 'select.php?year=' + year + '&stage=' + stage;
    };
    
    $scope.switchInput = function(){
        $scope.isFillResults = !$scope.isFillResults;
    };
    
    $scope.goToFillResults = function(year,stage){
        $window.location.href = 'fill.php?year=' + year + '&stage=' + stage;
    };
});
