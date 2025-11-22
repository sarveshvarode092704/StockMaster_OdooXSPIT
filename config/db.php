<?php
// Database configuration
$host = "srv595.hstgr.io";      // XAMPP/WAMP default
$user = "u307056987_smsa";           // MySQL default user
$pass = "Smsa@2027";               // MySQL default password (empty in XAMPP)
$dbname = "u307056987_d2";           // MySQL default user

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set UTF-8 support
$conn->set_charset("utf8");

?>
