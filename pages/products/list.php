<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<h1 class="text-3xl font-bold mb-6">Products</h1>

<a href="add.php" class="px-4 py-2 bg-[#60519b] text-white rounded mb-4 inline-block">
    + Add Product
</a>

<table class="w-full text-left">
<tr class="bg-[#60519b] text-white">
    <th class="p-3">ID</th>
    <th class="p-3">Name</th>
    <th class="p-3">SKU</th>
    <th class="p-3">Category</th>
    <th class="p-3">Reorder Level</th>
    <th class="p-3">Total Stock</th>
    <th class="p-3">Action</th>
</tr>

<?php
// Fetch products + total stock
$sql = "
    SELECT p.id, p.name, p.sku, p.category, p.reorder_level,
           COALESCE(SUM(s.quantity), 0) AS total_stock
    FROM products p
    LEFT JOIN stock s ON s.product_id = p.id
    GROUP BY p.id
    ORDER BY p.id DESC
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-b border-[#31323e]'>
                <td class='p-3'>{$row['id']}</td>
                <td class='p-3'>" . htmlspecialchars($row['name']) . "</td>
                <td class='p-3'>" . htmlspecialchars($row['sku']) . "</td>
                <td class='p-3'>" . htmlspecialchars($row['category']) . "</td>
                <td class='p-3'>" . htmlspecialchars($row['reorder_level']) . "</td>
                <td class='p-3'>{$row['total_stock']}</td>
                <td class='p-3'>
                    <a href='edit.php?id={$row['id']}' class='text-blue-400 underline'>Edit</a> |
                    <a href='../../actions/delete_product_action.php?id={$row['id']}' 
                       class='text-red-400 underline' onclick=\"return confirm('Delete product?');\">
                       Delete
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td class='p-3' colspan='7'>No products found.</td></tr>";
}
?>
</table>

<?php include "../../includes/footer.php"; ?>
