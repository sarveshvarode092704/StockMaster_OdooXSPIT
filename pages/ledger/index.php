<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="ml-64 p-10 text-[#bfc0d1]">

    <!-- PAGE HEADER -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">Stock Ledger</h1>
        <div class="h-1 w-20 bg-[#60519b] rounded"></div>

        <p class="mt-2 text-sm text-[#bfc0d1]/70">
            Inventory / <span class="text-[#60519b]">Ledger</span>
        </p>
    </div>

    <!-- LEDGER TABLE -->
    <div class="bg-[#31323e] p-8 rounded-2xl border border-[#60519b] shadow-xl overflow-x-auto">

        <table class="w-full text-left min-w-[800px]">
            <thead>
                <tr class="bg-[#60519b] text-white">
                    <th class="py-3 px-3">Date</th>
                    <th class="py-3 px-3">Product</th>
                    <th class="py-3 px-3">Warehouse</th>
                    <th class="py-3 px-3">Reference</th>
                    <th class="py-3 px-3">Type</th>
                    <th class="py-3 px-3">Quantity</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = $conn->query("
                    SELECT l.*, 
                        p.name AS product_name,
                        w.name AS warehouse_name
                    FROM ledger l
                    JOIN products p ON l.product_id = p.id
                    JOIN warehouses w ON l.warehouse_id = w.id
                    ORDER BY l.created_at DESC
                ");

                if ($q->num_rows == 0) {
                    echo "
                    <tr>
                        <td colspan='6' class='py-5 text-center text-[#bfc0d1]'>
                            No ledger entries found.
                        </td>
                    </tr>";
                }

                while ($row = $q->fetch_assoc()) {

                    // Type color logic
                    $typeColor = "text-[#bfc0d1]";
                    if ($row["type"] === "IN")       $typeColor = "text-green-400 font-semibold";
                    if ($row["type"] === "OUT")      $typeColor = "text-red-400 font-semibold";
                    if ($row["type"] === "TRANSFER") $typeColor = "text-yellow-400 font-semibold";

                    echo "
                    <tr class='border-b border-[#1e202c] hover:bg-[#2a2b38] transition'>
                        <td class='py-3 px-3'>{$row['created_at']}</td>
                        <td class='py-3 px-3'>".htmlspecialchars($row['product_name'])."</td>
                        <td class='py-3 px-3'>".htmlspecialchars($row['warehouse_name'])."</td>
                        <td class='py-3 px-3'>".htmlspecialchars($row['reference'])."</td>
                        <td class='py-3 px-3 $typeColor'>{$row['type']}</td>
                        <td class='py-3 px-3'>{$row['quantity']}</td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>
