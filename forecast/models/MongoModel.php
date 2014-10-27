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

}
