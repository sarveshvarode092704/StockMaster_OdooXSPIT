<?php
// ensure Tailwind CDN is available (safe even if header.php already loads it)
echo '<script src="https://cdn.tailwindcss.com"></script>';
?>
<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<main class="min-h-screen p-8 bg-[#1e202c] text-[#bfc0d1]">
  <div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-white">Add Product</h1>

    <div class="bg-[#161722] border border-[#31323e] rounded-lg p-8 shadow-md">
      <form action="../../actions/add_product_action.php" method="POST" class="space-y-6">

        <!-- Product Name -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-[#c7c8d9]">Product Name</label>
          <input type="text" name="name" required
                 class="w-full p-3 rounded-md bg-[#232530] text-[#eef0f6] placeholder:text-[#9aa0bf] focus:outline-none focus:ring-2 focus:ring-[#60519b]">
        </div>

        <!-- SKU -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-[#c7c8d9]">SKU</label>
          <input type="text" name="sku" required
                 class="w-full p-3 rounded-md bg-[#232530] text-[#eef0f6] placeholder:text-[#9aa0bf] focus:outline-none focus:ring-2 focus:ring-[#60519b]">
        </div>

        <!-- Category -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-[#c7c8d9]">Category</label>
          <input type="text" name="category"
                 class="w-full p-3 rounded-md bg-[#232530] text-[#eef0f6] placeholder:text-[#9aa0bf] focus:outline-none focus:ring-2 focus:ring-[#60519b]">
        </div>

        <!-- UOM -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-[#c7c8d9]">Unit of Measure (UOM)</label>
          <input type="text" name="uom" required
                 class="w-full p-3 rounded-md bg-[#232530] text-[#eef0f6] placeholder:text-[#9aa0bf] focus:outline-none focus:ring-2 focus:ring-[#60519b]">
        </div>

        <!-- Reorder Level -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-[#c7c8d9]">Reorder Level</label>
          <input type="number" name="reorder_level" value="0"
                 class="w-full p-3 rounded-md bg-[#232530] text-[#eef0f6] placeholder:text-[#9aa0bf] focus:outline-none focus:ring-2 focus:ring-[#60519b]">
        </div>

        <!-- Actions -->
        <div class="flex gap-3 items-center">
          <button type="submit"
                  class="flex-1 py-3 rounded-md bg-[#60519b] text-white font-semibold hover:bg-[#4e3d86] transition">
            Add Product
          </button>

          <a href="list.php"
             class="px-4 py-3 rounded-md border border-[#31323e] text-[#bfc0d1] hover:bg-[#242533]">
            Cancel
          </a>
        </div>

      </form>
    </div>
  </div>
</main>

<?php include "../../includes/footer.php"; ?>
