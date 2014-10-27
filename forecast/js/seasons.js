angular.module('forecast', ['OnEnterEvent'])
.controller('SeasonsController', function($scope, $window) {
    $scope.seasons = null;
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };

    $scope.openSeason = function(seasonId){
        $window.location.href = '?action=selected_season&season=' + seasonId;
    };
});
