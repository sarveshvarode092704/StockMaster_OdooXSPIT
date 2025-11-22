<?php
include "../config/db.php";

$supplier = $_POST['supplier'];
$warehouse_id = $_POST['warehouse_id'];
$products = $_POST['product_id'];
$qtys = $_POST['qty'];

$invoice_name = "";
if (!empty($_FILES["invoice"]["name"])) {
    $invoice_name = "inv_" . time() . "_" . basename($_FILES["invoice"]["name"]);
    move_uploaded_file($_FILES["invoice"]["tmp_name"], "../assets/images/" . $invoice_name);
}

$conn->query("INSERT INTO receipts (supplier, warehouse_id, invoice, status)
              VALUES('$supplier', $warehouse_id, '$invoice_name', 'Draft')");

$receipt_id = $conn->insert_id;

for ($i = 0; $i < count($products); $i++) {
    $conn->query("INSERT INTO receipt_items (receipt_id, product_id, quantity)
                  VALUES($receipt_id, {$products[$i]}, {$qtys[$i]})");
}

header("Location: ../pages/receipts/view.php?id=$receipt_id");
