<?php
namespace forecast;

class Forecast extends MongoModel
{
    protected $collection_name = 'forecast';
    
    public function getActiveSeasons(){
        $seasons = new Seasons();
        $activeSeasons = $seasons->getActiveSeasons();
        $filter = array(
            '_id' => array('$in' => $seasons->getActiveSeasons()),
        );

        $activeForecastsCount = $this->count($filter);
        
        if(count($activeSeasons) !== $activeForecastsCount){
            foreach($activeSeasons as $item){
                $currentFilter = array('_id' => $item);
                $isExists = $this->collection->find($currentFilter)->count() === 1;
                if(!$isExists){
                    $seasonData = $seasons->findOne($currentFilter);
                    $itemToInsert = array(
                        '_id' => $item,
                        'stages' => array(),
                    );
                    //foreach($seasonData[] as $)
                    //$this->
                    //var_dump();
                }
            }
        }
        
        $activeForecasts = $this->find($filter,array('_id' => true, 'stages' => true));
        
        //var_dump($activeSeasons,$activeForecasts);
        
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
