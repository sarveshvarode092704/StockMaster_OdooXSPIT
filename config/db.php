<?php

// UNIVERSAL DATABASE CONNECTOR
// Works in all pages, controllers, models, actions

function db_connect() {

    // Database config
    $host = "srv595.hstgr.io";      // XAMPP/WAMP default
    $user = "u307056987_smsa";           // MySQL default user
    $pass = "Smsa@2027";               // MySQL default password (empty in XAMPP)
    $dbname = "u307056987_d2";

    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Connection error handling
    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // UTF-8 encoding support
    $conn->set_charset("utf8");

    return $conn;
}

// Auto connection available globally
$conn = db_connect();

?>
