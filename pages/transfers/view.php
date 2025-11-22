<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<?php
$id = $_GET['id'];

$t = $conn->query("
    SELECT t.*, ws.name AS source_name, wd.name AS dest_name 
    FROM transfers t
    JOIN warehouses ws ON ws.id = t.source_warehouse
    JOIN warehouses wd ON wd.id = t.destination_warehouse
    WHERE t.id = $id
")->fetch_assoc();

$items = $conn->query("SELECT * FROM transfer_items WHERE transfer_id=$id");
?>

<h1 class="text-2xl mb-4">Transfer #<?php echo $id; ?></h1>

<p>Source: <?php echo $t['source_name']; ?></p>
<p>Destination: <?php echo $t['dest_name']; ?></p>
<p>Status: <?php echo $t['status']; ?></p>

<table class="w-full mt-4">
<tr class="bg-[#60519b] text-white">
    <th>Product</th>
    <th>Quantity</th>
</tr>

<?php while ($i = $items->fetch_assoc()) { ?>
<tr class="border-b border-[#31323e]">
    <td><?php echo $i['product_id']; ?></td>
    <td><?php echo $i['quantity']; ?></td>
</tr>
<?php } ?>
</table>

<?php if ($t['status'] == "Draft") { ?>
<form action="../../actions/validate_transfer_action.php" method="POST" class="mt-6">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Validate Transfer</button>
</form>
<?php } ?>

<?php include "../../includes/footer.php"; ?>
