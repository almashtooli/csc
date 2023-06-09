<?php
// Include the database connection file
require_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the user data from the form
    $username = $_POST["create_username"];
    $email = $_POST["create_email"];
    $password = $_POST["create_password"];
    $repeatPassword = $_POST["create_repeat_password"];
    $activity = isset($_POST["create_activity"]) ? 1 : 0;
    $role = $_POST["role"];

    // TODO: Validate and sanitize the input data as needed

    // Check if the password and repeat password match
    if ($password !== $repeatPassword) {
        // Handle password mismatch error, redirect or show an error message
        exit("Password mismatch");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Save the user to the database
    $stmt = $connection->prepare("INSERT INTO users (username, email, password, active, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $username, $email, $hashedPassword, $activity, $role);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Optionally, you can redirect the user to another page after saving the user
    header("Location: admindash.php"); // Replace "success.php" with your desired page
    exit();
}
?>
