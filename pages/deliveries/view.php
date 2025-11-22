<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<?php
$id = $_GET['id'];
$delivery = $conn->query("SELECT * FROM deliveries WHERE id=$id")->fetch_assoc();
$items = $conn->query("SELECT * FROM delivery_items WHERE delivery_id=$id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delivery View</title>
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

    <!-- Title -->
    <h1 class="text-3xl text-white font-bold mb-6">
        Delivery #<?= $id ?>
    </h1>

    <!-- Delivery Information Card -->
    <div class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)] mb-6">
        <p class="text-lg mb-2"><strong>Customer:</strong> <?= $delivery['customer'] ?></p>
        <p class="text-lg"><strong>Status:</strong> <?= $delivery['status'] ?></p>
    </div>

    <!-- Items Table -->
    <div class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)]">
        <table class="w-full text-left">
            <thead class="bg-[#262836] text-white">
                <tr>
                    <th class="py-3 px-4">Product</th>
                    <th class="py-3 px-4">Quantity</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($i = $items->fetch_assoc()): ?>
                <tr class="border-b border-[#31323e]">
                    <td class="py-3 px-4"><?= $i['product_id'] ?></td>
                    <td class="py-3 px-4"><?= $i['quantity'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Validate Button -->
    <?php if ($delivery['status'] == "Draft"): ?>
    <form action="../../actions/validate_delivery_action.php" method="POST" class="mt-6">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button 
            class="px-6 py-3 bg-[var(--purple)] text-white text-lg rounded-lg hover:bg-purple-700">
            Validate Delivery
        </button>
    </form>
    <?php endif; ?>

</main>

</body>
</html>
