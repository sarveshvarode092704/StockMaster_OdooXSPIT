<?php
include "../config/db.php";

$id = $_POST['id'];

$t = $conn->query("SELECT * FROM transfers WHERE id=$id")->fetch_assoc();
$source = $t['source_warehouse'];
$dest = $t['destination_warehouse'];

$items = $conn->query("SELECT * FROM transfer_items WHERE transfer_id=$id");

while ($i = $items->fetch_assoc()) {

    $product = $i['product_id'];
    $qty = $i['quantity'];

    // Decrease stock from source
    $conn->query("
        UPDATE stock SET quantity = quantity - $qty
        WHERE product_id=$product AND warehouse_id=$source
    ");

    // Increase stock at destination
    $conn->query("
        UPDATE stock SET quantity = quantity + $qty
        WHERE product_id=$product AND warehouse_id=$dest
    ");

    // If destination has no entry, insert new
    if ($conn->affected_rows == 0) {
        $conn->query("
            INSERT INTO stock (product_id, warehouse_id, quantity)
            VALUES ($product, $dest, $qty)
        ");
    }
}

$conn->query("UPDATE transfers SET status='Done' WHERE id=$id");

header("Location: ../pages/transfers/view.php?id=$id");
