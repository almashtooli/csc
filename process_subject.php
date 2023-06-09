<?php
// Include the database connection file
require_once 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $subjectName = $_POST["subject_name"];
  $subjectCode = $_POST["subject_code"];
  $subjectDescription = $_POST["subject_description"];

  // Perform basic validation
  if (empty($subjectName) || empty($subjectCode) || empty($subjectDescription)) {
    // Display an error message if any field is empty
    echo "Please fill in all the fields.";
  } else {
    // Form data is valid, proceed with further processing

    // Prepare and execute an SQL statement to insert the data into a table
    $sql = "INSERT INTO subjects (name, code, description) VALUES ('$subjectName', '$subjectCode', '$subjectDescription')";

    if ($connection->query($sql) === TRUE) {
      // Data is successfully inserted
      echo "Subject created successfully!";
    } else {
      // Error inserting data
      echo "Error: " . $sql . "<br>" . $connection->error;
    }
  }
}
?>
