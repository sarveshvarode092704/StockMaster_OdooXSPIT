<?php
include "../config/db.php";

// Only allow POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /StockMaster_OdooXSPIT/pages/receipts/create.php?error=invalid_request");
    exit;
}

// Clean POST variables
$supplier       = trim($_POST['supplier'] ?? "");
$warehouse_id   = intval($_POST['warehouse_id'] ?? 0);
$products       = $_POST['product_id'] ?? [];
$qtys           = $_POST['qty'] ?? [];

// Validate required fields
if ($supplier === "" || $warehouse_id <= 0 || count($products) == 0) {
    header("Location: /StockMaster_OdooXSPIT/pages/receipts/create.php?error=missing_fields");
    exit;
}

$conn->begin_transaction();

try {

    // INSERT receipt (NO INVOICE FIELD!)
    $stmt = $conn->prepare("
        INSERT INTO receipts (supplier, warehouse_id, status, created_at)
        VALUES (?, ?, 'Draft', NOW())
    ");
    $stmt->bind_param("si", $supplier, $warehouse_id);
    $stmt->execute();
    $receipt_id = $stmt->insert_id;
    $stmt->close();

    // Prepare item insertion
    $itemStmt = $conn->prepare("
        INSERT INTO receipt_items (receipt_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");

    for ($i = 0; $i < count($products); $i++) {

        // Skip undefined inputs
        if (!isset($products[$i]) || !isset($qtys[$i])) continue;

        $pid = intval($products[$i]);
        $qty = floatval($qtys[$i]);

        if ($pid > 0 && $qty > 0) {
            $itemStmt->bind_param("iid", $receipt_id, $pid, $qty);
            $itemStmt->execute();
        }
    }

    $itemStmt->close();
    $conn->commit();

    header("Location: /StockMaster_OdooXSPIT/pages/receipts/view.php?id=$receipt_id");
    exit;

} catch (Exception $e) {

    $conn->rollback();
    error_log("Receipt creation failed: " . $e->getMessage());

    header("Location: /StockMaster_OdooXSPIT/pages/receipts/create.php?error=save_failed");
    exit;
}

?>
