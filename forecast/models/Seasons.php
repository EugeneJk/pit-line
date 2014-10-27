<?php

namespace forecast;

class Seasons extends MongoModel
{
    protected $collection_name = 'seasons';

    public function getSeasonsList()
    {
        $fields = array(
            '_id' => true,
            'active' => true,
        );
        $result = array();
        $cursor = $this->collection->find()->fields($fields)->sort(array('_id' => 1));
        $currentElement = $cursor->getNext();
        while($currentElement){
            $result[] = $currentElement;
            $currentElement = $cursor->getNext();
        }
        
        return $result;
    }
    
    public function getSeason($id)
    {
        if($id === 'new'){
            return array();
        } else {
            return $this->collection->findOne(array('_id' => $id));
        }
    }
}
