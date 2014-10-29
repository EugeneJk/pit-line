angular.module('forecast', ['OnEnterEvent'])
.controller('ReferenceController', function($scope, $http) {
    $scope.apiUrl = 'api.php';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };
    
    $scope.addNewStage = function(name){
        addNewItem(name, 'stage');
    };
    $scope.addNewTeam = function(name){
        addNewItem(name, 'team');
    };
    $scope.addNewDriver = function(name){
        addNewItem(name, 'driver');
    };

    var addNewItem = function(name,type){
        var data = {
            action: 'add_reference_item',
            data: {
                type: type,
                name: name,
            },
        };
        $http.post($scope.apiUrl, data).success(successSave).error(errorSave);        
    };
    var successSave = function(data, status, headers, config){
        if(data.success === true){
            switch(data.inserted_item.type){
                case 'team':
                    $scope.teams.push(data.inserted_item.name);
                    $scope.newTeam = '';
                    break;
                case 'stage':
                    $scope.stages.push(data.inserted_item.name);
                    $scope.newStage = '';
                    break;
                case 'driver':
                    $scope.drivers.push(data.inserted_item.name);
                    $scope.newDriver = '';
                    break;
            }
        }
        console.log(data);
    };
    var errorSave = function(data, status, headers, config){
        console.log(data);
    };
    
});
