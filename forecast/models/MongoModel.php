<?php

namespace forecast;

class MongoModel
{
    protected $collection_name;
    protected $collection;
    
    function __construct() {
        $mongo = Mongo::getMongo();
        $this->collection = $mongo->forecast->{$this->collection_name};
    }

    public function find($filter = array(), $fields = array()){
        $result = array();
        if(!empty($fields)){
            $cursor = $this->collection->find($filter)->fields($fields);
        } else {
            $cursor = $this->collection->find($filter);
        }
        
        $currentElement = $cursor->getNext();
        while($currentElement){
            $result[] = $currentElement;
            $currentElement = $cursor->getNext();
        }
        
        return $result;        
    }
    
    public function findOne($filter = array(), $fields = array()){
        if(!empty($fields)){
            return $this->collection->findOne($filter)->fields($fields);
        } else {
            return $this->collection->findOne($filter);
        }
    }
    
    public function count($filter = array()){
        return $this->collection->find($filter)->count();
    }
    
}
