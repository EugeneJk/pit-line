<?php

namespace forecast;

class Reference extends MongoModel
{

    protected $collection_name = 'reference';

    public function getDriversList()
    {

        $result = array();
        $cursor = $this->collection->find(array('type' => 'driver'))->fields(array('_id' => true));
        $currentElement = $cursor->getNext();
        while($currentElement)
        {
            $result[] = $currentElement['_id'];
            $currentElement = $cursor->getNext();
        }
        
        return $result;
    }
}
