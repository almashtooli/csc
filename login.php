<?php
include "connection.php";

// Check if the user is already logged in
session_start();
if (isset($_SESSION['user_id'])) {
    // Determine the user role
    $userId = $_SESSION['user_id'];
    $query = "SELECT role FROM users WHERE id = '$userId' LIMIT 1";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $role = $user["role"];

        // Redirect the user based on their role
        if ($role === "Admin") {
            header("Location: admindash.php");
        } else {
            header("Location: userdash.php");
        }
        exit();
    }
}

// Handle the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate the form data (you can add additional validation as per your requirements)

    // Query to check if the user exists in the database
    $query = "SELECT id, username, password, active, role FROM users WHERE email = '$email' LIMIT 1";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user["password"])) {
            // Check if the user account is active
            if ($user["active"]) {
                // Set the user's login status in session
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                // Redirect the user based on their role
                if ($user["role"] === "Admin") {
                    header("Location: admindash.php");
                } else {
                    header("Location: userdash.php");
                }
                exit();
            } else {
                // Account is inactive
                $error_message = "This account is inactive.";
            }
        } else {
            // Invalid password
            $error_message = "Invalid email or password.";
        }
    } else {
        // User does not exist
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <div style="max-width: 400px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 5px; text-align: center;">
        <h1 style="font-size: 24px; margin-bottom: 20px;">Login</h1>
        <?php
        if (isset($error_message)) {
            echo '<p style="color: red; margin-bottom: 10px;">' . $error_message . '</p>';
        }
        ?>
        <form method="POST" action="">
            <label for="email" style="display: block; font-weight: bold;">Email:</label>
            <input type="email" name="email" id="email" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" required><br><br>
            <label for="password" style="display: block; font-weight: bold;">Password:</label>
            <input type="password" name="password" id="password" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" required><br><br>
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Login</button>
        </form>
        <div id="formFooter">
      <p>Don't Have Account? <a class="underlineHover" href="register.php">SIGN UP</a></p>
    </div>
    </div>

</body>
</html>
