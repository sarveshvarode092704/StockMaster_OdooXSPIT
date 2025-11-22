<?php
include "../config/db.php";

$source = $_POST['source_warehouse'];
$dest = $_POST['destination_warehouse'];
$products = $_POST['product_id'];
$qtys = $_POST['qty'];

$conn->query("
    INSERT INTO transfers (source_warehouse, destination_warehouse, status)
    VALUES ($source, $dest, 'Draft')
");

$transfer_id = $conn->insert_id;

for ($i = 0; $i < count($products); $i++) {
    $conn->query("
        INSERT INTO transfer_items (transfer_id, product_id, quantity)
        VALUES ($transfer_id, {$products[$i]}, {$qtys[$i]})
    ");
}

header("Location: ../pages/transfers/view.php?id=$transfer_id");
