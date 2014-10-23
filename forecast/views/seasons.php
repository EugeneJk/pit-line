    <?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['forecast']['is_logged']) || !$_SESSION['forecast']['is_logged']){
        header('Location: login.php');
    } 
    $mongo = new MongoClient("mongodb://localhost");
    $filter = array('active' => true);
    $fields = array(
        'year' => true,
        '_id' => false,
    );

    $allSeasons = array();
    $cursor = $mongo->forecast->results->find()->fields($fields);
    $currentElement = $cursor->getNext();
    while($currentElement){
        $allSeasons[] = $currentElement;
        $currentElement = $cursor->getNext();
    }
    
    $allTeams = array();
    $cursor = $mongo->forecast->reference->find(array('type' => 'team'))->fields(array('_id'=>true));
    $currentElement = $cursor->getNext();
    while($currentElement){
        $allTeams[] = $currentElement['_id'];
        $currentElement = $cursor->getNext();
    }

    $allDrivers = array();
    $cursor = $mongo->forecast->reference->find(array('type' => 'driver'))->fields(array('_id'=>true));
    $currentElement = $cursor->getNext();
    while($currentElement){
        $allDrivers[] = $currentElement['_id'];
        $currentElement = $cursor->getNext();
    }
    
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
        <link href="/forecast/css/seasons.css" rel="stylesheet">
        <script src="/forecast/js/seasons.js"></script>
        <script src="/forecast/js/OnEnterEvent.js"></script>
    </head>
    <body ng-controller="SeasonController" ng-init="init('inputData')">
        <div class="modal fade" id="modal-popup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Новый сезон</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" role="tablist" id="options-tabs">
                            <li class="active"><a href="#year" id='t1' ng-click="tabClick(1)">Год</a></li>
                            <li><a href="#stages" id='t2' ng-click="tabClick(2)">Этапы</a></li>
                            <li><a href="#teams" id='t3' ng-click="tabClick(3)">Команды</a></li>
                            <li><a href="#rules" id='t4' ng-click="tabClick(4)">Правила</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active option-tab" id="year">
                                <input type="text" class="form-control" placeholder="Год" ng-model="selectedSeason._id">
                            </div>
                            <div class="tab-pane option-tab" id="stages">
                                <div class="input-group" ng-repeat="(key, value) in selectedSeason.stages track by $index">
                                    <input type="text" class="form-control" placeholder="Название этапа" ng-model="selectedSeason.stages[key]">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" ng-click="removeStage(key)">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                </div>                                
                                <button type="button" class="btn btn-default" ng-click="addNewStage();">
                                    Добавить <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </div>
                            <div class="tab-pane option-tab" id="teams">
                                <div class="row">
                                    <div class="col-lg-6">
<pre ng-repeat="team in selectedSeason.teams">
<span class="team-name">{{team.name}}</span>
{{team.drivers.join('\n')}}
</pre>                                        
                                        <div ng-show="isAddNewTeamProcess">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <input type="text" class="form-control" placeholder="Название команды" 
                                                           ng-model="newTeam.name"
                                                           ng-change='filterTeams(newTeam.name)'
                                                           ng-enter="selectTeam()"
                                                           ng-focus="showTeams()"
                                                           >
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="" ng-repeat="(key,driver) in newTeam.drivers track by $index">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" disabled value="{{driver}}">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button" ng-click="removeDriver(key)"><span class="glyphicon glyphicon-minus"></span></button>
                                                            </span>                                                        
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="Пилот" 
                                                           ng-model="newDriver"
                                                           ng-change='filterDrivers(newDriver)'
                                                           ng-enter="selectDriver()"
                                                           ng-focus="showDrivers()"
                                                           >
                                                    </div>
                                                </li>
                                            </ul>                                            
                                        </div>
                                        <button type="button" class="btn btn-default" ng-hide="isAddNewTeamProcess" ng-click="addNewTeam();">
                                            Добавить <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                        <button type="button" class="btn btn-success" ng-show="isAddNewTeamProcess" ng-click="saveNewTeam();">
                                            Сохранить <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                    </div>
                                    <div class="col-lg-6">
                                        <div ng-show="isShowTeams">
                                            <button ng-repeat="team in filteredTeams" type="button" class="btn btn-default"
                                                ng-click="applyTeam(team)">
                                                {{team}}
                                            </button>
                                        </div>
                                        <div ng-show="isShowDrivers">
                                            <button ng-repeat="driver in filteredDrivers" type="button" class="btn btn-default"
                                                ng-click="applyDriver(driver)">
                                                {{driver}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane option-tab" id="rules">
                                Правила
                            </div>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveNewSeason()">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->        
        <div class="panel panel-primary panel-custom">
            <div class="panel-heading">
                <h3 class="panel-title">Сезоны</h3>
            </div>
            <div class="panel-body">
                <div class="input-group" >
                    <button ng-repeat="season in seasons" type="button" class="btn btn-default">
                        {{season.year}}
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                </div>
            </div>
            <div class="panel-footer tool-bar">
                <button type="button" class="btn btn-default" ng-click="addNewSeason();">
                    Новый <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        </div>
        <script type="text/javascript">
            function inputData(){
                return {
                    seasons: <?php echo json_encode($allSeasons);?>,
                    teams: <?php echo json_encode($allTeams);?>,
                    drivers: <?php echo json_encode($allDrivers);?>,
                };
            };
        </script>
    </body>
</html>