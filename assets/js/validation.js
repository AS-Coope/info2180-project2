document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting

        // Perform client-side validation
        if (validateForm()) {
            // If validation is successful, proceed with XMLHttpRequest
            performLogin();
        }
    });

    function validateForm() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        console.log(passwordInput)
        // Trim input values
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        // Basic email format validation using regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return false;
        }

        // Password must be at least 8 characters long with atleast 1 digit
        const passwordRegex = /^(?=.*\d).{8,}$/;
        if (password.length < 8) {
            alert('Password must be at least 8 characters long.');
            return false;
        }

        return true; // Validation successful
    }

    function performLogin() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        // Create FormData object to send form data via XMLHttpRequest
        const formData = new FormData();
        formData.append('email', emailInput.value.trim());
        formData.append('password', passwordInput.value.trim());

        // Create and configure XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'handle_login.php', true);

        // Set up callback to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Handle successful response (you can customize this part)

                    window.location.href = 'dashboard.php'; // Redirect to the dashboard page
                } else {
                    // Handle error response (you can customize this part)
                    alert('Login failed. ' + xhr.responseText);
                }
            }
        };

        // Send the request with form data
        xhr.send(formData);
    }
});
