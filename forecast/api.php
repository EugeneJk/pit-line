<?php
    include_once 'include.php';

    use forecast\User;
    use forecast\Seasons;
    use \forecast\Reference;
    
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

        case 'add_reference_item':
            $reference = new Reference();
            $opRes = $reference->addNewItem($data);
            $result['success'] = $opRes === true;
            $result['error'] = $result['success'] ? '' : $opRes;
            $result['inserted_item'] = $result['success'] ? $data : null;
            break;

        case 'make_forecast':
            break;
    }
    
    echo json_encode($result);
    