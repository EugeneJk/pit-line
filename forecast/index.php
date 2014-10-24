<?php

include_once 'include.php';

use forecast\User;

switch ($action) {
    case 'logout':
        $user = new User();
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
    case 'reference':
        include 'views/reference.html.php';
        break;
    case 'rules':
        include 'views/rules.html.php';
        break;
    case 'users':
        include 'views/users.html.php';
        break;

    default:
        include 'views/error.html.php';
        break;
}
