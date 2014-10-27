<?php

namespace forecast;

class Mongo
{
    public static function getMongo(){
        return new \MongoClient("mongodb://localhost");
    }
}
