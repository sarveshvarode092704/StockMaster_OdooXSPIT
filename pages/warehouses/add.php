<?php
session_start();
include("../../config/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $location = $_POST["location"];

    $stmt = $conn->prepare("INSERT INTO warehouses (name, location) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $location);

    if ($stmt->execute()) {
        header("Location: warehouses_list.php");
        exit;
    } else {
        $message = "<p class='text-red-400'>Error adding warehouse</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Warehouse</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
:root{
  --dark1:#1e202c; --purple:#60519b; --dark2:#31323e; --light:#bfc0d1;
}
</style>
</head>

<body class="bg-[var(--dark1)] text-[var(--light)]">

<?php include '../../includes/header.php'; ?>

<main class="ml-64 p-8">
<h1 class="text-2xl font-bold text-white mb-6">Add Warehouse</h1>

<?= $message ?>

<form method="POST" 
      class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)] w-96">

    <label>Name</label>
    <input type="text" name="name" required
           class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white mb-4"/>

    <label>Location</label>
    <input type="text" name="location" required
           class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white mb-6"/>

    <button class="w-full py-3 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700">
        Add Warehouse
    </button>
</form>

</main>
</body>
</html>
