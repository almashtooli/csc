<?php

 // Include the database connection file
 include 'connection.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat_password'];

    // Perform validation checks
    if ($password !== $repeatPassword) {
        $response = array(
            'status' => 'error',
            'message' => 'Passwords do not match'
        );
        echo json_encode($response);
        exit;
    }

    if (!isStrongPassword($password)) {
        $response = array(
            'status' => 'error',
            'message' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and be at least 8 characters long'
        );
        echo json_encode($response);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   

    // Check the connection object
    if ($connection->connect_error) {
        $response = array(
            'status' => 'error',
            'message' => 'Database connection failed'
        );
        echo json_encode($response);
        exit;
    }

    // Prepare and execute the SQL statement to insert the user data into the database
    $stmt = $connection->prepare("INSERT INTO users (username, email, password, role ) VALUES (?, ?, ?,'user')");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        $response = array(
            'status' => 'success',
            'message' => 'Registration successful!'
        );
        echo json_encode($response);
        exit;
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'An error occurred while registering the user'
        );
        echo json_encode($response);
        exit;
    }

    $stmt->close();
    $connection->close();
}

// Function to check if the password is strong
function isStrongPassword($password)
{
    // Check for at least one uppercase letter, one lowercase letter, one digit, and minimum length of 8 characters
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        p.error-message {
            color: red;
            margin-top: 10px;
        }

        p.success-message {
            color: green;
            margin-top: 10px;
        }

        #formFooter {
            margin-top: 20px;
            text-align: center;
        }

        #formFooter a {
            color: #999;
            text-decoration: none;
        }

        #formFooter a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Registration</h1>
        <form id="registrationForm" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <p>(At least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character)</p>
            <label for="repeat_password">Repeat Password:</label>
            <input type="password" name="repeat_password" id="repeat_password" required>
            <button type="submit">Register</button>
            <p id="message" class="success-message"></p>
            <div id="formFooter">
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting

                // Serialize the form data
                var formData = $(this).serialize();

                // Perform an AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'register.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Process the response
                        if (response.status === 'success') {
                            $('#message').removeClass('error-message').addClass('success-message').text(response.message);
                            // Optionally redirect to another page
                            // window.location.href = 'login.php';
                        } else {
                            $('#message').removeClass('success-message').addClass('error-message').text(response.message);
                        }
                    },
                    error: function() {
                        $('#message').removeClass('success-message').addClass('error-message').text('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>
