<?php
include_once 'check.php';
use forecast\Users;

$user = new Users();
$userData = $user->getUser($selectedUser);
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
        <link href="/forecast/css/selectedUser.css" rel="stylesheet">
        <script src="/forecast/js/selectedUser.js"></script>
        <script src="/forecast/js/OnEnterEvent.js"></script>
    </head>
    <body ng-controller="UserController" ng-init="init('inputData')" class="system-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Пользователи</h3>
            </div>
            <div class="panel-body">
                <ol class="breadcrumb">
                    <li><a href="index.php?action=options">Панель управления системы "Прогноз"</a></li>
                    <li><a href="index.php?action=users">Пользователи</a></li>
                    <li class="active">{{user.username}}</li>
                </ol>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon form-label">Имя пользователя</span>
                            <input type="text" class="form-control" placeholder="Имя пользователя" ng-model="user.username">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon form-label">Пароль</span>
                            <input type="password" class="form-control" placeholder="Пароль" ng-model="user.password">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon form-label">Роль</span>
                            <select class="form-control" ng-model="user.role">
                                <option value="user">Пользователь</option>
                                <option value="admin">Администратор</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon form-label">Имя</span>
                            <input type="text" class="form-control" placeholder="Имя" ng-model="user.firstname">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon form-label">Фамилия</span>
                            <input type="text" class="form-control" placeholder="Фамилия" ng-model="user.lastname">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon form-label">Активен</span>
                            <select class="form-control" ng-model="user.active">
                                <option value="yes">Да</option>
                                <option value="no">Нет</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="button-panel">
                    <a href="index.php?action=users" class="btn btn-default">Отмена</a>
                    <button type="button" class="btn btn-primary" ng-click="saveUser();">
                        Сохранить <span class="glyphicon glyphicon-floppy-disk"></span>
                    </button>
                </div>
            </div>
            <div class="panel-footer tool-bar">
                <a href="index.php?action=logout">Выход</a>
            </div>
        </div>
        <script type="text/javascript">
            function inputData() {
                return {
                    user : <?php echo json_encode($userData); ?>,
                };
            };
        </script>
    </body>
</html>