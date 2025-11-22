<?php
session_start();
include("../../config/db.php");

// FETCH ALL WAREHOUSES
$result = $conn->query("SELECT * FROM warehouses ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Warehouses</title>
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

<?php include '../../includes/header.php'; ?>

<main class="ml-64 p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-white font-bold">Warehouses</h1>
        <a href="add.php" 
            class="px-4 py-2 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700">
            + Add Warehouse
        </a>
    </div>

    <div class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)]">
        <table class="w-full text-left">
            <thead class="bg-[#262836] text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Location</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr class="border-b border-[#31323e]">
                    <td class="py-3 px-4"><?= $row['id'] ?></td>
                    <td class="py-3 px-4"><?= $row['name'] ?></td>
                    <td class="py-3 px-4"><?= $row['location'] ?></td>

                    <td class="py-3 px-4">
                        <a href="edit.php?id=<?= $row['id'] ?>" 
                           class="text-blue-400 hover:underline mr-4">Edit</a>

                        <a href="delete.php?id=<?= $row['id'] ?>"
                           class="text-red-400 hover:underline"
                           onclick="return confirm('Delete this warehouse?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</main>

</body>
</html>
