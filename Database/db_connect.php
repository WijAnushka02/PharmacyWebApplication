<?php
// Database configuration
$servername = "localhost"; // The server name. 'localhost' is common for local development.
$username = "your_username"; // Your database username.
$password = "your_password"; // Your database password.
$dbname = "Pharmacy_db"; // The name of your database.

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If the connection fails, terminate the script and display an error
    die("Connection failed: " . $conn->connect_error);
}
?>
