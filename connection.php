<?php
$servername = "localhost";
$username = "root";
$password = ""; // If you set a password for your MySQL server, enter it here
$dbname = "schools";

// Create a new MySQLi object
$connection = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Connection successful!
?>
