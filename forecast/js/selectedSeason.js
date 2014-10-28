angular.module('forecast', ['OnEnterEvent'])
.controller('SeasonController', function($scope, $filter, $http) {
    $scope.apiUrl = 'api.php';
    $scope.selectedTeam = 0;
    $scope.season = {
        _id:'',
        stages:[],
        teams:[],
        rules:[],
    };
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
    };

    $scope.saveSeason = function(){
        var data = {
            action: 'save',
            data: $scope.season,
        };
        console.log(data);
        //$http.post($scope.apiUrl, data).success(successSave).error(errorSave);        
    };
    var successSave = function(data, status, headers, config){
        // this callback will be called asynchronously
        // when the response is available
    };
    var errorSave = function(data, status, headers, config){
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    };
    
    $scope.addNewStage = function(){
        $scope.season.stages.push('');
    };
    $scope.removeStage = function(number){
        $scope.season.stages.splice(number,1);
    };
    
    $scope.addNewTeam = function(){
        $scope.season.teams.push({name:'',drivers:[]});
    };
    $scope.removeTeam = function(number){
        $scope.season.teams.splice(number,1);
    };

    $scope.selectTeam = function(number){
        $scope.selectedTeam = number;
    };

/*
    
    $scope.saveNewTeam = function(){
        $scope.season.teams.push($scope.newTeam);
        $scope.currentTeams.splice($scope.currentTeams.indexOf($scope.newTeam.name),1);
        $scope.isAddNewTeamProcess = false;
    };
    
    $scope.filterTeams = function(val){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.filteredTeams = $filter('filter')($scope.currentTeams, val);
    };
    
    $scope.applyTeam = function(val){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.newTeam.name = val;
        $scope.filterTeams(val);
    };
    
    $scope.showTeams = function(){
        $scope.isShowTeams = true;
        $scope.isShowDrivers = false;
    };

    $scope.filterDrivers = function(val){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.filteredDrivers = $filter('filter')($scope.currentDrivers, val);
    };
    
    $scope.applyDriver = function(val){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.newTeam.drivers.push(val);
        $scope.currentDrivers.splice($scope.currentDrivers.indexOf(val),1);
        $scope.newDriver = '';
        $scope.filterDrivers($scope.newDriver);
    };
    
    $scope.removeDriver = function(number){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.newTeam.drivers.splice(number,1);
        $scope.currentDrivers = angular.copy($scope.drivers);
        for(var index in $scope.newTeam.drivers){
            $scope.currentDrivers.splice($scope.currentDrivers.indexOf($scope.newTeam.drivers[index]),1);
        }
        $scope.filterDrivers('');
    };
    
    $scope.showDrivers = function(){
        $scope.isShowTeams = false;
        $scope.isShowDrivers = true;
    };
*/
    
    $scope.tabClick = function(number){
        $('#options-tabs #t' + number).tab('show') ;
    };
});
