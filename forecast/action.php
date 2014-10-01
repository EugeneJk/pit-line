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
    
    $mongo = new MongoClient("mongodb://localhost");
    switch($action){
        case 'login':
            $filter = array('username' => $data['username'], 'password' => $data['password']);
            $user = $mongo->forecast->users->findOne($filter);
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
            $year = (isset($input['year'])) ? intval($input['year']) : null;
            $stageNumber = (isset($input['stage_number'])) ? intval($input['stage_number']) : null;
            $filter = array('year' => $year);
            $season = $mongo->forecast->results->findOne($filter);
            if($season){
                $result['success'] = true;
                $result['error'] = '';
            } else {
                $result['error'] = 'wrong_submit';
            }
            break;
    }
    
    echo json_encode($result);
    