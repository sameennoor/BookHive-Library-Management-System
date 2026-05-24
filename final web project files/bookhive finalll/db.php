<?php
$host = "localhost";      // Usually localhost
$user = "root";           // Your MySQL username
$pass = "";               // Your MySQL password
$db   = "bookhive_db";    // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
