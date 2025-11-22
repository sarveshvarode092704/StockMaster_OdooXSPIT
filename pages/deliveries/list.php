<?php include "../../includes/header.php"; ?>
<?php include "../../config/db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delivery Orders</title>
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

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-white font-bold">Delivery Orders</h1>
    </div>

    <div class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)]">
        <table class="w-full text-left">
            <thead class="bg-[#262836] text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Customer</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = $conn->query("SELECT * FROM deliveries ORDER BY id DESC");
                while ($d = $q->fetch_assoc()):
                ?>
                <tr class="border-b border-[#31323e]">
                    <td class="py-3 px-4"><?= $d['id'] ?></td>
                    <td class="py-3 px-4"><?= $d['customer'] ?></td>
                    <td class="py-3 px-4"><?= $d['status'] ?></td>

                    <td class="py-3 px-4">
                        <a href="view.php?id=<?= $d['id'] ?>"
                           class="text-[#bfc0d1] hover:underline">
                           Open
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>

</main>

</body>
</html>
