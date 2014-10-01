<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['forecast']['is_logged']) || !$_SESSION['forecast']['is_logged']){
        header('Location: login.php');
    } 
    $mongo = new MongoClient("mongodb://localhost");
    $filter = array('active' => true);
    $season = $mongo->forecast->results->findOne($filter);
    
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
        <l!ink href="/forecast/css/select.css" rel="stylesheet">
        <script src="/forecast/js/overview.js"></script>
    </head>
    <body ng-controller="OverviewController" ng-init="init('inputData')">
        <div class="panel panel-primary panel-custom">
            <div class="panel-heading">
                <h3 class="panel-title">Сезон {{data.year}}</h3>
            </div>
            <div class="panel-body">
                <div class="btn-group" ng-repeat="stage in data.stages">
                    <button type="button" class="btn btn-default" ng-click="goToSelect(data.year,stage.number)">
                        {{stage.number}} - {{stage.name}}
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </button>
                </div>
            </div>
        </div>
        
        {{data}}
        <script type="text/javascript">
            function inputData(){
                return <?php echo json_encode($season);?>;
            };
        </script>
    </body>
</html>