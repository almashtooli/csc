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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        p {
            color: #777;
            margin-bottom: 5px;
        }

        .logout-button {
            display: inline-block;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <h2>User Details:</h2>
        <table>
            <tr>
                <th>Username</th>
                <td><?php echo $username; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $email; ?></td>
            </tr>
        </table>

        <h2>Subject Marks:</h2>
<table class="subject-marks">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Mark</th>
            <th>Pass Mark</th> <!-- New column for pass mark -->
        </tr>
    </thead>
    <tbody>
        <?php
        // Retrieve the subject marks and pass marks for the user from the database
        $query = "SELECT subjects.name, marks.mark, subjects.pass_mark FROM marks
                  INNER JOIN subjects ON marks.subject_id = subjects.id
                  WHERE marks.student_id = '$userID'";
        $result = $connection->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subjectName = $row['name'];
                $mark = $row['mark'];
                $passMark = $row['pass_mark']; // Retrieve the pass mark from the database
                $status = ($mark >= $passMark) ? 'Passed' : 'Failed'; // Determine pass/fail status based on mark and pass mark

                echo "<tr><td>$subjectName</td><td>$mark</td><td>$passMark</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No subject marks found.</td></tr>";
        }
        ?>
    </tbody>
</table>





        <button class="button" onclick="openModal('changePasswordModal')">Change Password</button>

        <button class="logout-button" onclick="location.href='logout.php'">Logout</button>
    </div>

    <!-- Change password modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('changePasswordModal')">&times;</span>
            <h2>Change Password</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="current_password" required><br><br>
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="new_password" required><br><br>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirm_password" required><br><br>
                <button class="button" type="submit" name="change_password">Change Password</button>
            </form>
        </div>
    </div>

    <?php
    // Check if the password change form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
        // Retrieve the form data
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the current password is correct
        $query = "SELECT password FROM users WHERE id = '$userID' LIMIT 1";
        $result = $connection->query($query);

        if ($result && $result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            $hashedPassword = $userData['password'];

            if (password_verify($currentPassword, $hashedPassword)) {
                // Check if the new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    // Check password strength criteria
                    $hasUppercase = preg_match('/[A-Z]/', $newPassword);
                    $hasLowercase = preg_match('/[a-z]/', $newPassword);
                    $hasNumber = preg_match('/\d/', $newPassword);
                    $hasSpecialChar = preg_match('/[!@#$%^&*()\-_=+{}[\]|;:\'",.<>\/?\\~]/', $newPassword);

                    if ($hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar) {
                        // Hash the new password
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        // Update the user's password in the database
                        $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE id = '$userID'";
                        $updateResult = $connection->query($updateQuery);

                        if ($updateResult) {
                            echo "Password changed successfully.";
                            // You can redirect the user to a success page using the header() function
                            // For example: header("Location: password_changed.php");
                            exit;
                        } else {
                            echo "Error: Failed to update password.";
                        }
                    } else {
                        echo "Error: New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                    }
                } else {
                    echo "Error: New password and confirm password do not match.";
                }
            } else {
                echo "Error: Incorrect current password.";
            }
        } else {
            echo "Error: User data not found.";
        }
    }
    ?>


    <script>
        // Open the modal
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'block';
        }

        // Close the modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'none';
        }

        // Use AJAX to fetch subject marks and display them dynamically
        window.addEventListener('DOMContentLoaded', function() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('subjectMarks').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'get_subject_marks.php', true);
            xhr.send();
        });
    </script>
</body>

</html>