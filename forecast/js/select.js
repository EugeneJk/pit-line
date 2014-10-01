angular.module('forecast', ['OnEnterEvent'])
.controller('ForecastController', function($scope, $filter, $http, $timeout) {
    var teamsBase = [
        {name: 'Red Bull', drivers: ['Себастьян Феттель','Даниэль Риккардо']},
        {name: 'Mercedes', drivers: ['Льюис Хэмилтон','Нико Росберг']},
        {name: 'Ferrari', drivers: ['Фернандо Алонсо','Кими Райкконен']},
        {name: 'Lotus', drivers: ['Роман Грожан','Пастор Мальдонадо']},
        {name: 'McLaren', drivers: ['Дженсон Баттон','Кевин Магнуссен']},
        {name: 'Force India', drivers: ['Нико Хюлкенберг',' Серхио Перес']},
        {name: 'Sauber', drivers: ['Адриан Сутил','Эстебан Гутьеррес']},
        {name: 'Toro Rosso', drivers: ['Жан-Эрик Вернь','Даниил Квят']},
        {name: 'Williams', drivers: ['Фелипе Масса','Валттери Боттас']},
        {name: 'Marussia', drivers: ['Жюль Бьянки','Макс Чилтон']},
        {name: 'Caterham', drivers: ['Камуи Кобаяши','Маркус Эриксон']},
    ];

    var populateTeams = function(){
        var drivers = []
        for(var i in teamsBase){
            for(var j in teamsBase[i].drivers){
                drivers.push({driver:teamsBase[i].drivers[j], display: teamsBase[i].name + ': ' + teamsBase[i].drivers[j]});
            }
        }
        return drivers;
    };

    $scope.driversBase = populateTeams();
    $scope.driversRace = angular.copy($scope.driversBase);
    $scope.driversQual = angular.copy($scope.driversBase);

    $scope.dataFields = {
        'pole-position':{name:'', isset:false},
        'first-place':{name:'', isset:false},
        'second-place':{name:'', isset:false},
        'third-place':{name:'', isset:false},
        'fourth-place':{name:'', isset:false},
        'fifth-place':{name:'', isset:false},
        'tenth-place':{name:'', isset:false},
    };
    $scope.inputFields = [
        {id:'pole-position', name: 'Поул'},
        {id:'first-place', name: '1'},
        {id:'second-place', name: '2'},
        {id:'third-place', name: '3'},
        {id:'fourth-place', name: '4'},
        {id:'fifth-place', name: '5'},
        {id:'tenth-place', name: '10'},
    ];

    $scope.currentDrivers = null;
    $scope.currentSelected = null;
    $scope.showDrivers = function(selected)
    {
        $scope.currentSelected = selected;
        if(selected === 'pole-position'){
            $scope.currentDrivers = $scope.driversQual;
        }else{
            $scope.currentDrivers = $scope.driversRace;
        }
        $scope.filterItems($scope.dataFields[selected].name);
    };

    $scope.selectDriver = function(selected){
        if($scope.filteredItems.length === 1){
            $scope.dataFields[selected].name = $scope.filteredItems[0].driver;
            $scope.dataFields[selected].isset = true;
            removeDriverFromCurrentList($scope.dataFields[selected].name);
            $scope.filterItems($scope.dataFields[selected].name);
        }
    };

    $scope.filterItems = function(val){
        $scope.filteredItems = $filter('filter')($scope.currentDrivers, val);
    };

    var removeDriverFromCurrentList = function(name){
        for(var i in $scope.currentDrivers){
            if($scope.currentDrivers[i].driver === name){
                $scope.currentDrivers.splice(i,1);
                break;
            }
        }
    };

    $scope.clearSelection = function(selected){
        $scope.currentSelected = selected;
        if(selected === 'pole-position'){
            $scope.driversQual = angular.copy($scope.driversBase);
            $scope.dataFields[selected].name = '';
            $scope.dataFields[selected].isset = false;
        }else{
            $scope.driversRace = angular.copy($scope.driversBase);
            $scope.dataFields[selected].name = '';
            $scope.dataFields[selected].isset = false;
            for(var field in $scope.dataFields){
                if($scope.dataFields[field].isset === true){
                    for(var driverIndex in $scope.driversRace){
                        if($scope.driversRace[driverIndex].driver === $scope.dataFields[field].name){
                            $scope.driversRace.splice(driverIndex,1);
                            break;
                        }
                    }
                }
            }
        }
        $scope.filterItems($scope.currentSelected);
        $scope.showDrivers($scope.currentSelected);
    };

    $scope.applyDriver= function(name){
        $scope.dataFields[$scope.currentSelected].name = name;
        $scope.filterItems(name);
        $scope.selectDriver($scope.currentSelected);

    };
    
    $scope.showAlert = false;
    $scope.showSuccess = false;
    $scope.submitData = function(){
        $scope.showAlert = false;
        for(var field in $scope.dataFields){
            if($scope.dataFields[field].isset === false){
                $scope.showAlert = true;
                $timeout(hideAlert, 1500);
            }
        }
        if(!$scope.showAlert){
            var data = $scope.dataFields;
            $http.post('/forecast/action.php', data,
                {
                    headers: {'Content-type': 'application/x-www-form-urlencoded; charset=utf-8'}
                }
            )/*.success(successCallback)*/;
        }
    };
    
    var hideAlert = function(){
        $scope.showAlert = false;
    };
    var hideSuccess = function(){
        $scope.showSuccess = false;
    };
});
