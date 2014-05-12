<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$val = 0.005;
for($i = 0; $i < 1000; $i++){
    $val1 = $val +  $i * 0.01;
    $val2 = round($val1, 2);
    print "{$i}: {$val1} => {$val2} <br>";
}