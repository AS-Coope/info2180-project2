document.getElementById('submit-button').addEventListener('click', function() {
    var form = document.getElementById('new-user-form');
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();

    // Check if all form fields are filled
    if (form.checkValidity()) {
        xhr.open('POST', 'new_user_action.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Clear the form fields
                form.reset();
                // Display the success message
                document.getElementById('form-response').innerText = xhr.responseText;
            } else {
                // Handle errors here
                document.getElementById('form-response').innerText = 'Error creating user.';
            }
        };

        xhr.send(formData);
    } else {
        // If form is not valid, show a message
        document.getElementById('form-response').innerText = 'Please fill all fields correctly.';
    }
});
