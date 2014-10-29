angular.module('forecast', ['OnEnterEvent'])
.controller('UsersController', function($scope, $window, $http) {
    $scope.apiUrl = 'api.php';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };
    
    $scope.deactivateUser = function(id){
        console.log(id);
    };
    
    $scope.editUser = function(id){
        console.log(id);
    };
});
