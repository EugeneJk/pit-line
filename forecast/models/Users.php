<?php
namespace forecast;

class Users extends MongoModel
{
    protected $collection_name = 'users';
    private $fieldsCollection = array('_id', 'username', 'password', 'role', 'firstname', 'lastname', 'active');


    public function login($username, $password){
        $filter = array(
            'username' => $username,
            'password' => $password,
            'active' => true,
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
            'role' => 1,
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
    
    public function getUser($id){
        if($id !== 'new'){
            $filter = array('_id' => new \MongoId($id));
            $result = $this->collection->findOne($filter);
            $result['_id'] = $result['_id']->__toString();
            $result['password'] = '';
            $result['active'] = $result['active'] ? 'yes' : 'no';
        } else {
            $result = array(
                'username' => '',
                'password' => '',
                'role' => 'user',
                'firstname' => '',
                'lastname' => '',
                'active' => 'yes',
            );
        }
        return $result;
    }
    
    public function setUser($data){
        
        $id = null;
        if(!empty($data['_id'])){
            $id = $data['_id'];
        } else {
            if(empty($data['password'])){
                unset($data['password']);
            }
        }
        $data['active'] = $data['active'] === 'yes';
        unset($data['_id']);
        
        $emptyFields = array();
        foreach($data as $key => $value){
            if(!in_array($key, $this->fieldsCollection)){
                unset($data[$key]);
                continue;
            }
            
            if(empty(trim($value))){
                $emptyFields[] = $key;
            }
        }

        if(!empty($emptyFields)){
            return array('error' => 'empty_fields', 'fields' => $emptyFields);
        }
        
        if(empty($id)){
            $this->collection->insert($data);
        } else {
            $filter = array('_id' => new \MongoId($id));
            if($this->collection->find($filter)->count() == 0){
                return array('error' => 'user_not_found', 'fields' => null);
            } else {
                $this->collection->update($filter,array('$set' => $data));
            }
        }
        
        return true;
    }
}
