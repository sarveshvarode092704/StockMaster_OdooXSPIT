<?php
session_start();
include("../../config/db.php");

$id = $_GET["id"];

$stmt = $conn->prepare("DELETE FROM warehouses WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location:list.php");
exit;
?>
