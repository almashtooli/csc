<div class="container">
    <h1>Admin Dashboard</h1>
    <h2>User Management</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    </form>
    <!-- Add the "Create a new user" button -->
    <button class="button" onclick="openCreateUserModal()">Create a new user</button>

    <!-- Create subject button -->
    <button class="button" onclick="openCreateSubjectModal()">Create Subject</button>

    <!-- Set mark button -->
    <button class="button" onclick="openSetMarkModal()">Set Mark</button>

    <!-- Assign Students button -->
    <button class="button" onclick="assignStudents()">Assign Students</button>


    <br> <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php include "user_rows.php"; ?>
    </table>
</div>
