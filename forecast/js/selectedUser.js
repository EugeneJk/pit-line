angular.module('forecast', ['OnEnterEvent'])
.controller('UserController', function($scope, $window, $http) {
    $scope.apiUrl = 'api.php';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };
    
    /*
    $scope.activateDeactivateUser = function(id, active){
        var data = {
            action: 'activate_deactivate_user',
            data: {
                id: id,
                active: active,
            },
        };
        $http.post($scope.apiUrl, data).success(successSave).error(errorSave);        
    };
    
    var successSave = function(data, status, headers, config){
        if(data.success === true){
            for(var index in $scope.users)
                if($scope.users[index]._id === data.updated_item.id){
                    $scope.users[index].active = data.updated_item.active;
                    break;
                }
        }
        console.log(data);
    };
    var errorSave = function(data, status, headers, config){
        console.log(data);
    };
    */
    
});
