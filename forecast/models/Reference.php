<?php

namespace forecast;

class Reference extends MongoModel
{

    protected $collection_name = 'reference';

    public function getDriversList()
    {
        return $this->getList('driver');
    }

    public function getStagesList()
    {
        return $this->getList('stage');
    }

    public function getTeamsList()
    {
        return $this->getList('team');
    }
    
    protected function getList($type){
        $result = array();
        $cursor = $this->collection->find(array('type' => $type))->fields(array('_id' => true));
        $currentElement = $cursor->getNext();
        while($currentElement)
        {
            $result[] = $currentElement['_id'];
            $currentElement = $cursor->getNext();
        }
        
        return $result;
    }
}
