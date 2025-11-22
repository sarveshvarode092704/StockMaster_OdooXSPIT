<?php
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/create.php?error=invalid_request");
    exit;
}

$delivery_no = trim($_POST['delivery_no'] ?? '');
$customer = trim($_POST['customer'] ?? '');
$warehouse_id = intval($_POST['warehouse_id'] ?? 0);
$products = $_POST['product_id'] ?? [];
$qtys = $_POST['qty'] ?? [];

if ($delivery_no === '' || $customer === '' || $warehouse_id === 0 || count($products) === 0) {
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/create.php?error=missing_fields");
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("INSERT INTO deliveries (delivery_no, customer, warehouse_id, status, created_at) VALUES (?, ?, ?, 'Draft', NOW())");
    $stmt->bind_param("ssi", $delivery_no, $customer, $warehouse_id);
    $stmt->execute();
    $delivery_id = $stmt->insert_id;
    $stmt->close();

    $itemStmt = $conn->prepare("INSERT INTO delivery_items (delivery_id, product_id, quantity) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($products); $i++) {
        $pid = intval($products[$i]);
        $q = floatval($qtys[$i] ?? 0);
        if ($pid > 0 && $q > 0) {
            $itemStmt->bind_param("iid", $delivery_id, $pid, $q);
            $itemStmt->execute();
        }
    }
    $itemStmt->close();

    $conn->commit();
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/view.php?id=$delivery_id");
    exit;
} catch (Exception $e) {
    $conn->rollback();
    error_log("Add delivery failed: " . $e->getMessage());
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/create.php?error=save_failed");
    exit;
}
