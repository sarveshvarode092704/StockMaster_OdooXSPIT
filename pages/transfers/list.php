<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="ml-64 p-10 text-[#bfc0d1]">

    <h1 class="text-3xl font-semibold mb-6 text-white">Internal Transfers</h1>

    <div class="bg-[#31323e] p-6 rounded-2xl shadow-lg border border-[#60519b]">

        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#60519b] text-white">
                    <th class="py-3 px-3">ID</th>
                    <th class="py-3 px-3">From</th>
                    <th class="py-3 px-3">To</th>
                    <th class="py-3 px-3">Status</th>
                    <th class="py-3 px-3">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $q = $conn->query("
                SELECT t.*, 
                    ws.name AS source_name,
                    wd.name AS dest_name
                FROM transfers t
                JOIN warehouses ws ON t.from_warehouse = ws.id
                JOIN warehouses wd ON t.to_warehouse = wd.id
                ORDER BY t.id DESC
            ");

            if ($q->num_rows == 0) {
                echo "
                <tr>
                    <td colspan='5' class='py-5 text-center text-[#bfc0d1]'>
                        No transfers found.
                    </td>
                </tr>";
            }

            while($t = $q->fetch_assoc()) {
                echo "
                <tr class='border-b border-[#31323e] hover:bg-[#2a2b38] transition'>
                    <td class='py-3 px-3'>{$t['id']}</td>
                    <td class='py-3 px-3'>{$t['source_name']}</td>
                    <td class='py-3 px-3'>{$t['dest_name']}</td>
                    <td class='py-3 px-3'>{$t['status']}</td>
                    <td class='py-3 px-3'>
                        <a href='view.php?id={$t['id']}'
                           class='text-[#60519b] hover:underline'>
                           View
                        </a>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>
