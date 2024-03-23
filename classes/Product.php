<?php

class Product
{
    private $data;

    public function __get($name)
    {
        return $this->data[$name];
    }
}