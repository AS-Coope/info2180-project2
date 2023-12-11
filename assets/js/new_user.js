document.addEventListener('DOMContentLoaded', function () {
    const submitBtn = document.getElementById('submit-button');

    // variable declaration
    const newUserFNameInput = document.getElementById("firstname");
    const newUserLNameInput = document.getElementById("lastname");
    const newUserEmailInput = document.getElementById("email");
    const newUserPasswordInput = document.getElementById("password");
    const newUserRoleInput = document.getElementById("role");

    // regex declarations
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    const nameRegex = /[A-Za-z ]+/;

    function validateNewUserForm() {

        // validates all input for new user

        // name checks
        if (!(newUserFNameInput.value.trim() !== '')) {
            alert("Please enter a valid First Name. The input is empty.");
            return false;
        }

        if (!nameRegex.test(newUserFNameInput.value)) {
            alert("Please enter a name with only letters.");
            return false;
        }

        if (!(newUserLNameInput.value.trim() !== '')) {
            alert("Please enter a valid Last Name. The input is empty.");
            return false;
        }

        if (!nameRegex.test(newUserLNameInput.value)) {
            alert("Please enter a name with only letters.");
            return false;
        }

        // email checks
        if (!(newUserEmailInput.value.trim() !== '')) {
            alert("Please enter a valid Email Address. The input is empty.");
            return false;
        }

        if (!emailRegex.test(newUserEmailInput.value)) {
            alert("Please enter the email according to the following format: example@gmail.com");
            return false;
        }

        //password checks
        if (newUserPasswordInput.value.length < 8) {
            alert("Please ensure the password is at least 8 characters long.");
            return false;
        }
        if (!passwordRegex.test(newUserPasswordInput.value)) {
            alert("Please ensure the password has a capital letter and a number.");
            return false;
        }

        return true;
    }

    function postNewUser() {
        const newUserForm = document.getElementById('new-user-form');
        const newUserFormData = new FormData();
        const xhr = new XMLHttpRequest();

        newUserFormData.append('firstname', newUserFNameInput.value.trim());
        newUserFormData.append('lastname', newUserLNameInput.value.trim());
        newUserFormData.append('email', newUserEmailInput.value.trim());
        newUserFormData.append('password', newUserPasswordInput.value.trim());
        newUserFormData.append('role', newUserRoleInput.value);

        xhr.open('POST', 'new_user_action.php', true);

        // Set up callback to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    newUserForm.reset();
                    document.getElementById('form-response').innerText = xhr.responseText;
                } else {
                    document.getElementById('form-response').innerText = 'Error creating user.';
                }
            }
        };

        // Send the request with form data
        xhr.send(newUserFormData);
    }

    submitBtn.addEventListener('click', function () {

        console.log("Here works");
        // Perform client-side validation
        if (validateNewUserForm()) {
            postNewUser();
        }
    });
});

