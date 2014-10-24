<?php
include_once 'check.php';
?>
<!DOCTYPE html>
<html lang="en">
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
    </head>
    <body class="system-body">
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
                <a href="index.php?action=users" class="btn btn-default">Пользователи</a>
                <a href="index.php?action=seasons" class="btn btn-default">Сезоны</a>
                <a href="index.php?action=reference" class="btn btn-default">Справочник</a>
                <a href="index.php?action=rules" class="btn btn-default">Правила начисления очков</a>
            </div>
            <div class="panel-footer tool-bar">
                <a href="index.php?action=logout">Выход</a>
            </div>
        </div>        
    </body>
</html>