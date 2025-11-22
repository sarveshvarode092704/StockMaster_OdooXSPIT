<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="ml-64 p-10 text-[#bfc0d1]">

    <!-- PAGE HEADER -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">Stock Overview</h1>
        <div class="h-1 w-20 bg-[#60519b] rounded"></div>

        <p class="mt-2 text-sm text-[#bfc0d1]/70">
            Inventory / <span class="text-[#60519b]">Stock</span>
        </p>
    </div>

    <!-- Stock Table -->
    <div class="bg-[#31323e] p-8 rounded-2xl border border-[#60519b] shadow-xl">

        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#60519b] text-white">
                    <th class="py-3 px-3">Product</th>
                    <th class="py-3 px-3">Warehouse</th>
                    <th class="py-3 px-3">Quantity</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $q = $conn->query("
                    SELECT s.*, p.name AS product_name, w.name AS warehouse_name
                    FROM stock s
                    JOIN products p ON s.product_id = p.id
                    JOIN warehouses w ON s.warehouse_id = w.id
                    ORDER BY p.name ASC
                ");

                if ($q->num_rows == 0) {
                    echo "
                    <tr>
                        <td colspan='3' class='py-5 text-center text-[#bfc0d1]'>
                            No stock records found.
                        </td>
                    </tr>";
                }

                while ($row = $q->fetch_assoc()) {
                    $low = ($row['quantity'] <= 5); // Example low stock rule
                    $qtyClass = $low ? "text-red-400 font-semibold" : "text-[#bfc0d1]";
                    echo "
                    <tr class='border-b border-[#1e202c] hover:bg-[#2a2b38] transition'>
                        <td class='py-3 px-3'>".htmlspecialchars($row['product_name'])."</td>
                        <td class='py-3 px-3'>".htmlspecialchars($row['warehouse_name'])."</td>
                        <td class='py-3 px-3 $qtyClass'>{$row['quantity']}</td>
                    </tr>
                    ";
                }
            ?>
            </tbody>
        </table>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>
