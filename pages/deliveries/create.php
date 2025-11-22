<<<<<<< Updated upstream


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Delivery</title>

<!-- TAILWIND + YOUR COLORS -->
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
<div class="ml-64 p-8">

    <h1 class="text-3xl font-bold mb-6 text-light">Create Delivery Order</h1>

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
                    class="p-3 w-full rounded-xl bg-dark2 border border-dark2 focus:outline-none focus:ring focus:ring-purple" required>
                <option value="">Choose Warehouse</option>

                <?php
                $w = $conn->query("SELECT * FROM warehouses");
                while($row = $w->fetch_assoc()){
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
=======
<?php
include "../../includes/header.php";
include "../../config/db.php";

// Auto-generate delivery number
$last = $conn->query("SELECT id FROM deliveries ORDER BY id DESC LIMIT 1")->fetch_assoc();
$next = $last ? $last['id'] + 1 : 1;
$delivery_no = "DEL-" . str_pad($next, 4, "0", STR_PAD_LEFT);
?>
<h1 class="text-3xl font-bold text-white mb-6">Create Delivery Order</h1>

<form action="/StockMaster_OdooXSPIT/actions/add_delivery_action.php" method="POST" class="space-y-6">
    <input type="hidden" name="delivery_no" value="<?php echo htmlspecialchars($delivery_no); ?>">

    <div>
        <label class="block text-[#bfc0d1] mb-1">Delivery No</label>
        <input type="text" value="<?php echo htmlspecialchars($delivery_no); ?>" disabled class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <div>
        <label class="block text-[#bfc0d1] mb-1">Customer Name</label>
        <input type="text" name="customer" required class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <div>
        <label class="block text-[#bfc0d1] mb-1">Select Warehouse</label>
        <select name="warehouse_id" required class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
            <option value="">Select Warehouse</option>
            <?php
            $wh = $conn->query("SELECT * FROM warehouses");
            while ($w = $wh->fetch_assoc()) {
                echo "<option value='{$w['id']}'>" . htmlspecialchars($w['name']) . "</option>";
            }
            ?>
        </select>
    </div>

    <h2 class="text-xl font-semibold text-white">Items</h2>

    <div id="items" class="space-y-3">
        <div class="flex gap-3 items-center">
            <select name="product_id[]" class="p-3 rounded bg-[#31323e] text-[#bfc0d1] w-1/2">
                <?php
                $p = $conn->query("SELECT * FROM products");
                while ($prod = $p->fetch_assoc()) {
                    echo "<option value='{$prod['id']}'>" . htmlspecialchars($prod['name']) . "</option>";
                }
                ?>
            </select>
            <input type="number" step="0.01" name="qty[]" placeholder="Qty" class="p-3 rounded bg-[#31323e] text-[#bfc0d1] w-1/2" required>
>>>>>>> Stashed changes
        </div>

<<<<<<< Updated upstream
        <!-- Items -->
        <div id="items" class="space-y-3">

            <div class="flex gap-4">
                <!-- Product Dropdown -->
                <select name="product_id[]"
                        class="p-3 w-1/2 rounded-xl bg-dark2 border border-dark2 focus:outline-none focus:ring focus:ring-purple">
                    <?php
                    $p = $conn->query("SELECT * FROM products");
                    while($prod = $p->fetch_assoc()){
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

        <!-- Add More Items -->
        <button type="button" onclick="addRow()"
                class="px-4 py-2 bg-purple text-white rounded-xl hover:bg-purple/80 transition">
            + Add Item
        </button>

        <!-- Submit -->
        <button type="submit"
                class="px-6 py-3 bg-purple text-white rounded-xl font-semibold hover:bg-purple/80 transition">
            Save Draft
        </button>

    </form>

</div>

<!-- JS -->
<script>
function addRow() {
    let clone = document.querySelector("#items div").cloneNode(true);
    document.getElementById("items").appendChild(clone);
}
</script>

<?php include "../../includes/footer.php"; ?>

</body>
</html>

          light: "#bfc0d1",
        }
      }
    }
  }
</script>


<div class="ml-64 p-8 text-[#bfc0d1]"> <!-- Main Content with Sidebar Offset -->

    <h1 class="text-3xl font-bold mb-6">Create Delivery Order</h1>

    <form action="../../actions/add_delivery_action.php" method="POST" class="space-y-6">

        <!-- Customer Name -->
        <div>
            <label class="block mb-1 font-semibold">Customer Name</label>
            <input type="text" name="customer" 
                   class="p-3 w-full rounded-xl bg-[#262836] border border-[#31323e] focus:outline-none focus:ring focus:ring-[#60519b]" 
                   placeholder="Enter customer name" required>
        </div>

        <!-- Warehouse Select -->
        <div>
            <label class="block mb-1 font-semibold">Select Warehouse</label>
            <select name="warehouse_id" 
                    class="p-3 w-full rounded-xl bg-[#262836] border border-[#31323e] focus:outline-none focus:ring focus:ring-[#60519b]" required>
                <option value="">Choose Warehouse</option>

                <?php
                $w = $conn->query("SELECT * FROM warehouses");
                while($row = $w->fetch_assoc()){
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
                        class="p-3 w-1/2 rounded-xl bg-[#262836] border border-[#31323e] focus:outline-none focus:ring focus:ring-[#60519b]">
                    <?php
                    $p = $conn->query("SELECT * FROM products");
                    while($prod = $p->fetch_assoc()){
                        echo "<option value='{$prod['id']}'>{$prod['name']}</option>";
                    }
                    ?>
                </select>

                <!-- Quantity -->
                <input type="number" name="qty[]" 
                       class="p-3 w-1/2 rounded-xl bg-[#262836] border border-[#31323e] focus:outline-none focus:ring focus:ring-[#60519b]" 
                       placeholder="Quantity" required>
            </div>

        </div>

        <!-- Add Item Button -->
        <button type="button" onclick="addRow()" 
                class="px-4 py-2 bg-[#60519b] rounded-xl text-white hover:bg-[#6b5ac4] transition">
            + Add Item
        </button>

        <!-- Submit -->
        <button type="submit" 
                class="px-6 py-3 bg-[#60519b] rounded-xl text-white font-semibold hover:bg-[#6b5ac4] transition">
            Save Draft
        </button>

    </form>

</div>
=======
    <button type="button" onclick="addRow()" class="px-4 py-2 bg-[#60519b] text-white rounded hover:bg-[#4f4181]">+ Add Item</button>

    <button type="submit" class="px-6 py-3 bg-[#60519b] text-white rounded w-full">Save Delivery (Draft)</button>
</form>
>>>>>>> Stashed changes

<script>
function addRow() {
    let clone = document.querySelector("#items div").cloneNode(true);
    document.getElementById("items").appendChild(clone);
}
</script>

<?php include "../../includes/footer.php"; ?>
