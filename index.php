<?php

use GabrielBinottiDatabase\Connection;

require_once "vendor/autoload.php";
require_once "classes/ProductGateway.php";
require_once "classes/Product.php";

try{

    $product = new Product;

    Connection::init('database');
    $pdo = Connection::get();
    $product->setConnection($pdo);


    // Insert
    // $product->name = "Notebook";
    // $product->price = 3526.25;
    // $product->qtd = 80;
    // $product->dt = date('Y-m-d');
    // print_r($product->save());
    
    // Delete
    // $product->idProduct = 1;
    // print_r($product->delete());

    // Select
    //print_r($product->find(2, 'Product'));

    // Select All
    //print_r($product->all(null, 'Product'));


    // Update
    $product->idProduct = 3;
    $product->name = "Monitor";
    $product->price = 3526.25;
    $product->qtd = 85;
    $product->dt = date('Y-m-d');
    print_r($product->save());



    Connection::close();


}catch(Exception $e){
    echo $e->getMessage();
}