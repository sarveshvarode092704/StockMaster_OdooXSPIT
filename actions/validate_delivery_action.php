<?php
include "../config/db.php";

$id = $_POST['id'];

$d = $conn->query("SELECT * FROM deliveries WHERE id=$id")->fetch_assoc();
$warehouse = $d['warehouse_id'];

$items = $conn->query("SELECT * FROM delivery_items WHERE delivery_id=$id");

while ($i = $items->fetch_assoc()) {

    $conn->query("UPDATE stock 
                  SET quantity = quantity - {$i['quantity']}
                  WHERE product_id={$i['product_id']} AND warehouse_id=$warehouse");
}

$conn->query("UPDATE deliveries SET status='Done' WHERE id=$id");

header("Location: ../pages/deliveries/view.php?id=$id");
