<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<h1 class="text-2xl mb-4">Create Receipt</h1>

<form action="../../actions/add_receipt_action.php" method="POST" enctype="multipart/form-data" class="space-y-4">

    <input type="text" name="supplier" placeholder="Supplier Name" class="p-2 w-full rounded bg-[#31323e]" required>

    <select name="warehouse_id" class="p-2 w-full rounded bg-[#31323e]" required>
        <option>Select Warehouse</option>
        <?php
        $w = $conn->query("SELECT * FROM warehouses");
        while($row = $w->fetch_assoc()){
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    <label class="block">Upload Invoice (optional)</label>
    <input type="file" name="invoice" class="p-2 w-full rounded bg-[#31323e]">

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
            <input type="number" name="qty[]" class="p-2 rounded bg-[#31323e]" placeholder="Quantity" required>
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
