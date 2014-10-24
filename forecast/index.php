<?php
    include_once 'include.php';

    switch ($action) {
        case 'login':
            include 'views/login.html.php';
            break;
        case 'options':
            include 'views/options.html.php';
            break;

        default:
            include 'views/error.html.php';
            break;
    }
