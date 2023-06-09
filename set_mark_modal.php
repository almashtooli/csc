<!-- Set mark modal -->
<div id="setMarkModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('setMarkModal')">&times;</span>
        <h2>Set Mark</h2>
        <form action="save_mark.php" method="post">
            <label class="form-label" for="studentList">Student:</label>
            <select id="studentList" name="student_id">
                <?php
                // Retrieve the list of users from the database
                $query = "SELECT id, username FROM users ";
                $result = $connection->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($user = $result->fetch_assoc()) {
                        echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
                    }
                } else {
                    echo '<option disabled>No users found</option>';
                }
                ?>
            </select><br><br>
            <label class="form-label" for="subjectList">Subject:</label>
            <select id="subjectList" name="subject_id">
                <?php
                // Retrieve the list of subjects from the database
                $query = "SELECT id, name FROM subjects";
                $result = $connection->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($subject = $result->fetch_assoc()) {
                        echo '<option value="' . $subject['id'] . '">' . $subject['name'] . '</option>';
                    }
                } else {
                    echo '<option disabled>No subjects found</option>';
                }
                ?>
            </select><br><br>
            <label class="form-label" for="mark">Mark:</label>
            <input type="text" name="mark" id="mark" required><br><br>
            <button class="button" type="submit" name="set_mark">Set Mark</button>
        </form>
    </div>
</div>
