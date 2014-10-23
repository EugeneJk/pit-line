angular.module('forecast', ['OnEnterEvent'])
.controller('SeasonController', function($scope, $filter, $http) {
    $scope.apiUrl = 'api/season.php';
    $scope.isAddNewTeamProcess = false;
    $scope.isShowTeams = false;
    $scope.isShowDrivers = false;
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
        $scope.currentTeams = angular.copy($scope.teams);
        $scope.currentDrivers = angular.copy($scope.drivers);
        $scope.filteredTeams = $scope.teams;
        $scope.newTeam = getNewTeamData();
        $scope.newDriver = '';
    };

    $scope.addNewSeason = function(){
        $(modalId).modal('show');
    };

    $scope.saveNewSeason = function(){
        var data = {
            action: 'save',
            data: $scope.selectedSeason,
        };
        $http.post($scope.apiUrl, data).success(successSave).error(errorSave);        
        $(modalId).modal('hide');
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
        $scope.selectedSeason.stages.push('');
    };

    $scope.addNewTeam = function(){
        $scope.isAddNewTeamProcess = true;
        $scope.newTeam = getNewTeamData();
        $scope.currentDrivers = angular.copy($scope.drivers);
        $scope.filterDrivers('');
    };
    
    $scope.saveNewTeam = function(){
        $scope.selectedSeason.teams.push($scope.newTeam);
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
    
    $scope.removeStage = function(number){
        $scope.selectedSeason.stages.splice(number,1);
    };
    
    $scope.tabClick = function(number){
        $('#options-tabs #t' + number).tab('show') ;
    };
    
    var getNewTeamData = function(){
        return{name: '',drivers: []};
    };
    
    
    
    $scope.$watch('isAddNewTeamProcess', function(newValue, oldValue) {
        if(newValue === false){
            $scope.isShowTeams = false;
            $scope.isShowDrivers = false;
        }
    });    
    
});
