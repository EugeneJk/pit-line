    <?php
    include_once 'check.php';
    
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
    <body ng-controller="SeasonsController" ng-init="init('inputData')" class="system-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Сезоны</h3>
            </div>
            <div class="panel-body">
                <ol class="breadcrumb">
                    <li><a href="index.php?action=options">Панель управления системы "Прогноз"</a></li>
                    <li class="active">Сезоны</li>
                </ol>                
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