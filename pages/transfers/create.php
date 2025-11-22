<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!-- TailwindCDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- MAIN CONTENT -->
<div class="ml-64 p-10 text-[#bfc0d1]">

  <!-- PAGE HEADER -->
  <div class="mb-8">
      <h1 class="text-4xl font-bold text-white mb-2">Create Internal Transfer</h1>

      <div class="h-1 w-20 bg-[#60519b] rounded"></div> <!-- Purple underline -->

      <!-- Breadcrumb (optional) -->
      <p class="mt-2 text-[#bfc0d1]/70 text-sm">
          Inventory / Transfers / <span class="text-[#60519b]">Create</span>
      </p>
  </div>

  <!-- CARD -->
  <div class="bg-[#31323e] p-8 rounded-2xl border border-[#60519b] shadow-xl w-full max-w-3xl">

    <form action="../../actions/add_transfer_action.php" method="POST" class="space-y-6">

      <!-- Source Warehouse -->
      <div>
        <label class="block mb-1">Source Warehouse</label>
        <select name="source_warehouse"
                class="w-full p-3 rounded-lg bg-[#1e202c] border border-[#bfc0d1]
                focus:ring-2 focus:ring-[#60519b] text-white" required>
          <option value="">Select Source</option>
          <?php
            $w = $conn->query("SELECT * FROM warehouses");
            while($row = $w->fetch_assoc()){
                echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>";
            }
          ?>
        </select>
      </div>

      <!-- Destination Warehouse -->
      <div>
        <label class="block mb-1">Destination Warehouse</label>
        <select name="destination_warehouse"
                class="w-full p-3 rounded-lg bg-[#1e202c] border border-[#bfc0d1]
                focus:ring-2 focus:ring-[#60519b] text-white" required>
          <option value="">Select Destination</option>
          <?php
            $w2 = $conn->query("SELECT * FROM warehouses");
            while($row2 = $w2->fetch_assoc()){
                echo "<option value='{$row2['id']}'>".htmlspecialchars($row2['name'])."</option>";
            }
          ?>
        </select>
      </div>

      <!-- Products Section -->
      <h2 class="text-xl font-semibold text-white">Products</h2>

      <div id="items" class="space-y-4">
        <div class="flex gap-4">

          <!-- Product -->
          <select name="product_id[]"
                  class="p-3 rounded-lg bg-[#1e202c] border border-[#bfc0d1]
                  focus:ring-2 focus:ring-[#60519b] text-white w-1/2">
            <?php
              $p = $conn->query("SELECT * FROM products");
              while($prod = $p->fetch_assoc()){
                  echo "<option value='{$prod['id']}'>".htmlspecialchars($prod['name'])."</option>";
              }
            ?>
          </select>

          <!-- Quantity -->
          <input type="number" name="qty[]"
                 class="p-3 rounded-lg bg-[#1e202c] border border-[#bfc0d1]
                 focus:ring-2 focus:ring-[#60519b] text-white w-1/2"
                 placeholder="Quantity" required>

        </div>
      </div>

      <!-- Add Item -->
      <button type="button" onclick="addRow()"
              class="px-4 py-2 bg-[#60519b] rounded-lg text-white hover:bg-purple-700 transition">
        + Add Item
      </button>

      <!-- Submit -->
      <button type="submit"
              class="w-full py-3 bg-[#60519b] rounded-lg text-white font-semibold
              hover:bg-purple-700 transition">
        Save Draft
      </button>

    </form>

  </div>
</div>

<script>
function addRow() {
    let clone = document.querySelector("#items .flex").cloneNode(true);
    document.getElementById("items").appendChild(clone);
}
</script>

<?php include "../../includes/footer.php"; ?>
