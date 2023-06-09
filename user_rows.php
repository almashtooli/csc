<?php

include 'connection.php';

// Retrieve the list of users from the database
$query = "SELECT id, username, email, active FROM users where role = 'user'";
$result = $connection->query($query);

// Check if there are any users
if ($result->num_rows > 0) {
    // Loop through each row and fetch the user data
    while ($user = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>" . ($user['active'] ? 'Active' : 'Inactive') . "</td>";
        echo "<td>";
        echo "<button class='button' style='background-color:blue;' onclick='openEditUserModal(" . $user['id'] . ")'>Edit</button>";
        echo "<button class='button' style='background-color:red;' onclick='openDeleteUserModal(" . $user['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    // If no users found, display a message in a single row of the table
    echo "<tr><td colspan='5'>No users found.</td></tr>";
}

// Close the database connection
$connection->close();

?>

<!-- Edit user modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editUserModal')">&times;</span>
        <h2>Edit User</h2>
        <form class="form" method="POST" action="update_user.php">
            <input type="hidden" id="editUserId" name="edit_user_id">
            <label class="form-label" for="editUsername">Username:</label>
            <input type="text" id="editUsername" name="edit_username" required><br><br>
            <label class="form-label" for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="edit_email" required><br><br>
            <label  for="editActivity">Active:</label>
            <input type="checkbox" id="editActivity" name="edit_activity" value="1"><br><br>
            <button class="button" type="submit">Save Changes</button>
        </form>
    </div>
</div>

<!-- Delete user modal -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteUserModal')">&times;</span>
        <h2>Delete User</h2>
        <p>Are you sure you want to delete this user?</p>
        <form method="POST" action="delete_user.php">
            <input type="hidden" id="deleteUserId" name="delete_user_id">
            <button class="button" style="background-color: red;" type="submit">Delete</button>
        </form>
    </div>
</div>

<!-- JavaScript functions -->
<script>
  // Open the edit user modal using AJAX and jQuery
function openEditUserModal(userId) {
    // Show the modal
    $("#editUserModal").css("display", "block");

    // Retrieve the user data from the database using AJAX
    $.ajax({
        url: "get_user.php",
        method: "GET",
        data: { id: userId },
        success: function (response) {
            var user = JSON.parse(response);
            populateEditUserForm(user);
        },
        error: function (xhr, status, error) {
            // Handle the error
            console.log("AJAX request error:", error);
        }
    });
}

// Function to populate the edit user form fields
function populateEditUserForm(user) {
    $("#editUserId").val(user.id);
    $("#editUsername").val(user.username);
    $("#editEmail").val(user.email);
    $("#editActivity").prop("checked", user.active === "1");
}

// Submit the edit user form via AJAX
$("#editUserForm").on("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();

    // Submit the form data via AJAX
    $.ajax({
        url: "update_user.php",
        method: "POST",
        data: formData,
        success: function (response) {
            console.log("User updated successfully:", response);
            $("#editUserModal").css("display", "none");
        },
        error: function (xhr, status, error) {
            console.log("AJAX request error:", error);
        }
    });
});
 

   // Open the delete user modal using AJAX and jQuery
function openDeleteUserModal(userId) {
    // Show the modal
    $("#deleteUserModal").css("display", "block");

    // Set the value of deleteUserId input
    $("#deleteUserId").val(userId);
}

// Attach event listener to the delete button in the modal
$("#deleteUserModal form").on("submit", function (event) {
    event.preventDefault();

    // Get the user ID from the input field
    var userId = $("#deleteUserId").val();

    // Send the AJAX request to delete_user.php
    $.ajax({
        url: "delete_user.php",
        method: "POST",
        data: { delete_user_id: userId },
        success: function (response) {
            if (response === "success") {
                closeModal("deleteUserModal");
            } else {
                console.log("Failed to delete user.");
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX request error:", error);
        }
    });
});


    // Close the modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
    }
</script>
