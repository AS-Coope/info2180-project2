<?php
session_start(); // Start the session

// Check if the user is not logged in 
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Contact - Dolphin CRM</title>
    <link rel="stylesheet" href="assets/css/new_contact_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="top-bar">
    <div class="logo-container">
        <img src="assets/images/dolphin.png" alt="Dolphin CRM Logo" class="logo">
        <span class="top-bar-title">Dolphin CRM</span>
    </div>
</div>
    <div class="side-panel">
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="active"><a href="new_contact.php"><i class="fas fa-address-card"></i> New Contact</a></li>
            <li><a href="user_list.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>    
    <div class="main-content">
        <h1>New Contact</h1>
        <form id="new-contact-form" action="new_contact_action.php" method="post">
            <div class="form-container">
                <!-- Title Dropdown -->
                <div class="form-group title-dropdown">
                    <label for="title">Title</label>
                    <select id="title" name="title">
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Sir">Sir</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Hon.">Hon.</option>
                    </select>
                </div>
                <!-- First Name -->
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" pattern="[A-Za-z ]+" title="Only alphabets and spaces are allowed" required>
                    <div id="firstname-message"></div>
                </div>
                <!-- Last Name -->
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" pattern="[A-Za-z ]+" title="Only alphabets and spaces are allowed" required>
                    <div id="lastname-message"></div>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
                    <div id="email-message"></div>
                </div>
                <!-- Telephone -->
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input type="tel" id="telephone" name="telephone" pattern="\d{10}" title="Telephone must be 10 digits" required>
                    <div id="telephone-message"></div>
                </div>
                <!-- Company -->
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" required title="Enter company name">
                    <div id="company-message"></div>
                </div>
                <!-- Type -->
                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" required>
                        <option value="Sales Lead">Sales Lead</option>
                        <option value="Support">Support</option>
                    </select>
                </div>
                <!-- Assigned To -->
                <div class="form-group">
                    <label for="assigned_to">Assigned To</label>
                    <select id="assigned_to" name="assigned_to">
                        <?php
                        require 'db.php';  
                        
                        // SQL query to fetch all users
                        $sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM users";
                        $result = $conn->query($sql);
                    
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["fullname"]) . "</option>";
                            }
                        } else {
                            echo "<option value=''>No users found</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="save-button">Save</button>
            <div id="save-message"></div> <!-- Placeholder for success message -->
        </form>
    </div>

<script>
    // create variables where necessary
    const newContactForm = document.getElementById('new-contact-form');
    var saveMessage = document.getElementById('save-message');
    var fNameMessage = document.getElementById('firstname-message');
    var lNameMessage = document.getElementById('lastname-message');
    var emailMessage = document.getElementById('email-message');
    var telephoneMessage = document.getElementById('telephone-message');
    var companyMessage = document.getElementById('company-message');

    const newContactTitle = document.getElementById('title');
    const newContactFName = document.getElementById('firstname');
    const newContactLName = document.getElementById('lastname');
    const newContactEmail = document.getElementById('email');
    const newContactTel = document.getElementById('telephone');
    const newContactComp = document.getElementById('company');
    const newContactType = document.getElementById('type');
    const newContactAsgnTo = document.getElementById('assigned_to');

    // create regexes where necessary
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const telRegex = /\d{10}/;
    //const passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    const nameRegex = /[A-Za-z ]+/;

    // create validate function
    function validateNewContactForm() {

        // validates all input for new user

        // name checks
        if (!(newContactFName.value.trim() !== '')) {
            fNameMessage.innerText = "Please enter a valid First Name. The input is empty.");
            return false;
        }
        if (!nameRegex.test(newContactFName.value)) {
            fNameMessage.innerText = "Please enter a name with only letters.";
            return false;
        }
        fNameMessage.innerText = '';

        if (!(newContactLName.value.trim() !== '')) {
            lNameMessage.innerText = "Please enter a valid Last Name. The input is empty.";
            return false;
        }

        if (!nameRegex.test(newContactLName.value)) {
            lNameMessage.innerText = "Please enter a name with only letters.";
            return false;
        }
        lNameMessage.innerText = '';

        // email checks
        if (!(newContactEmail.value.trim() !== '')) {
            emailMessage.innerText = "Please enter a valid Email Address. The input is empty.";
            return false;
        }
        if (!emailRegex.test(newContactEmail.value)) {
            emailMessage.innerText = "Please enter the email according to the following format: example@gmail.com";
            return false;
        }
        emailMessage.innerText = '';


        //company check
        if (!(newContactComp.value.trim() !== '')) {
            companyMessage.innerText = "Please enter a valid Company Name. The input is empty.";
            return false;
        }
        companyMessage.innerText = '';

        //telephone checks
        if (newContactTel.value.length < 10) {
            telephoneMessage.innerText = "Please ensure the telephone number is at least 10 digits long.";
            return false;
        }
        if (!(newContactTel.value.trim() !== '')) {
            telephoneMessage.innerText = "Please enter a valid Telephone Number. The input is empty.";
            return false;
        }
        if (!telRegex.test(newContactTel.value)) {
            telephoneMessage.innerText = "Please ensure the password is of the format: ##########, where # is a digit";
            return false;
        }
        telephoneMessage.innerText = ''

        return true;
    }

    // create post function
    function postNewContact(){
        const newContactFormData = new FormData();
        newContactFormData.append('title', newContactTitle.value);
        newContactFormData.append('firstname', newContactFName.value.trim());
        newContactFormData.append('lastname', newContactLName.value.trim());
        newContactFormData.append('email', newContactEmail.value.trim());
        newContactFormData.append('telephone', newContactTel.value.trim());
        newContactFormData.append('company', newContactComp.value.trim());
        newContactFormData.append('type', newContactType.value);
        newContactFormData.append('assigned_to', newContactAsgnTo.value);

        const xhr = new XMLHtmlRequest();
        xhr.open('POST', 'new_contact_action.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Clear the form fields
                newContactForm.reset();
                // Display the success message
                saveMessage.innerText = 'Contact saved successfully.';
            } else {
                // Handle errors here
                saveMessage.innerText = 'Error saving contact.';
            }
        };

        xhr.send(formData);

    }

    newContactForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevents the default form submission

        if(validateNewContactForm()) {
            postNewContact();
        }
        
    });

</script>

</body>
</html>
