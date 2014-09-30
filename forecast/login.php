<?php
    $data = json_decode(file_get_contents("php://input"),true);
    $result = array('success' => false, 'error' => 'unknown');
            
    if( true){
        if(isset($_SESSION['forecast']['logged']) && $_SESSION['forecast']['logged']){
            $result['success'] = true;
            $result['error'] = '';
        }
        else{
            $result['error'] = 'not_logged';
        }
        
    } elseif(isset($data['login'])){
        $mongo = new MongoClient("mongodb://localhost");
        $filter = array('username' => 'EugeneJk');
        $cursor = $mongo->forecast->users->find($filter);
        $user = $cursor->getNext();
        if($user){
            var_dump($user);
        } else {
            var_dump('not found');
        }
    } else {
    }
    
    echo json_encode($result);
    