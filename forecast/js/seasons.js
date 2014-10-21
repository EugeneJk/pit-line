angular.module('forecast', [])
.controller('SeasonController', function($scope, $window) {
    $scope.data = null;
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
        
    };
    
    $scope.removeStage = function(number){
        $scope.selectedSeason.stages.splice(number,1);
    };
    
    $scope.tabClick = function(number){
        $('#options-tabs #t' + number).tab('show') ;
    };
});
