<?php
    
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
        <link href="/forecast/css/select.css" rel="stylesheet">
        <script src="/forecast/js/select.js"></script>
        <script src="/forecast/js/OnEnterEvent.js"></script>
    </head>
    <body ng-controller="ForecastController">
        <div class="panel panel-primary panel-custom">
            <div class="panel-heading">
                <h3 class="panel-title">Прогноз на Гран-При ХХХХХХХХ</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-danger" role="alert" ng-show="showAlert">
                    Необходимо заполнить все поля!
                </div>
                <div class="alert alert-success" role="alert" ng-show="showSuccess">
                    Необходимо заполнить все поля!
                </div>
                <div class="panel panel-info pull-left">
                    <div class="panel-heading">
                        <h3 class="panel-title">Прогнозируемые прозиции</h3>
                    </div>
                    <div class="panel-body">
                        <div class="input-group" ng-repeat="item in inputFields">
                            <span class="input-group-addon field-label" ng-class="{'field-completed-label': dataFields[item.id].isset ,'field-selected-label': currentSelected === item.id}">
                                {{item.name}}
                            </span>
                            <input type="text" class="form-control" ng-class="{'field-completed-label': dataFields[item.id].isset }" ng-model='dataFields[item.id].name' ng-readonly="dataFields[item.id].isset" ng-change='filterItems(dataFields[item.id].name)' ng-focus="showDrivers(item.id);" ng-enter="selectDriver(item.id)">
                            <a class="btn input-group-addon field-label field-clear-label" ng-click="clearSelection(item.id)">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="panel panel-info pull-right">
                    <div class="panel-heading">
                        <h3 class="panel-title">Список доступных пилотов</h3>
                    </div>
                    <div class="panel-body">
                        <div class="drivers-panel">
                            <div ng-repeat="team in filteredItems">
                                <button type="button" class="btn btn-default driver-button" ng-click="applyDriver(team.driver)">
                                    {{team.display}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <center><button class="btn btn-primary" ng-click="submitData();">Отправить</button></center>
            </div>
        </div>
    </body>
</html>