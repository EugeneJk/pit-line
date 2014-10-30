<?php

include_once 'include.php';

use forecast\Users;

switch ($action) {
    case 'logout':
        $user = new Users();
        $user->logout();
    case 'login':
        include 'views/login.html.php';
        break;
    case 'options':
        include 'views/options.html.php';
        break;
    case 'seasons':
        include 'views/seasons.html.php';
        break;
    case 'selected_season':
        $selectedSeason = $_GET['season'];
        include 'views/selectedSeason.html.php';
        break;
    case 'reference':
        include 'views/reference.html.php';
        break;
    case 'users':
        include 'views/users.html.php';
        break;
    case 'selected_user':
        $selectedUser = $_GET['user'];
        include 'views/selectedUser.html.php';
        break;

    default:
        include 'views/error.html.php';
        break;
}
