<?php
include_once 'check.php';

use forecast\Reference;
use forecast\Seasons;

$season = new Seasons;
$reference = new Reference();

$seasonsData = $season->getSeason($selectedSeason);
$stagesData = $reference->getStagesList();
$driversData = $reference->getDriversList();
$teamsData = $reference->getTeamsList();
?>

<!DOCTYPE html>
<html lang="en" ng-app="forecast">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Прогноз Формулы 1</title>

        <!-- jQuery -->
        <script src="/forecast/lib/jquery/jquery.min.js"></script>
        <!-- angularjs -->
        <script src="/forecast/lib/angularjs/angular.min.js"></script>
        <!-- Bootstrap -->
        <link href="/forecast/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="/forecast/lib/bootstrap/js/bootstrap.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="/forecast/css/base.css" rel="stylesheet">
        <link href="/forecast/css/selectedSeason.css" rel="stylesheet">
        <script src="/forecast/js/selectedSeason.js"></script>
        <script src="/forecast/js/OnEnterEvent.js"></script>
    </head>
    <body ng-controller="SeasonController" ng-init="init('inputData')" class="system-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Сезоны</h3>
            </div>
            <div class="panel-body">
                <ol class="breadcrumb">
                    <li><a href="index.php?action=options">Панель управления системы "Прогноз"</a></li>
                    <li><a href="index.php?action=seasons">Сезоны</a></li>
                    <li class="active">{{season._id == '' ? 'Новый' : season._id}}</li>
                </ol>                

                <div class="tab-pane active option-tab" id="year">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Год" ng-model="season._id">
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">Активный</span>
                                <select class="form-control" ng-model="season.active">
                                    <option value="yes">Да</option>
                                    <option value="no">Нет</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <ul class="nav nav-tabs" role="tablist" id="options-tabs">
                        <li class="active"><a href="#stages" id='t1' ng-click="tabClick(1)">Этапы</a></li>
                        <li><a href="#teams" id='t2' ng-click="tabClick(2)">Команды</a></li>
                        <li><a href="#drivers" id='t3' ng-click="tabClick(3)">Пилоты</a></li>
                        <li><a href="#rules" id='t4' ng-click="tabClick(4)">Правила</a></li>
                    </ul>
                    <div class="tab-content">
<!-- ***************************   Stages   ******************************** -->                        
                        <div class="tab-pane active option-tab" id="stages">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="column-header">Этапы:</div>
                                    <div class="label-item" ng-repeat="(key,value) in season.stages">
                                        {{value}}
                                        <div class="pull-right">
                                            <button class="btn btn-xs btn-default" ng-click="moveUp('stage',key)">
                                                <span class="glyphicon glyphicon-arrow-up"></span>
                                            </button>
                                            <button class="btn btn-xs btn-default" ng-click="moveDown('stage',key)">
                                                <span class="glyphicon glyphicon-arrow-down"></span>
                                            </button>
                                            <button class="btn btn-xs btn-primary" ng-click="remove('stage',key)">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="column-header">Доступные этапы:</div>
                                    <div class="label-item" ng-repeat="(key,value) in availableStages">
                                        <button class="btn btn-xs btn-success" ng-click="addNewStage(key)">
                                            <span class="glyphicon glyphicon-arrow-left"></span>
                                        </button>
                                        {{value}}
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- ****************************   Teams   ******************************** -->                        
                        <div class="tab-pane option-tab" id="teams">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="column-header">Команды:</div>
                                    <div class="btn-group-vertical" style="width: 100%">
                                    <button type="button" class="btn btn-default drivers-avaiable" ng-repeat="(key,value) in season.teams"
                                            ng-click="removeTeam(key)">
                                        {{value.name}} <span class="glyphicon glyphicon-arrow-right pull-right"></span>
                                    </button>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="column-header">Свободные команды:</div>
                                    <div class="btn-group-vertical" style="width: 100%">
                                    <button type="button" class="btn btn-default drivers-avaiable" ng-repeat="(key,value) in availableTeams"
                                            ng-click="addNewTeam(key)">
                                        <span class="glyphicon glyphicon-arrow-left"></span> {{value}} 
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- ***************************   Drivers   ******************************* -->                        
                        <div class="tab-pane option-tab" id="drivers">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="column-header">Команды:</div>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li ng-repeat="(key, value) in season.teams track by $index"
                                            ng-class="{active : selectedTeam == key}" ng-click="selectTeam(key)">
                                            <a href="#">
                                                <span class="badge pull-right">{{value.drivers.length}}</span>
                                                {{value.name}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="column-header">Пилоты команды:</div>
                                    <div class="btn-group-vertical" style="width: 100%">
                                    <button type="button" class="btn btn-default drivers-avaiable" ng-repeat="(key,value) in season.teams[selectedTeam].drivers"
                                            ng-click="removeDriver(key)">
                                        {{value}} <span class="glyphicon glyphicon-arrow-right pull-right"></span>
                                    </button>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="column-header">Свободные пилоты:</div>
                                    <div class="btn-group-vertical" style="width: 100%">
                                    <button type="button" class="btn btn-default drivers-avaiable" ng-repeat="(key,value) in availableDrivers"
                                            ng-click="selectDriver(key)">
                                        <span class="glyphicon glyphicon-arrow-left"></span> {{value}} 
                                    </button>
                                    </div>
                                </div>
                            </div>                            
                        </div>
<!-- ****************************   Teams   ******************************** -->                        
                        <div class="tab-pane option-tab" id="rules">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="column-header">Квалификация:</div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Позиция</th>
                                                <th ng-repeat="offset in qualOffsetArray">
                                                    {{offset}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(index, value) in season.rules.qual">
                                                <td>{{value.position}}</td>
                                                <td ng-repeat="offset in qualOffsetArray">
                                                    <input type="text" class="form-control score-input" ng-disabled="season.rules.qual[index].points[offset] === null"
                                                           ng-model="season.rules.qual[index].points[offset]" >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>                                    
                                    <div class="input-group">
                                        <input type="text" class="form-control" ng-model="newQualPosition">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" ng-click="addNewQualPostion()">Добавить</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="column-header">Гонка:</div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Позиция</th>
                                                <th ng-repeat="offset in raceOffsetArray">
                                                    {{offset}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(index, value) in season.rules.race">
                                                <td>{{value.position}}</td>
                                                <td ng-repeat="offset in raceOffsetArray">
                                                    <input type="text" class="form-control score-input" ng-disabled="season.rules.race[index].points[offset] === null"
                                                           ng-model="season.rules.race[index].points[offset]" >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="input-group">
                                        <input type="text" class="form-control" ng-model="newRacePosition">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" ng-click="addNewRacePostion()">Добавить</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- *********************************************************************** -->                        
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="button-panel">
                        <a href="index.php?action=seasons" class="btn btn-default">Отмена</a>
                        <button type="button" class="btn btn-primary" ng-click="saveSeason();">
                            Сохранить <span class="glyphicon glyphicon-floppy-disk"></span>
                        </button>
                    </div>
                </li>
            </ul>        
            <div class="panel-footer tool-bar">
                <a href="index.php?action=logout">Выход</a>
            </div>
        </div>
        <script type="text/javascript">
            function inputData(){
                return {
                    season: <?php echo json_encode($seasonsData); ?>,
                    stages: <?php echo json_encode($stagesData);?>,
                    drivers: <?php echo json_encode($driversData);?>,
                    teams: <?php echo json_encode($teamsData);?>,
                };
            };
        </script>
    </body>
</html>