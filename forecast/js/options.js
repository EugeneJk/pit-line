angular.module('forecast', ['OnEnterEvent'])
.controller('OptionsController', function($scope, $window, $http) {
    $scope.apiUrl = 'api.php';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };
    
    $scope.viewEditStage = function(season,stage){
        console.log(season,stage);
    };
});
