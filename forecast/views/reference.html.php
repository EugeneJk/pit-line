<?php
include_once 'check.php';

use forecast\Reference;

$reference = new Reference();

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
        <!--link href="/forecast/css/reference.css" rel="stylesheet"-->
        <script src="/forecast/js/reference.js"></script>
        <script src="/forecast/js/OnEnterEvent.js"></script>
    </head>
    <body ng-controller="ReferenceController" ng-init="init('inputData')" class="system-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Справочник</h3>
            </div>
            <div class="panel-body">
                <ol class="breadcrumb">
                    <li><a href="index.php?action=options">Панель управления системы "Прогноз"</a></li>
                    <li class="active">Справочник</li>
                </ol>                
                <div class="tab-pane option-tab" id="teams">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="column-header">Этапы:</div>
                            <div class="label-item" ng-repeat="stage in stages">
                                {{stage}}
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" ng-model="newStage">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" ng-click="addNewStage(newStage)">Добавить</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="column-header">Пилоты:</div>
                            <div class="label-item" ng-repeat="driver in drivers">
                                {{driver}}
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" ng-model="newDriver">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" ng-click="addNewDriver(newDriver)">Добавить</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="column-header">Команды:</div>
                            <div class="label-item" ng-repeat="team in teams">
                                {{team}}
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" ng-model="newTeam">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" ng-click="addNewTeam(newTeam)">Добавить</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
                    function inputData() {
                        return {
                            stages: <?php echo json_encode($reference->getStagesList());?>,
                            drivers: <?php echo json_encode($reference->getDriversList());?>,
                            teams: <?php echo json_encode($reference->getTeamsList());?>,
                        };
                    };
        </script>
    </body>
</html>