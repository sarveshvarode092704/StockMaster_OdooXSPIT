<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<h1 class="text-2xl mb-4">Internal Transfers</h1>

<table class="w-full">
<tr class="bg-[#60519b] text-white">
    <th>ID</th>
    <th>From</th>
    <th>To</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$q = $conn->query("
    SELECT t.*, 
        ws.name AS source_name,
        wd.name AS dest_name
    FROM transfers t
    JOIN warehouses ws ON t.source_warehouse = ws.id
    JOIN warehouses wd ON t.destination_warehouse = wd.id
    ORDER BY t.id DESC
");

while($t = $q->fetch_assoc()) {
    echo "
    <tr class='border-b border-[#31323e]'>
        <td>{$t['id']}</td>
        <td>{$t['source_name']}</td>
        <td>{$t['dest_name']}</td>
        <td>{$t['status']}</td>
        <td><a href='view.php?id={$t['id']}' class='text-[#bfc0d1]'>Open</a></td>
    </tr>";
}
?>
</table>

<?php include "../../includes/footer.php"; ?>
