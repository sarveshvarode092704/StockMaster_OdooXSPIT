<?php
include "../config/db.php";

$id = $_POST['id'];

$r = $conn->query("SELECT * FROM receipts WHERE id=$id")->fetch_assoc();
$warehouse = $r['warehouse_id'];

$items = $conn->query("SELECT * FROM receipt_items WHERE receipt_id=$id");

while ($i = $items->fetch_assoc()) {

    $conn->query("UPDATE stock 
                  SET quantity = quantity + {$i['quantity']}
                  WHERE product_id={$i['product_id']} AND warehouse_id=$warehouse");

    if ($conn->affected_rows == 0) {
        $conn->query("INSERT INTO stock (product_id, warehouse_id, quantity)
                      VALUES ({$i['product_id']}, $warehouse, {$i['quantity']})");
    }
}

$conn->query("UPDATE receipts SET status='Done' WHERE id=$id");

header("Location: ../pages/receipts/view.php?id=$id");
