// JavaScript functions for handling modals

// Open a modal by ID
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Close a modal by ID
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// AJAX request to handle form submission
function submitForm(formId, successCallback, errorCallback) {
    var form = document.getElementById(formId);
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", form.action, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                successCallback(xhr.responseText);
            } else {
                errorCallback(xhr.responseText);
            }
        }
    };
    xhr.send(formData);
}

// Open the create user modal
function openCreateUserModal() {
    openModal("createUserModal");
}

// Open the create subject modal
function openCreateSubjectModal() {
    openModal("createSubjectModal");
}

// Function to open the set mark modal
function openSetMarkModal() {
    var modal = document.getElementById('setMarkModal');
    modal.style.display = 'block';
}

// Function to close the set mark modal
function closeSetMarkModal() {
    var modal = document.getElementById('setMarkModal');
    modal.style.display = 'none';
}

// Function to submit the mark form
function submitMarkForm(event) {
    event.preventDefault();

    // Perform any additional validations or processing here

    // Submit the form
    document.forms[0].submit();
}


// Example success callback for form submission
function handleSuccess(response) {
    console.log("Success:", response);
    // Handle success response here, such as showing a success message or updating the UI
}

// Example error callback for form submission
function handleError(response) {
    console.error("Error:", response);
    // Handle error response here, such as showing an error message or logging the error
}

// Attach event listeners to buttons

document.querySelector(".create-user-button").addEventListener("click", openCreateUserModal);

// Example event listener for form submission
document.querySelector("#createUserModal form").addEventListener("submit", function (event) {
    event.preventDefault();
    submitForm("createUserModal form", handleSuccess, handleError);
});


function assignStudents() {
    // Get the selected subject and students
    var subjectId = document.getElementById("subjectSelect").value;
    var selectedStudents = Array.from(document.querySelectorAll("#studentsTable input[type='checkbox']:checked")).map(function(checkbox) {
      return checkbox.value;
    });
  
    // Make an AJAX request to assign students to the subject
    $.ajax({
      url: "assign_students.php",
      type: "POST",
      data: {
        subject_id: subjectId,
        student_ids: selectedStudents
      },
      dataType: "json",
      success: function(response) {
        if (response.success) {
          alert(response.message);
          closeModal('assignStudentsModal');
        } else {
          alert(response.message);
        }
      },
      error: function(xhr, status, error) {
        console.log("Error: " + error);
      }
    });
  }
  
// Add event listeners for other buttons and forms as needed

// ...
