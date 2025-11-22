<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<?php
$id = $_GET['id'];
$receipt = $conn->query("SELECT * FROM receipts WHERE id=$id")->fetch_assoc();
$items = $conn->query("SELECT * FROM receipt_items WHERE receipt_id=$id");
?>

<h1 class="text-2xl mb-4">Receipt #<?php echo $id; ?></h1>
<p>Supplier: <?php echo $receipt['supplier']; ?></p>
<p>Status: <?php echo $receipt['status']; ?></p>

<?php if ($receipt['invoice']) { ?>
<p class="mt-2">Invoice: <a class="text-blue-400" href="../../assets/images/<?php echo $receipt['invoice']; ?>" download>Download</a></p>
<?php } ?>

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

<?php if ($receipt['status'] == "Draft") { ?>
<form action="../../actions/validate_receipt_action.php" method="POST" class="mt-6">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button class="px-4 py-2 bg-green-600 text-white rounded">Validate Receipt</button>
</form>
<?php } ?>

<?php include "../../includes/footer.php"; ?>
