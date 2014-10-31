<?php
    include_once 'models/Session.php';
    use forecast\Session;
    
    $session = new Session();
    
    $script = explode('/', $_SERVER['SCRIPT_NAME']);
    if($script[count($script)-1] === 'api.php'){
        $input = json_decode(file_get_contents("php://input"),true);
        $action = (isset($input['action'])) ? $input['action'] : null;
        $data = (isset($input['data'])) ? $input['data'] : null;
    }else{
        $action = (isset($_GET['action'])) ? $_GET['action'] : null;
        if(!$session->isLogged()){
            $action = 'login';
        }
    }
    $user = $session->getUser();
    if(isset($user['role']) && $user['role'] === 'user' && in_array($action, array(
        'seasons','selected_season','reference','users','selected_user',
        'save_season','add_reference_item','activate_deactivate_user','save_user',
    ))){
        $action = null;
    }
    
    $models = array('Mongo', 'MongoModel', 'Users', 'Seasons', 'Reference');
    foreach($models as $model){
        include_once 'models/' . $model . '.php';
    }
    