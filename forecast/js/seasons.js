angular.module('forecast', [])
.controller('SeasonController', function($scope, $window) {
    $scope.data = null;
    $scope.isFillResults = false;
    $scope.init = function(initFunction){
        $scope.data = eval(initFunction)();
    };

    $scope.addNewSeason = function(){
        
    };
});
