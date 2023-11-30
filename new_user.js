document.getElementById('submit-button').addEventListener('click', function() {
    var formData = new FormData(document.getElementById('new-user-form'));
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'new_user_action.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Clear the form fields
            document.getElementById('new-user-form').reset();
            // Display the success message
            document.getElementById('form-response').innerText = xhr.responseText;
        } else {
            // Handle errors here
            document.getElementById('form-response').innerText = 'Error creating user.';
        }
    };

    xhr.send(formData);
});
