<?php

class Product
{
    private $data;
    private static$pdo;

    public function __get($name)
    {
        return $this->data[$name];
    }


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public static function setConnection($pdo)
    {
        self::$pdo = $pdo;
    }

    public static function find(int $id, string $class = 'stdClass')
    {
        $productGw = new ProductGateway;
        $productGw->setConnection(self::$pdo);
        return $productGw->find($id, $class);
    
    }

    public static function all(string $filter = null, string $class = 'stdClass')
    {
        $productGw = new ProductGateway;
        $productGw->setConnection(self::$pdo);
        return $productGw->all($filter, $class);
    }

    public function delete()
    {
        $productGw = new ProductGateway;
        $productGw->setConnection(self::$pdo);
        return $productGw->delete($this->data['idProduct']);
    }

    public function save()
    {
        $productGw = new ProductGateway;
        $productGw->setConnection(self::$pdo);
       
        return $productGw->save( (object) $this->data);
    }
}