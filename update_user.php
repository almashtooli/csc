<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $userId = $_POST['edit_user_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $active = isset($_POST['edit_activity']) ? 1 : 0;

    // Update the user data in the database
    $query = "UPDATE users SET username = '$username', email = '$email', active = $active WHERE id = $userId";
    $result = $connection->query($query);

    if ($result) {
       header('Location:admindash.php');
    } else {
        echo "Error updating user: " . $connection->error;
    }
}

// Close the database connection
$connection->close();

?>
