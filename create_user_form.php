<!-- Create user modal -->
<div id="createUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('createUserModal')">&times;</span>
        <h2>Create User</h2>
        <form class="form" id="createUserForm">
            <label class="form-label" for="createUsername">Username:</label>
            <input type="text" id="createUsername" name="create_username" required><br><br>
            <label class="form-label"for="createEmail">Email:</label>
            <input type="email" id="createEmail" name="create_email" required><br><br>
            <label class="form-label"for="createPassword">Password:</label>
            <input type="password" id="createPassword" name="create_password" required><br>
            <label class="form-label"for="createRepeatPassword">Repeat Password:</label>
            <input type="password" id="createRepeatPassword" name="create_repeat_password" required><br><br>
            <label  for="createActivity">Activity:</label>
            <input type="checkbox" id="createActivity" name="create_activity" value="1"><br><br>
            <input hidden type="text" id="role" name="role" value="user">
            <button class="button" type="button" onclick="saveUser()">Create</button>
        </form>
    </div>
</div>

<script>
    // Open the create user modal
    function openCreateUserModal() {
        openModal('createUserModal');
    }

    // Close the modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
    }

    // Open the modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "block";
    }

    // Save the user
    function saveUser() {
        var form = document.getElementById("createUserForm");
        form.action = "save_user.php";
        form.method = "POST";
        form.submit();
    }
</script>
