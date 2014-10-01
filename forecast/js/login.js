angular.module('forecast', ['OnEnterEvent'])
.controller('LoginController', function($scope, $http, $timeout, $window) {
    $scope.username = null;
    $scope.password = null;
    $scope.username = 'test';
    $scope.password = '123456';
    $scope.showAlert = false;
    $scope.showIncorrectLogin = false;
    $scope.showSuccess = false;
    $scope.submitData = function(){
        $scope.showAlert = !$scope.username || !$scope.password;
        if(!$scope.showAlert){
            var data = {
                action:'login',
                data:{
                    username:$scope.username,
                    password:$scope.password,
                },
            };
                    
            $http.post('/forecast/action.php', data,
                {
                    headers: {'Content-type': 'application/x-www-form-urlencoded; charset=utf-8'}
                }
            ).success(successResult);
        } else {
            $timeout(hideAlert, 1500);
        }
    };
    var hideAlert = function(){
        $scope.showAlert = false;
    };
    var hideIncorrectLogin = function(){
        $scope.showIncorrectLogin = false;
    };
    var successResult = function(data){
        if(data.success === false){
            $scope.showIncorrectLogin = true;
            $timeout(hideIncorrectLogin, 2500);
        } else {
            $scope.showSuccess = true;
            //$window.location.href = 'select.php';
        }
    };
    

});
