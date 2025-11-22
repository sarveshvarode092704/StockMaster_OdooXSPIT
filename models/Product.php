<?php

class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Fetch all products
    public function getAll()
    {
        return $this->conn->query("SELECT * FROM products ORDER BY id DESC");
    }

    // Fetch single product
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Add product
    public function add($name, $sku, $category, $uom)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (name, sku, category, uom) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $sku, $category, $uom);
        return $stmt->execute();
    }

    // Edit product
    public function update($id, $name, $sku, $category, $uom)
    {
        $stmt = $this->conn->prepare("UPDATE products SET name=?, sku=?, category=?, uom=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $sku, $category, $uom, $id);
        return $stmt->execute();
    }

    // Delete product
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>
