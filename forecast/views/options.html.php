<?php
include_once 'check.php';

use forecast\Forecast;

$forecast = new Forecast();
$seasonsData = $forecast->getActiveSeasons();
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
        <script src="/forecast/js/options.js"></script>
        <script src="/forecast/js/OnEnterEvent.js"></script>
    </head>
    <body class="system-body" ng-controller="OptionsController" ng-init="init('inputData')">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Панель управления системы "Прогноз"
                </h3>
            </div>
            <div class="panel-body">
                <ol class="breadcrumb">
                    <li class="active">Панель управления системы "Прогноз"</li>
                </ol>
                
                <span ng-repeat="season in seasons">
                    <h3>{{season.name}}</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="column-header">Прошедшие Этапы:</div>
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="column-header">Ожидающие Этапы:</div>
                            
                        </div>
                    </div>
                    <hr>
                </span>

                
                
                <?php if($isAdmin) :?>
                <a href="index.php?action=users" class="btn btn-default">Пользователи</a>
                <a href="index.php?action=seasons" class="btn btn-default">Сезоны</a>
                <a href="index.php?action=reference" class="btn btn-default">Справочник</a>
                <?php endif;?>
            </div>
            <div class="panel-footer tool-bar">
                <a href="index.php?action=logout">Выход</a>
            </div>
        </div>
        <script type="text/javascript">
                    function inputData() {
                        return {
                            seasons: <?php echo json_encode($seasonsData);?>,
                        };
                    };
        </script>
        
    </body>
</html>