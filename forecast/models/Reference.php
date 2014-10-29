<?php

namespace forecast;

class Reference extends MongoModel
{

    protected $collection_name = 'reference';
    private $supported_types = array('stage', 'team', 'driver');

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
    
    
    public function addNewItem($data) {
        if (in_array($data['type'], $this->supported_types)) {
            $count = $this->collection->find(array('_id' => $data['name'], 'type' => $data['type']))->count();
            if($count === 0){
                $result = $this->collection->insert(array('_id' => trim($data['name']), 'type' => $data['type']));

                return true;
            }
            
            return 'unknown_item_type';
        }
        
        return 'unknown_item_type';
    }

}
