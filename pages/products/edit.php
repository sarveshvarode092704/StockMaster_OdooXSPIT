<?php 
include "../../includes/header.php"; 
include "../../config/db.php"; 

// Validate ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list.php?error=missing_id");
    exit;
}

$id = intval($_GET['id']);

// Fetch product
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (!$product) {
    header("Location: list.php?error=not_found");
    exit;
}
?>

<h1 class="text-3xl font-bold mb-6">Edit Product</h1>

<form action="../../actions/edit_product_action.php" method="POST" class="space-y-6">

    <input type="hidden" name="id" value="<?= $product['id'] ?>">

    <!-- Product Name -->
    <div>
        <label class="block mb-2">Product Name</label>
        <input type="text" 
               name="name" 
               value="<?= htmlspecialchars($product['name']) ?>" 
               required
               class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <!-- SKU -->
    <div>
        <label class="block mb-2">SKU</label>
        <input type="text" 
               name="sku" 
               value="<?= htmlspecialchars($product['sku']) ?>" 
               required
               class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <!-- Category -->
    <div>
        <label class="block mb-2">Category</label>
        <input type="text" 
               name="category" 
               value="<?= htmlspecialchars($product['category']) ?>"
               class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <!-- UOM -->
    <div>
        <label class="block mb-2">Unit of Measure (UOM)</label>
        <input type="text" 
               name="uom" 
               value="<?= htmlspecialchars($product['uom']) ?>" 
               required
               class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <!-- Reorder Level -->
    <div>
        <label class="block mb-2">Reorder Level</label>
        <input type="number" 
               name="reorder_level" 
               value="<?= htmlspecialchars($product['reorder_level']) ?>"
               class="p-3 w-full rounded bg-[#31323e] text-[#bfc0d1]">
    </div>

    <button type="submit"
            class="px-6 py-3 bg-[#60519b] text-white rounded w-full">
        Update Product
    </button>
</form>

<?php include "../../includes/footer.php"; ?>
