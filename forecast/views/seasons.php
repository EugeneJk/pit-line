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
    $seasons = $mongo->forecast->results->find()->fields($fields);
    $currectSeason = $seasons->getNext();
    $allSeasons = array();
    while($currectSeason){
        $allSeasons[] = $currectSeason;
        $currectSeason = $seasons->getNext();
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
    </head>
    <body ng-controller="SeasonController" ng-init="init('inputData')">
        <div class="panel panel-primary panel-custom">
            <div class="panel-heading">
                <h3 class="panel-title">Сезоны</h3>
            </div>
            <div class="panel-body">
                <div class="input-group" >
                    <button ng-repeat="season in data" type="button" class="btn btn-default">
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
                return <?php echo json_encode($allSeasons);?>;
            };
        </script>
    </body>
</html>