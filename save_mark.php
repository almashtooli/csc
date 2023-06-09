<?php
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['set_mark'])) {
    // Retrieve the submitted form data
    $studentId = $_POST['student_id'];
    $subjectId = $_POST['subject_id'];
    $mark = $_POST['mark'];

    // TODO: Perform validation and sanitization of the form data as needed

    // Insert the mark into the database
    $stmt = $connection->prepare("INSERT INTO marks (student_id, subject_id, mark) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $studentId, $subjectId, $mark);
    
    if ($stmt->execute()) {
        // The mark was successfully saved
       header('Location:admindash.php');
    } else {
        // An error occurred while saving the mark
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$connection->close();
?>
