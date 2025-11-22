<?php
include "../../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Internal Transfers</title>
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

<?php include "../../includes/header.php"; ?>

<main class="ml-64 p-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-white font-bold">Internal Transfers</h1>
    </div>

    <div class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)]">
        <table class="w-full text-left">
            <thead class="bg-[#262836] text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">From</th>
                    <th class="py-3 px-4">To</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = $conn->query("
                    SELECT t.*, 
                        ws.name AS source_name,
                        wd.name AS dest_name
                    FROM transfers t
                    JOIN warehouses ws ON t.from_warehouse = ws.id
                    JOIN warehouses wd ON t.to_warehouse = wd.id
                    ORDER BY t.id DESC
                ");

                while($t = $q->fetch_assoc()):
                ?>
                <tr class="border-b border-[#31323e]">
                    <td class="py-3 px-4"><?= $t['id'] ?></td>
                    <td class="py-3 px-4"><?= $t['source_name'] ?></td>
                    <td class="py-3 px-4"><?= $t['dest_name'] ?></td>
                    <td class="py-3 px-4"><?= $t['status'] ?></td>

                    <td class="py-3 px-4">
                        <a href="view.php?id=<?= $t['id'] ?>" 
                           class="text-blue-400 hover:underline">Open</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>

</main>

</body>
</html>
