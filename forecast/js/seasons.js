angular.module('forecast', ['OnEnterEvent'])
.controller('SeasonsController', function($scope) {
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };

    $scope.addNewSeason = function(){
    };
});
