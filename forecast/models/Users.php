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
            'firstname' => 1,
            'lastname' => 1,
            'active' => 1,
        );
        $result = array();
        $cursor = $this->collection->find()->fields($fields)->sort(array('username' => 1));
        $currentElement = $cursor->getNext();
        while($currentElement){
            $currentElement['_id'] = $currentElement['_id']->__toString();
            $result[] = $currentElement;
            $currentElement = $cursor->getNext();
        }
        
        return $result;
    }
    
    public function activateDeactivate($id, $active) {
        $filter = array('_id' => new \MongoId($id));
        $count = $this->collection->find($filter)->count();

        if($count === 1){
            $this->collection->update($filter, array('$set' => array('active' => $active)));
            
            return true;
        }
        
        return 'user_not_exists';
    }
}
