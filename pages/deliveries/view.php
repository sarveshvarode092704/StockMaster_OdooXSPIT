<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<?php
$id = $_GET['id'];
$delivery = $conn->query("SELECT * FROM deliveries WHERE id=$id")->fetch_assoc();
$items = $conn->query("SELECT * FROM delivery_items WHERE delivery_id=$id");
?>

<h1 class="text-2xl mb-4">Delivery #<?php echo $id; ?></h1>
<p>Customer: <?php echo $delivery['customer']; ?></p>
<p>Status: <?php echo $delivery['status']; ?></p>

<table class="w-full mt-4">
<tr class="bg-[#60519b] text-white">
    <th>Product</th><th>Quantity</th>
</tr>

<?php while ($i = $items->fetch_assoc()) { ?>
<tr class="border-b border-[#31323e]">
    <td><?php echo $i['product_id']; ?></td>
    <td><?php echo $i['quantity']; ?></td>
</tr>
<?php } ?>
</table>

<?php if ($delivery['status'] == "Draft") { ?>
<form action="../../actions/validate_delivery_action.php" method="POST" class="mt-6">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button class="px-4 py-2 bg-red-600 text-white rounded">Validate Delivery</button>
</form>
<?php } ?>

<?php include "../../includes/footer.php"; ?>
