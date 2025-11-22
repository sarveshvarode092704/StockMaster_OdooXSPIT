<?php
include "../../config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Delivery</title>

<!-- TAILWIND + THEME COLORS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        dark1: "#1e202c",
        purple: "#60519b",
        dark2: "#31323e",
        light: "#bfc0d1",
      }
    }
  }
}
</script>

</head>

<body class="bg-dark1 text-light">

<?php include "../../includes/header.php"; ?>

<!-- MAIN CONTENT -->
<div class="ml-64 p-8 text-light">

    <h1 class="text-3xl font-bold mb-6">Create Delivery Order</h1>

    <form action="../../actions/add_delivery_action.php" method="POST" class="space-y-6">

        <!-- Customer Name -->
        <div>
            <label class="block mb-1 font-semibold">Customer Name</label>
            <input type="text" name="customer"
                   class="p-3 w-full rounded-xl bg-dark2 border border-dark2 focus:outline-none focus:ring focus:ring-purple"
                   placeholder="Enter customer name" required>
        </div>

        <!-- Warehouse Select -->
        <div>
            <label class="block mb-1 font-semibold">Select Warehouse</label>
            <select name="warehouse_id"
                    class="p-3 w-full rounded-xl bg-dark2 border border-dark2 focus:outline-none focus:ring focus:ring-purple"
                    required>
                <option value="">Choose Warehouse</option>

                <?php
                $w = $conn->query("SELECT * FROM warehouses");
                while ($row = $w->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Item List -->
        <div id="items" class="space-y-3">

            <div class="flex gap-4">
                <!-- Product Dropdown -->
                <select name="product_id[]"
                        class="p-3 w-1/2 rounded-xl bg-dark2 border border-dark2 focus:outline-none focus:ring focus:ring-purple">
                    <?php
                    $p = $conn->query("SELECT * FROM products");
                    while ($prod = $p->fetch_assoc()) {
                        echo "<option value='{$prod['id']}'>{$prod['name']}</option>";
                    }
                    ?>
                </select>

                <!-- Quantity -->
                <input type="number" name="qty[]"
                       class="p-3 w-1/2 rounded-xl bg-dark2 border border-dark2 focus:outline-none focus:ring focus:ring-purple"
                       placeholder="Quantity" required>
            </div>

        </div>

        <!-- Add Item Button -->
        <button type="button"
                onclick="addRow()"
                class="px-4 py-2 bg-purple rounded-xl text-white hover:bg-purple/80 transition">
            + Add Item
        </button>

        <!-- Submit -->
        <button type="submit"
                class="px-6 py-3 bg-purple rounded-xl text-white font-semibold hover:bg-purple/80 transition">
            Save Draft
        </button>

    </form>

</div>

<!-- JS -->
<script>
function addRow() {
    let clone = document.querySelector("#items div").cloneNode(true);
    document.querySelector("#items").appendChild(clone);
}
</script>

<?php include "../../includes/footer.php"; ?>

</body>
</html>
