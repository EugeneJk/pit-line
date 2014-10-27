<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace forecast;

/**
 * Description of Mongo
 *
 * @author eugene
 */
class Mongo
{
    public static function getMongo(){
        return new \MongoClient("mongodb://localhost");
    }
}
