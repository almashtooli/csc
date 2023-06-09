<?php
include 'connection.php';

if (isset($_POST['delete_user_id'])) {
    $userId = $_POST['delete_user_id'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $statement = $connection->prepare($deleteQuery);
    $statement->bind_param("i", $userId);
    $statement->execute();

    if ($statement->affected_rows > 0) {
        // Deletion successful
        header('Location:admindash.php');
    } else {
        // Failed to delete user
        echo "Failed to delete user.";
    }

    // Close the statement and database connection
    $statement->close();
    $connection->close();
} else {
    // Invalid request
    echo "Invalid request.";
}
?>
