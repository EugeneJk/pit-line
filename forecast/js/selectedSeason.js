angular.module('forecast', ['OnEnterEvent'])
.controller('SeasonController', function($scope, $filter, $http) {
    $scope.apiUrl = 'api.php';
    $scope.selectedTeam = 0;
    $scope.availableDrivers = null;
    $scope.availableTeams = null;
    $scope.raceDefaultOffset = 2;
    $scope.raceOffsetArray = [];
    $scope.qualDefaultOffset = 1;
    $scope.qualOffsetArray = [];
    
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
        
        refreshAvailableDrivers();
        refreshAvailableTeams();
        refreshRaceOffsetArray();
        refreshQualOffsetArray();
    };

    $scope.saveSeason = function(){
        var data = {
            action: 'save_season',
            data: $scope.season,
        };
        $http.post($scope.apiUrl, data).success(successSave).error(errorSave);        
    };
    var successSave = function(data, status, headers, config){
        console.log(data);
        // this callback will be called asynchronously
        // when the response is available
    };
    var errorSave = function(data, status, headers, config){
        console.log(data);
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
        refreshAvailableTeams();
    };
    var refreshAvailableTeams = function(){
        $scope.availableTeams = angular.copy($scope.teams);
        for(var i in $scope.season.teams){
            console.log($scope.season.teams[i].name, $scope.availableTeams);
            $scope.availableTeams.splice($scope.availableTeams.indexOf($scope.season.teams[i].name),1);
            console.log($scope.availableTeams);
        }
    };

    $scope.selectTeam = function(number){
        $scope.selectedTeam = number;
    };
    $scope.selectDriver = function(number){
        $scope.season.teams[$scope.selectedTeam].drivers.push($scope.availableDrivers[number]);
        refreshAvailableDrivers();
    };
    $scope.removeDriver = function(number){
        $scope.season.teams[$scope.selectedTeam].drivers.splice(number,1);
        refreshAvailableDrivers();
    };
    
    $scope.tabClick = function(number){
        $('#options-tabs #t' + number).tab('show') ;
    };

    var refreshAvailableDrivers = function(){
        $scope.availableDrivers = angular.copy($scope.drivers);
        for(var i in $scope.season.teams){
            var currentTeam = $scope.season.teams[i];
            for(var j in currentTeam.drivers){
                $scope.availableDrivers.splice($scope.availableDrivers.indexOf(currentTeam.drivers[j]),1);
            }
        }
    };
    
    $scope.addNewRacePostion = function(){
        var newPonts = {};
        for(var i in $scope.raceOffsetArray){
            newPonts[$scope.raceOffsetArray[i]] = ($scope.newRacePosition > Math.abs($scope.raceOffsetArray[i])) || ($scope.raceOffsetArray[i] >= 0)  ? 0 : null;
        }
        $scope.season.rules.race.push({
            position: $scope.newRacePosition,
            points: newPonts,
        });
        $scope.newRacePosition = '';
    };
    var refreshRaceOffsetArray = function(){
        $scope.raceOffsetArray = [];
        for(var i = -$scope.raceDefaultOffset; i <= $scope.raceDefaultOffset; i++){
            $scope.raceOffsetArray.push(i);
        }
    };
    $scope.addNewQualPostion = function(){
        var newPonts = {};
        for(var i in $scope.qualOffsetArray){
            newPonts[$scope.qualOffsetArray[i]] = ($scope.newQualPosition > Math.abs($scope.qualOffsetArray[i])) || ($scope.qualOffsetArray[i] >= 0)  ? 0 : null;
        }
        $scope.season.rules.qual.push({
            position: $scope.newQualPosition,
            points: newPonts,
        });
        $scope.newQualPosition = '';
    };
    var refreshQualOffsetArray = function(){
        $scope.qualOffsetArray = [];
        for(var i = -$scope.qualDefaultOffset; i <= $scope.qualDefaultOffset; i++){
            $scope.qualOffsetArray.push(i);
        }
    };
});
