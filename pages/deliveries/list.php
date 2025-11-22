<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<h1 class="text-2xl mb-4">Delivery Orders</h1>

<table class="w-full">
<tr class="bg-[#60519b] text-white">
    <th>ID</th><th>Customer</th><th>Status</th><th>Action</th>
</tr>

<?php
$q = $conn->query("SELECT * FROM deliveries ORDER BY id DESC");
while ($d = $q->fetch_assoc()) {
    echo "<tr class='border-b border-[#31323e]'>
            <td>{$d['id']}</td>
            <td>{$d['customer']}</td>
            <td>{$d['status']}</td>
            <td><a href='view.php?id={$d['id']}' class='text-[#bfc0d1]'>Open</a></td>
          </tr>";
}
?>
</table>

<?php include "../../includes/footer.php"; ?>
