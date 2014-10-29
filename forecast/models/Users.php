<?php
namespace forecast;

class Users extends MongoModel
{
    protected $collection_name = 'users';
    
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
    
    public function getUsersList(){
        $fields = array(
            '_id' => 1,
            'username' => 1,
        );
        $result = array();
        $cursor = $this->collection->find()->fields($fields)->sort(array('username' => 1));
        $currentElement = $cursor->getNext();
        while($currentElement){
            $result[] = $currentElement;
            $currentElement = $cursor->getNext();
        }
        
        return $result;
    }
}
