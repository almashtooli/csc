<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Retrieve the user data from the database
    $query = "SELECT id, username, email, active FROM users WHERE id = $userId";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo "User not found";
    }
}

// Close the database connection
$connection->close();

?>
