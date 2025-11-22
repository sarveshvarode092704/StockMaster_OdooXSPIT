<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<h1 class="text-2xl mb-4">Receipts</h1>

<table class="w-full">
<tr class="bg-[#60519b] text-white">
    <th>ID</th><th>Supplier</th><th>Status</th><th>Action</th>
</tr>

<?php
$q = $conn->query("SELECT * FROM receipts ORDER BY id DESC");
while($r = $q->fetch_assoc()) {
    echo "<tr class='border-b border-[#31323e]'>
            <td>{$r['id']}</td>
            <td>{$r['supplier']}</td>
            <td>{$r['status']}</td>
            <td><a href='view.php?id={$r['id']}' class='text-[#bfc0d1]'>Open</a></td>
          </tr>";
}
?>
</table>

<?php include "../../includes/footer.php"; ?>
