angular.module('forecast', ['OnEnterEvent'])
.controller('UserController', function($scope, $window, $http) {
    $scope.apiUrl = 'api.php';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };
    
    
    $scope.saveUser = function(){
        var data = {
            action: 'save_user',
            data: $scope.user,
        };
        $http.post($scope.apiUrl, data).success(successSave).error(errorSave);        
    };
    
    var successSave = function(data, status, headers, config){
        if(data.success === true){
            $window.location = 'index.php?action=users';
        }
        console.log(data);
    };
    var errorSave = function(data, status, headers, config){
        console.log(data);
    };
    
});
