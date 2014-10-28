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
            return array(
                '_id' => '',
                'active' => true,
                'stages' => array(
                    'Тестовый Этап 1',
                    'Тестовый Этап 2',
                    'Тестовый Этап 3',
                ),
                'teams' => array(
                    array(
                        'name' => 'Red Bull',
                        'drivers' => array('Себастьян Феттель','Даниель Риккардо'),
                    ),
                    array(
                        'name' => 'Mercedes',
                    ),
                ),
                'rules' => array(),
            );
        } else {
            return $this->collection->findOne(array('_id' => $id));
        }
    }
}
