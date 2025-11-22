<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Internal Transfer</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
:root {
  --dark1: #1e202c;
  --purple: #60519b;
  --dark2: #31323e;
  --light: #bfc0d1;
}
</style>
</head>

<body class="bg-[var(--dark1)] text-[var(--light)]">

<main class="ml-64 p-8">

    <h1 class="text-3xl text-white font-bold mb-6">Create Internal Transfer</h1>

    <div class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)]">

        <form action="../../actions/add_transfer_action.php" method="POST" class="space-y-6">

            <!-- Source Warehouse -->
            <div>
                <label class="block mb-1 font-semibold">Source Warehouse</label>
                <select name="source_warehouse"
                    class="p-3 w-full rounded-xl bg-[#262836] border border-[var(--dark2)] focus:outline-none focus:ring focus:ring-[var(--purple)]"
                    required>
                    <option value="">Choose Source</option>

                    <?php
                    $w = $conn->query("SELECT * FROM warehouses");
                    while($row = $w->fetch_assoc()){
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Destination Warehouse -->
            <div>
                <label class="block mb-1 font-semibold">Destination Warehouse</label>
                <select name="destination_warehouse"
                    class="p-3 w-full rounded-xl bg-[#262836] border border-[var(--dark2)] focus:outline-none focus:ring focus:ring-[var(--purple)]"
                    required>
                    <option value="">Choose Destination</option>

                    <?php
                    $w = $conn->query("SELECT * FROM warehouses");
                    while($row = $w->fetch_assoc()){
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Item Rows -->
            <div id="items" class="space-y-3">

                <div class="flex gap-4">

                    <!-- Product Select -->
                    <select name="product_id[]"
                        class="p-3 w-1/2 rounded-xl bg-[#262836] border border-[var(--dark2)] focus:ring focus:ring-[var(--purple)]">
                        <?php
                        $p = $conn->query("SELECT * FROM products");
                        while($prod = $p->fetch_assoc()){
                            echo "<option value='{$prod['id']}'>{$prod['name']}</option>";
                        }
                        ?>
                    </select>

                    <!-- Quantity -->
                    <input type="number" name="qty[]"
                        class="p-3 w-1/2 rounded-xl bg-[#262836] border border-[var(--dark2)] focus:ring focus:ring-[var(--purple)]"
                        placeholder="Quantity" required>
                </div>

            </div>

            <!-- Add Item Button -->
            <button type="button" onclick="addRow()"
                class="px-4 py-2 bg-[var(--purple)] text-white rounded-xl hover:bg-purple-700">
                + Add Item
            </button>

            <!-- Save Draft -->
            <button type="submit"
                class="px-6 py-3 bg-[var(--purple)] text-white font-semibold rounded-xl hover:bg-purple-700">
                Save Draft
            </button>

        </form>

    </div>

</main>

<script>
function addRow() {
    let clone = document.querySelector("#items div").cloneNode(true);
    document.getElementById("items").appendChild(clone);
}
</script>

</body>
</html>
