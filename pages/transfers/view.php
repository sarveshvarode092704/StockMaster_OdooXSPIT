<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
  :root {
    --dark1: #1e202c;
    --purple: #60519b;
    --dark2: #31323e;
    --light: #bfc0d1;
  }
</style>

<?php
// Validate ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "<div class='ml-64 p-10 text-red-400 text-xl'>Invalid Transfer ID</div>";
    include "../../includes/footer.php";
    exit;
}

$id = intval($_GET["id"]);

// Fetch transfer (FIXED COLUMN NAMES)
$transfer = $conn->query("
    SELECT t.*, 
           ws.name AS source_name, 
           wd.name AS dest_name
    FROM transfers t
    JOIN warehouses ws ON t.from_warehouse = ws.id
    JOIN warehouses wd ON t.to_warehouse = wd.id
    WHERE t.id = $id
")->fetch_assoc();

if (!$transfer) {
    echo "<div class='ml-64 p-10 text-red-400 text-xl'>Transfer Not Found</div>";
    include "../../includes/footer.php";
    exit;
}

// Fetch items
$items = $conn->query("
    SELECT ti.*, p.name AS product_name
    FROM transfer_items ti
    JOIN products p ON ti.product_id = p.id
    WHERE ti.transfer_id = $id
");
?>

<div class="ml-64 p-10 text-[var(--light)]">

    <h1 class="text-3xl font-bold text-white mb-6">Transfer #<?= $id ?></h1>

    <!-- Transfer Summary -->
    <div class="bg-[var(--dark2)] p-8 rounded-2xl border border-[var(--purple)] shadow-xl mb-8">

        <div class="grid grid-cols-2 gap-6">

            <div>
                <p class="text-lg">
                    <span class="font-semibold text-white">Source Warehouse:</span><br>
                    <?= htmlspecialchars($transfer["source_name"]); ?>
                </p>
            </div>

            <div>
                <p class="text-lg">
                    <span class="font-semibold text-white">Destination Warehouse:</span><br>
                    <?= htmlspecialchars($transfer["dest_name"]); ?>
                </p>
            </div>

            <div>
                <p class="text-lg">
                    <span class="font-semibold text-white">Status:</span><br>
                    <span class="px-3 py-1 rounded bg-[var(--purple)] text-white">
                        <?= $transfer["status"]; ?>
                    </span>
                </p>
            </div>

            <div>
                <p class="text-lg">
                    <span class="font-semibold text-white">Created At:</span><br>
                    <?= $transfer["created_at"]; ?>
                </p>
            </div>

        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-[var(--dark2)] p-8 rounded-2xl border border-[var(--purple)] shadow-xl">

        <h2 class="text-2xl font-semibold mb-4 text-white">Products in Transfer</h2>

        <table class="w-full text-left">
            <thead>
                <tr class="bg-[var(--purple)] text-white">
                    <th class="py-3 px-3">Product</th>
                    <th class="py-3 px-3">Quantity</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($items->num_rows == 0) {
                    echo "
                    <tr>
                        <td colspan='2' class='py-4 text-center text-[var(--light)]'>
                            No items found for this transfer.
                        </td>
                    </tr>";
                }

                while ($i = $items->fetch_assoc()) {
                    echo "
                    <tr class='border-b border-[#31323e] hover:bg-[#2a2b38] transition'>
                        <td class='py-3 px-3'>" . htmlspecialchars($i["product_name"]) . "</td>
                        <td class='py-3 px-3'>" . $i["quantity"] . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Validate Transfer -->
    <?php if ($transfer["status"] === "Draft") { ?>
        <form action="../../actions/validate_transfer_action.php" method="POST" class="mt-6">
            <input type="hidden" name="id" value="<?= $id ?>">

            <button class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                Validate Transfer
            </button>
        </form>
    <?php } ?>

</div>

<?php include "../../includes/footer.php"; ?>
