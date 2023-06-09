<?php
include "connection.php";

// Check if the user is logged in, redirect to login page if not
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the user's data from the database
$userID = $_SESSION['user_id'];
$query = "SELECT username, email FROM users WHERE id = '$userID' LIMIT 1";
$result = $connection->query($query);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $email = $user['email'];
} else {
    // Handle the case when the user data is not found
    // You can redirect to an error page or display an appropriate message
    echo "User data not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS styles for the admin dashboard */
        /* ... */
    </style>
</head>

<body>
<?php include "header.php"; ?>



<?php include "connection.php"; ?>


<!-- Create user form -->
<?php include "create_user_form.php"; ?>

<!-- Create subject form -->
<?php include "create_subject_form.php"; ?>

<?php include "set_mark_modal.php"; ?>

<!-- Edit user modal -->
<?php include "edit_user_modal.php"; ?>

<!-- Delete user modal -->
<?php include "delete_user_modal.php"; ?>


<!-- Logout form -->

<?php include "logout_form.php"; ?>

     <!-- Include jQuery library -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript functions -->
<script>
    // Open the create user modal
    function openCreateUserModal() {
        $('#createUserModal').css('display', 'block');
    }

    // Open the create subject modal
    function openCreateSubjectModal() {
        $('#createSubjectModal').css('display', 'block');
    }

    // Open the set mark modal
    function openSetMarkModal() {
        $('#setMarkModal').css('display', 'block');
    }

    // Close the modal
    function closeModal(modalId) {
        $('#' + modalId).css('display', 'none');
    }
</script>

<script src="script.js"></script>
</body>

</html>
