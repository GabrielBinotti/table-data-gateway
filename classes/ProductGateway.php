<?php


class ProductGateway
{

    private $pdo;

    public function setConnection($pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id, string $class = 'stdClass')
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE idProduct = :id");
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject($class);
    }

    public function all(string $filter = null, string $class = 'stdClass')
    {
        $sql = "SELECT * FROM product";

        if ($filter) {
            $sql .= " WHERE {$filter}";
        }
        $stmt = $this->pdo->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM product WHERE idProduct = :id");
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save(Product $product)
    {
        if (empty($product->idProduct)) {
            $stmt = $this->pdo->prepare("INSERT INTO product (name, price, qtd, dt) VALUES(:name, :price, :qtd, :dt)");
            $stmt->bindValue(":name",   $product->name,     \PDO::PARAM_INT);
            $stmt->bindValue(":price",  $product->price,    \PDO::PARAM_STR);
            $stmt->bindValue(":qtd",    $product->qtd,      \PDO::PARAM_INT);
            $stmt->bindValue(":dt",     $product->dt,       \PDO::PARAM_STR);
            return $stmt->execute();
        } else {

            $stmt = $this->pdo->prepare("UPDATE db_store SET name = :name, price = :price, qtd = :qtd, dt = :dt WHERE idProduct = :id)");
            $stmt->bindValue(":name",       $product->name,         \PDO::PARAM_INT);
            $stmt->bindValue(":price",      $product->price,        \PDO::PARAM_STR);
            $stmt->bindValue(":qtd",        $product->qtd,          \PDO::PARAM_INT);
            $stmt->bindValue(":dt",         $product->dt,           \PDO::PARAM_STR);
            $stmt->bindValue(":ipProduct",  $product->idProduct,    \PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
}
