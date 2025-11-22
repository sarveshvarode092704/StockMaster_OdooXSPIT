<?php
include "../../includes/header.php";
include "../../config/db.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list.php?error=missing_id");
    exit;
}
$id = intval($_GET['id']);

$delivery = $conn->prepare("SELECT * FROM deliveries WHERE id = ?");
$delivery->bind_param("i", $id);
$delivery->execute();
$delivery = $delivery->get_result()->fetch_assoc();
if (!$delivery) { header("Location: list.php?error=not_found"); exit; }

$itemsStmt = $conn->prepare("SELECT di.*, p.name AS product_name FROM delivery_items di JOIN products p ON p.id = di.product_id WHERE di.delivery_id = ?");
$itemsStmt->bind_param("i", $id);
$itemsStmt->execute();
$items = $itemsStmt->get_result();
?>

<h1 class="text-3xl font-bold text-white mb-6">Delivery <?php echo htmlspecialchars($delivery['delivery_no']); ?></h1>
<p class="mb-2 text-[#bfc0d1]"><strong>Customer:</strong> <?php echo htmlspecialchars($delivery['customer']); ?></p>
<p class="mb-2 text-[#bfc0d1]"><strong>Status:</strong> <?php echo htmlspecialchars($delivery['status']); ?></p>
<p class="mb-4 text-[#bfc0d1]"><strong>Warehouse ID:</strong> <?php echo intval($delivery['warehouse_id']); ?></p>

<table class="w-full mt-6 text-left">
<tr class="bg-[#60519b] text-white">
    <th class="p-3">Product</th>
    <th class="p-3">Quantity</th>
</tr>

<?php while ($i = $items->fetch_assoc()) { ?>
<tr class="border-b border-[#31323e]">
    <td class="p-3"><?php echo htmlspecialchars($i['product_name']); ?></td>
    <td class="p-3"><?php echo $i['quantity']; ?></td>
</tr>
<?php } ?>
</table>

<?php if ($delivery['status'] === "Draft") { ?>
<form action="/StockMaster_OdooXSPIT/actions/validate_delivery_action.php" method="POST" class="mt-6">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button class="px-6 py-3 bg-red-600 text-white rounded">Validate Delivery</button>
</form>
<?php } ?>

<?php include "../../includes/footer.php"; ?>
