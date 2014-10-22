angular.module('forecast', ['OnEnterEvent'])
.controller('SeasonController', function($scope, $filter) {
    $scope.data = null;
    $scope.isAddNewTeamProcess = false;
    $scope.filteredTeams = [];
    $scope.filteredDrivers = [];
    $scope.currentDrivers = null;
    $scope.selectedSeason = {
        _id:'',
        stages:[''],
        teams:[],
        rules:'1',
    };
    var modalId = '#modal-popup';
    $scope.init = function(initFunction){
        var initData = eval(initFunction)();
        for(var index in initData){
            $scope[index] = initData[index];
        }
        
        $scope.currentDrivers = angular.copy($scope.drivers);
        $scope.filteredTeams = $scope.teams;
        $scope.newTeam = getNewTeamData();
        $scope.newDriver = '';
    };

    $scope.addNewSeason = function(){
        $(modalId).modal('show');
    };

    $scope.saveNewSeason = function(){
        
    };
    
    $scope.addNewStage = function(){
        $scope.selectedSeason.stages.push('');
    };

    $scope.addNewTeam = function(){
        $scope.isAddNewTeamProcess = true;
        $scope.newTeam = getNewTeamData();
        $scope.currentDrivers = angular.copy($scope.drivers);
        $scope.filterDrivers('');
    };
    
    $scope.filterTeams = function(val){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.filteredTeams = $filter('filter')($scope.teams, val);
    };
    
    $scope.applyTeam = function(val){
        if(!$scope.isAddNewTeamProcess){ return; }
        $scope.newTeam.name = val;
        $scope.filterTeams(val);
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
    
    $scope.removeStage = function(number){
        $scope.selectedSeason.stages.splice(number,1);
    };
    
    $scope.tabClick = function(number){
        $('#options-tabs #t' + number).tab('show') ;
    };
    
    var getNewTeamData = function(){
        return{name: '',drivers: []};
    }
});
