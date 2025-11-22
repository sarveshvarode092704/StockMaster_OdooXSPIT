<?php
session_start();
include("../../config/db.php");

$id = $_GET["id"];
$message = "";

// Fetch record
$stmt = $conn->prepare("SELECT * FROM warehouses WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Update record
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $location = $_POST["location"];

    $stmt = $conn->prepare("UPDATE warehouses SET name=?, location=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $location, $id);

    if ($stmt->execute()) {
        header("Location: warehouses_list.php");
        exit;
    } else {
        $message = "<p class='text-red-400'>Update failed!</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Warehouse</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
:root{ --dark1:#1e202c; --purple:#60519b; --dark2:#31323e; --light:#bfc0d1; }
</style>
</head>

<body class="bg-[var(--dark1)] text-[var(--light)]">

<?php include '../includes/header.php'; ?>

<main class="ml-64 p-8">

<h1 class="text-2xl text-white font-bold mb-6">Edit Warehouse</h1>

<?= $message ?>

<form method="POST" 
      class="bg-[var(--dark2)] p-6 rounded-xl border border-[var(--purple)] w-96">

    <label>Name</label>
    <input type="text" name="name" value="<?= $data['name'] ?>" required
           class="w-full p-3 bg-[var(--dark1)] text-white rounded-lg mb-4"/>

    <label>Location</label>
    <input type="text" name="location" value="<?= $data['location'] ?>" required
           class="w-full p-3 bg-[var(--dark1)] text-white rounded-lg mb-6"/>

    <button class="w-full py-3 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700">
        Update
    </button>
</form>

</main>
</body>
</html>
