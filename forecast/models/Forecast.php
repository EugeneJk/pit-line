<?php
namespace forecast;

class Forecast extends MongoModel
{
    protected $collection_name = 'forecast';
    
    public function getActiveSeasons(){
        return array(
            array(
                'name' => 'Formula 1 2014',
                'stages' => array(
                    'finished' => array('Stage 1', 'Stage 2', 'Stage 3', 'Stage 4'),
                    'current' => 'Stage 5',
                    'expected' => array('Stage 6', 'Stage 7',),
                ),
            )
        );
    }
    
}
