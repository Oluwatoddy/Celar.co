<?php
$servername = "localhost";
$username = "root";       // XAMPP's default MySQL username
$password = "";           // XAMPP's default MySQL password is usually empty
$database = "chopnow_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>