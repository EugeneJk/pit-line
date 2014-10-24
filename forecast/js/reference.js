angular.module('forecast', ['OnEnterEvent'])
.controller('ReferenceController', function($scope, $filter, $http) {
    $scope.apiUrl = 'api.php';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };
});
