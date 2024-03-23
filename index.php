<?php

use GabrielBinottiDatabase\Connection;

require_once "vendor/autoload.php";
require_once "classes/ProductGateway.php";

try{

    $product = new ProductGateway;

    Connection::init('database');
    $pdo = Connection::get();
    $product->setConnection($pdo);

    print_r($product->all());



    Connection::close();


}catch(Exception $e){
    echo $e->getMessage();
}