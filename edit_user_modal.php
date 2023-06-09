<!-- Edit user modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editUserModal')">&times;</span>
        <h2>Edit User</h2>
        <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" id="editUserId" name="edit_user_id">
            <label for="editUsername">Username:</label>
            <input type="text" id="editUsername" name="edit_username" required><br><br>
            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="edit_email" required><br><br>
            <label for="editActivity">Activity:</label>
            <input type="checkbox" id="editActivity" name="edit_activity" value="1"><br><br>
            <button class="button" type="submit">Save</button>
        </form>
    </div>
</div>
