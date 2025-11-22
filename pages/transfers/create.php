<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<h1 class="text-2xl mb-4">Create Internal Transfer</h1>

<form action="../../actions/add_transfer_action.php" method="POST" class="space-y-4">

    <select name="source_warehouse" class="p-2 w-full rounded bg-[#31323e]" required>
        <option>Source Warehouse</option>
        <?php
        $w = $conn->query("SELECT * FROM warehouses");
        while($row = $w->fetch_assoc()){
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    <select name="destination_warehouse" class="p-2 w-full rounded bg-[#31323e]" required>
        <option>Destination Warehouse</option>
        <?php
        $w = $conn->query("SELECT * FROM warehouses");
        while($row = $w->fetch_assoc()){
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    <div id="items">
        <div class="flex gap-4">
            <select name="product_id[]" class="p-2 rounded bg-[#31323e]">
                <?php
                $p = $conn->query("SELECT * FROM products");
                while($prod = $p->fetch_assoc()){
                    echo "<option value='{$prod['id']}'>{$prod['name']}</option>";
                }
                ?>
            </select>

            <input type="number" name="qty[]" class="p-2 rounded bg-[#31323e]" 
                   placeholder="Quantity" required>
        </div>
    </div>

    <button type="button" onclick="addRow()" class="px-3 py-1 bg-[#60519b] rounded">Add Item</button>

    <button type="submit" class="px-4 py-2 bg-[#60519b] rounded text-white">Save Draft</button>

</form>

<script>
function addRow() {
    let clone = document.querySelector("#items div").cloneNode(true);
    document.getElementById("items").appendChild(clone);
}
</script>

<?php include "../../includes/footer.php"; ?>
