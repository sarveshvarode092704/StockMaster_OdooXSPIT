<?php
include "../config/db.php";

// Required fields
if (!isset($_POST['name'], $_POST['sku'])) {
    header("Location: ../pages/products/add.php?error=missing_fields");
    exit;
}

$name = trim($_POST['name']);
$sku  = trim($_POST['sku']);
$category = trim($_POST['category']);
$reorder = intval($_POST['reorder_level']);

// Correct query for YOUR DB schema
$stmt = $conn->prepare("
    INSERT INTO products (name, sku, category, reorder_level)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("sssi", $name, $sku, $category, $reorder);

if ($stmt->execute()) {
    header("Location: ../pages/products/list.php?success=1");
    exit;
} else {
    header("Location: ../pages/products/add.php?error=db_error");
    exit;
}
?>
