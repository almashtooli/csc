<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the subject ID and student IDs from the request
    $subjectId = $_POST['subject_id'];
    $studentIds = $_POST['student_ids'];

    // Check if subject ID and student IDs are provided
    if (empty($subjectId) || empty($studentIds)) {
        $response = array(
            'success' => false,
            'message' => 'Invalid request. Subject ID and student IDs are required.'
        );
    } else {
        // Assign students to the subject
        $success = true;
        foreach ($studentIds as $studentId) {
            $insertQuery = "INSERT INTO student_subjects (student_id, subject_id) VALUES (?, ?)";
            $statement = $connection->prepare($insertQuery);
            $statement->bind_param("ii", $studentId, $subjectId);
            if (!$statement->execute()) {
                $success = false;
                break;
            }
        }

        if ($success) {
            $response = array(
                'success' => true,
                'message' => 'Students successfully assigned to the subject.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to assign students to the subject.'
            );
        }
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
$connection->close();
?>
