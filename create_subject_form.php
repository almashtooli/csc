<!-- Create subject form -->
<div id="createSubjectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('createSubjectModal')">&times;</span>
        <h2>Create Subject</h2>
        <form class="form" method="POST" action="save_subject.php">
            <label class="form-label" for="subjectName">Subject Name:</label>
            <input type="text" id="subjectName" name="subject_name" required><br><br>
            <label class="form-label" for="minMark">Minimum Mark for Success:</label>
            <input type="number" id="minMark" name="pass_mark" required><br><br>
            <button class="button" type="submit">Create</button>
        </form>
    </div>
</div>




