<?php

namespace forecast;

class Seasons
{
    private $collection;
    
    function __construct() {
        $mongo = Mongo::getMongo();
        $this->collection = $mongo->forecast->seasons;
    }

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
}
