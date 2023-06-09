<?php
// Include the database connection file
require_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the subject data from the form
    $subjectName = $_POST["subject_name"];
    $minMark = $_POST["pass_mark"];

    // TODO: Validate and sanitize the input data as needed

    // Save the subject to the database
    $stmt = $connection->prepare("INSERT INTO subjects (name, pass_mark) VALUES (?, ?)");
    $stmt->bind_param("si", $subjectName, $minMark);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Optionally, you can redirect the user to another page after saving the subject
    header("Location: admindash.php"); // Replace "success.php" with your desired page
    exit();
}
?>
