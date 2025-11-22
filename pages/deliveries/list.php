<?php
include "../../includes/header.php";
include "../../config/db.php";
?>
<h1 class="text-3xl font-bold text-white mb-6">Delivery Orders</h1>

<table class="w-full text-left">
<tr class="bg-[#60519b] text-white">
    <th class="p-3">ID</th>
    <th class="p-3">Delivery No</th>
    <th class="p-3">Customer</th>
    <th class="p-3">Status</th>
    <th class="p-3">Action</th>
</tr>

<?php
$q = $conn->query("SELECT * FROM deliveries ORDER BY id DESC");
while ($r = $q->fetch_assoc()) {
    echo "<tr class='border-b border-[#31323e]'>
            <td class='p-3'>{$r['id']}</td>
            <td class='p-3'>".htmlspecialchars($r['delivery_no'])."</td>
            <td class='p-3'>".htmlspecialchars($r['customer'])."</td>
            <td class='p-3'>".htmlspecialchars($r['status'])."</td>
            <td class='p-3'><a href='view.php?id={$r['id']}' class='text-blue-400 underline'>Open</a></td>
          </tr>";
}
?>
</table>

<?php include "../../includes/footer.php"; ?>
