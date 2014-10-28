<?php
    include_once 'include.php';

    use forecast\User;
    use forecast\Seasons;
    
    $result = array('success' => false, 'error' => 'unknown_action');
    
    switch($action){
        case 'login':
            $user = new User();
            if($user->login($data['username'],$data['password'])){
                $result['success'] = true;
                $result['error'] = '';
            } else {
                $result['error'] = 'incorrect_login';
            }
            break;
            
        case 'save_season':
            $season = new Seasons();
            $season->setSeason($data);
            break;
        case 'make_forecast':
            break;
    }
    
    echo json_encode($result);
    