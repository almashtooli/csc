<!-- Set mark modal -->
<div id="setMarkModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSetMarkModal()">&times;</span>
        <h2>Set Mark</h2>
        <form action="save_mark.php" method="post" onsubmit="submitMarkForm(event)">
            <label for="studentList">Student:</label>
            <select id="studentList" name="student_id" onchange="loadSubjects(this.value)">
                <?php
                // Retrieve the list of students from the database
                $query = "SELECT id, username FROM users where role == user";
                $result = $connection->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($student = $result->fetch_assoc()) {
                        echo '<option value="' . $student['id'] . '">' . $student['username'] . '</option>';
                    }
                } else {
                    echo '<option disabled>No students found</option>';
                }
                ?>
            </select>
            <input type="hidden" name="student_id" id="setMarkStudentId" value="">
            <label for="subject_id">Subject:</label>
            <select name="subject_id" id="setMarkSubjectId">
                <?php
                // Loop through the subjects and generate the options
                foreach ($subjects as $subject) {
                    echo '<option value="' . $subject['id'] . '">' . $subject['name'] . '</option>';
                }
                ?>
            </select>
            <label for="mark">Mark:</label>
            <input type="text" name="mark" id="mark" required>
            <button type="submit" name="set_mark">Set Mark</button>
        </form>
    </div>
</div>