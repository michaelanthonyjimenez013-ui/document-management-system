<?php
// Database Connection Configuration
// Malasakit Program Document Management System

$host = 'sql211.infinityfree.com';
$port = 3306;
$username = 'if0_42550505';
$password = 'Michaelant26';
$database = 'if0_42550505_XXX'; // Replace XXX with your actual database name

// Create connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

echo "Connected successfully to database: " . $database;

// Close connection when done (uncomment when using)
// $conn->close();
?>
