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
        case 'save':
            $mongo->forecast->seasons->insert($data);
            break;
    }
    
    echo json_encode($result);
    