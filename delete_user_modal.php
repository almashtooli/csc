<!-- Delete user modal -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteUserModal')">&times;</span>
        <h2>Delete User</h2>
        <p>Are you sure you want to delete this user?</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" id="deleteUserId" name="delete_user_id">
            <button class="button" style="background-color: red;" type="submit" name="delete_user">Delete</button>
        </form>
    </div>
</div>

<?php
// Handle the delete user form submission
if (isset($_POST['delete_user'])) {
    // Retrieve the user ID from the form
    $userId = $_POST['delete_user_id'];

    // TODO: Perform any necessary validation and sanitization of the user ID

    // Delete the user from the database
    $stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Redirect to the same page to prevent form resubmission
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
?>
