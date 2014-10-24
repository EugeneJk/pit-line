<?php
namespace forecast;

class User {
    private $collection;
    
    function __construct() {
        if(!isset($_SESSION['forecast']['mongo'])){
            $_SESSION['forecast']['mongo'] = new \MongoClient("mongodb://localhost");
        }
        $this->collection = $_SESSION['forecast']['mongo']->forecast->users;
    }
    
    public function login($username, $password){
        $filter = array(
            'username' => $username,
            'password' => $password
        );
        $user = $this->collection->findOne($filter);
        if($user){
            $session = new Session();
            $session->setUser($user);
            return true;
        }
        
        return false;
    }

    public function logout(){
        $session = new Session();
        $session->setUser(null);
    }
}
