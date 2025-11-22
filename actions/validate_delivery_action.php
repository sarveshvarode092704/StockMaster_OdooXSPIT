<?php
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/list.php?error=invalid_request");
    exit;
}

$delivery_id = intval($_POST['id'] ?? 0);
if ($delivery_id <= 0) {
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/list.php?error=invalid_id");
    exit;
}

// Fetch delivery
$stmt = $conn->prepare("SELECT * FROM deliveries WHERE id = ?");
$stmt->bind_param("i", $delivery_id);
$stmt->execute();
$delivery = $stmt->get_result()->fetch_assoc();
if (!$delivery) { header("Location: /StockMaster_OdooXSPIT/pages/deliveries/list.php?error=not_found"); exit; }

if ($delivery['status'] === 'Done') {
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/view.php?id=$delivery_id&error=already_validated");
    exit;
}

$warehouse = intval($delivery['warehouse_id']);

$itemsStmt = $conn->prepare("SELECT product_id, quantity FROM delivery_items WHERE delivery_id = ?");
$itemsStmt->bind_param("i", $delivery_id);
$itemsStmt->execute();
$items = $itemsStmt->get_result();

$conn->begin_transaction();

try {
    while ($item = $items->fetch_assoc()) {
        $product_id = intval($item['product_id']);
        $qty = floatval($item['quantity']);

        // Try update
        $check = $conn->prepare("SELECT id, quantity FROM stock WHERE product_id = ? AND warehouse_id = ?");
        $check->bind_param("ii", $product_id, $warehouse);
        $check->execute();
        $stockRow = $check->get_result()->fetch_assoc();

        if ($stockRow) {
            $newQty = $stockRow['quantity'] - $qty;
            $upd = $conn->prepare("UPDATE stock SET quantity = ? WHERE id = ?");
            $upd->bind_param("di", $newQty, $stockRow['id']);
            $upd->execute();
        } else {
            // insert negative to reflect outflow (or you can block instead)
            $ins = $conn->prepare("INSERT INTO stock (product_id, warehouse_id, quantity) VALUES (?, ?, ?)");
            $neg = -$qty;
            $ins->bind_param("iid", $product_id, $warehouse, $neg);
            $ins->execute();
        }

        // Ledger entry
        $lg = $conn->prepare("INSERT INTO ledger (product_id, warehouse_id, qty_change, type, reference, created_at) VALUES (?, ?, ?, 'delivery', ?, NOW())");
        $lg->bind_param("iids", $product_id, $warehouse, $qty, $delivery['delivery_no']);
        $lg->execute();
    }

    // update status
    $u = $conn->prepare("UPDATE deliveries SET status = 'Done' WHERE id = ?");
    $u->bind_param("i", $delivery_id);
    $u->execute();

    $conn->commit();
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/view.php?id=$delivery_id&success=validated");
    exit;
} catch (Exception $e) {
    $conn->rollback();
    error_log("Validate delivery failed: " . $e->getMessage());
    header("Location: /StockMaster_OdooXSPIT/pages/deliveries/view.php?id=$delivery_id&error=validation_failed");
    exit;
}
