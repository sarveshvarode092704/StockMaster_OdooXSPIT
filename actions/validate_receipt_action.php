<?php
include "../config/db.php";

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /StockMaster_OdooXSPIT/pages/receipts/list.php?error=invalid_request");
    exit;
}

$receipt_id = intval($_POST['id'] ?? 0);

if ($receipt_id <= 0) {
    header("Location: /StockMaster_OdooXSPIT/pages/receipts/list.php?error=invalid_id");
    exit;
}

// Fetch receipt
$receiptStmt = $conn->prepare("SELECT * FROM receipts WHERE id = ?");
$receiptStmt->bind_param("i", $receipt_id);
$receiptStmt->execute();
$receipt = $receiptStmt->get_result()->fetch_assoc();

if (!$receipt) {
    header("Location: /StockMaster_OdooXSPIT/pages/receipts/list.php?error=not_found");
    exit;
}

if ($receipt['status'] === "Done") {
    header("Location: /StockMaster_OdooXSPIT/pages/receipts/view.php?id=$receipt_id&error=already_validated");
    exit;
}

$warehouse_id = intval($receipt['warehouse_id']);

// Fetch receipt items
$itemsStmt = $conn->prepare("
    SELECT product_id, quantity
    FROM receipt_items
    WHERE receipt_id = ?
");
$itemsStmt->bind_param("i", $receipt_id);
$itemsStmt->execute();
$items = $itemsStmt->get_result();

$conn->begin_transaction();

try {

    // Process each item
    while ($item = $items->fetch_assoc()) {

        $product_id = intval($item['product_id']);
        $qty = floatval($item['quantity']);

        // Check if stock exists
        $stockCheck = $conn->prepare("
            SELECT id, quantity FROM stock
            WHERE warehouse_id = ? AND product_id = ?
        ");
        $stockCheck->bind_param("ii", $warehouse_id, $product_id);
        $stockCheck->execute();
        $stockResult = $stockCheck->get_result()->fetch_assoc();

        if ($stockResult) {
            // Update stock
            $newQty = $stockResult['quantity'] + $qty;
            $updateStock = $conn->prepare("
                UPDATE stock
                SET quantity = ?
                WHERE id = ?
            ");
            $updateStock->bind_param("di", $newQty, $stockResult['id']);
            $updateStock->execute();
        } else {
            // Insert new stock row
            $insertStock = $conn->prepare("
                INSERT INTO stock (product_id, warehouse_id, quantity)
                VALUES (?, ?, ?)
            ");
            $insertStock->bind_param("iid", $product_id, $warehouse_id, $qty);
            $insertStock->execute();
        }

        // Insert ledger entry
        $ledger = $conn->prepare("
            INSERT INTO ledger (product_id, warehouse_id, qty_change, type, reference, created_at)
            VALUES (?, ?, ?, 'receipt', ?, NOW())
        ");
        $ledger->bind_param("iids", $product_id, $warehouse_id, $qty, $receipt['receipt_no']);
        $ledger->execute();
    }

    // Update receipt status
    $updateStatus = $conn->prepare("
        UPDATE receipts SET status = 'Done' WHERE id = ?
    ");
    $updateStatus->bind_param("i", $receipt_id);
    $updateStatus->execute();

    $conn->commit();

    header("Location: /StockMaster_OdooXSPIT/pages/receipts/view.php?id=$receipt_id&success=validated");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    error_log("Receipt validation error: " . $e->getMessage());

    header("Location: /StockMaster_OdooXSPIT/pages/receipts/view.php?id=$receipt_id&error=validation_failed");
    exit;
}

?>
