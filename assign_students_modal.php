<!-- Assign Students Modal -->
<div id="assignStudentsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('assignStudentsModal')">&times;</span>
        <h2>Assign Students to Subject</h2>
        <form id="assignStudentsForm">
            <label for="subject">Subject:</label>
            <select id="subject" name="subject">
                <!-- Options for subjects -->
                <?php
                $subjectQuery = "SELECT * FROM subjects";
                $subjectResult = $connection->query($subjectQuery);

                if ($subjectResult && $subjectResult->num_rows > 0) {
                    while ($subjectRow = $subjectResult->fetch_assoc()) {
                        $subjectId = $subjectRow['id'];
                        $subjectName = $subjectRow['name'];
                        echo "<option value='$subjectId'>$subjectName</option>";
                    }
                }
                ?>
            </select>

            <label for="students">Students:</label>
            <select id="students" name="students[]" multiple>
                <!-- Options for students -->
                <?php
                $studentQuery = "SELECT * FROM students";
                $studentResult = $connection->query($studentQuery);

                if ($studentResult && $studentResult->num_rows > 0) {
                    while ($studentRow = $studentResult->fetch_assoc()) {
                        $studentId = $studentRow['id'];
                        $studentName = $studentRow['name'];
                        echo "<option value='$studentId'>$studentName</option>";
                    }
                }
                ?>
            </select>

            <button class="button" type="submit">Assign Students</button>
        </form>
    </div>
</div>
