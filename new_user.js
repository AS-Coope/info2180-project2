document.getElementById('new-user-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // 'this' refers to the form

    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'new_user.php', true); // Change 'new_user.php' to your PHP script path

    // Define what happens on successful data submission
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Display the response in the 'form-response' div
            document.getElementById('form-response').innerHTML = xhr.responseText;
        } else {
            alert('An error occurred!');
        }
    };

    // Send the form data
    xhr.send(formData);
});
