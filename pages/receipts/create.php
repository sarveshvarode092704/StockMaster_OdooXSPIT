<?php 
include "../../includes/header.php"; 
include "../../config/db.php"; 

// Auto-generate receipt number
$last = $conn->query("SELECT id FROM receipts ORDER BY id DESC LIMIT 1")->fetch_assoc();
$next = $last ? $last['id'] + 1 : 1;
$receipt_no = "REC-" . str_pad($next, 4, "0", STR_PAD_LEFT);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Create Receipt</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --dark1: #1e202c;
      --dark2: #31323e;
      --purple: #60519b;
      --light: #bfc0d1;
    }
  </style>
</head>

<body class="bg-[var(--dark1)] text-[var(--light)] min-h-screen">
<main class="p-6 ml-64">
<div class="max-w-3xl mx-auto bg-[var(--dark2)] p-8 rounded-2xl shadow-xl border border-[var(--purple)]">

  <h1 class="text-3xl font-bold text-center text-white mb-6">Create Receipt</h1>

  <!-- FORM START -->
  <form action="/StockMaster_OdooXSPIT/actions/add_receipt_action.php" method="POST" class="space-y-6">

    <!-- Hidden receipt no -->
    <input type="hidden" name="receipt_no" value="<?php echo htmlspecialchars($receipt_no); ?>">

    <!-- Receipt No -->
    <div>
      <label class="block text-[var(--light)] mb-1">Receipt No</label>
      <input type="text" value="<?php echo htmlspecialchars($receipt_no); ?>" 
             disabled
             class="w-full p-3 bg-[var(--dark1)] rounded-lg text-white border border-[var(--light)]">
    </div>

    <!-- Supplier -->
    <div>
      <label class="block text-[var(--light)] mb-1">Supplier Name</label>
      <input type="text" name="supplier" required
             placeholder="Enter supplier name"
             class="w-full p-3 bg-[var(--dark1)] rounded-lg text-white border border-[var(--light)]
                    focus:ring-2 focus:ring-[var(--purple)] focus:border-[var(--purple)]">
    </div>

    <!-- Warehouse -->
    <div>
      <label class="block text-[var(--light)] mb-1">Select Warehouse</label>
      <select name="warehouse_id" required
              class="w-full p-3 bg-[var(--dark1)] rounded-lg text-white border border-[var(--light)]">
        <option value="">Choose warehouse</option>
        <?php
        $wh = $conn->query("SELECT * FROM warehouses");
        while ($row = $wh->fetch_assoc()) {
          echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
        }
        ?>
      </select>
    </div>

    <!-- Items Header -->
    <h2 class="text-xl font-semibold text-white mt-6">Items</h2>

    <!-- Items Container -->
    <div id="items" class="space-y-3">
      <!-- Item Row -->
      <div class="flex gap-4">
        
        <!-- Product -->
        <select name="product_id[]"
                class="w-1/2 p-3 bg-[var(--dark1)] rounded-lg text-white border border-[var(--light)]">
          <?php
          $p = $conn->query("SELECT * FROM products");
          while ($prod = $p->fetch_assoc()) {
            echo "<option value='{$prod['id']}'>" . htmlspecialchars($prod['name']) . "</option>";
          }
          ?>
        </select>

        <!-- Quantity -->
        <input type="number" step="0.01" name="qty[]" required
               placeholder="Quantity"
               class="w-1/2 p-3 bg-[var(--dark1)] rounded-lg text-white border border-[var(--light)]
                      focus:ring-2 focus:ring-[var(--purple)]">
      </div>
    </div>

    <!-- Add Item Button -->
    <button type="button" onclick="addRow()"
            class="px-5 py-2 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700 transition">
      + Add Item
    </button>

    <!-- Submit -->
    <button type="submit"
            class="w-full py-3 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700 transition text-lg font-semibold">
      Save Receipt (Draft)
    </button>

  </form>
  <!-- FORM END -->

</div>
</main>

<script>
function addRow() {
  let row = document.querySelector("#items div").cloneNode(true);
  document.getElementById("items").appendChild(row);
}
</script>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
