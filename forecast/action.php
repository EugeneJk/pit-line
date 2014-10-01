<?php
    $input = json_decode(file_get_contents("php://input"),true);
    
    if(!isset($_SESSION)){
        session_start();
    }
    $result = array('success' => false, 'error' => 'unknown_action');
    if(!isset($_SESSION['forecast'])){
        $_SESSION['forecast'] = array(
            'user' => null,
            'is_logged' => false,
        );
    }

    $action = (isset($input['action'])) ? $input['action'] : null;
    $data = (isset($input['data'])) ? $input['data'] : null;
    
    switch($action){
        case 'login':
            $mongo = new MongoClient("mongodb://localhost");
            $filter = array('username' => $data['username'], 'password' => $data['password']);
            $cursor = $mongo->forecast->users->find($filter);
            $user = $cursor->getNext();
            if($user){
                $_SESSION['forecast'] = array(
                    'user' => $user,
                    'is_logged' => true,
                );
                $result['success'] = true;
                $result['error'] = '';
                $result['data'] = $user;
            } else {
                $result['error'] = 'incorrect_login_password';
            }
            break;
        case 'make_forecast':
            break;
    }
    
    echo json_encode($result);
    