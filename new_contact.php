<?php
session_start(); // Start the session

// Check if the user is not logged in (adjust 'user_id' to your session variable)
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Contact - Dolphin CRM</title>
    <link rel="stylesheet" href="new_contact_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="top-bar">
    <div class="logo-container">
        <img src="dolphin.png" alt="Dolphin CRM Logo" class="logo">
        <span class="top-bar-title">Dolphin CRM</span>
    </div>
</div>
    <div class="side-panel">
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="active"><a href="new_contact.php"><i class="fas fa-address-card"></i> New Contact</a></li>
            <li><a href="user_list2.php"><i class="fas fa-users"></i> Users</a></li>
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
                </div>
                <!-- Last Name -->
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" pattern="[A-Za-z ]+" title="Only alphabets and spaces are allowed" required>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <!-- Telephone -->
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input type="tel" id="telephone" name="telephone" pattern="\d{10}" title="Telephone must be 10 digits" required>
                </div>
                <!-- Company -->
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" required>
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
    document.getElementById('new-contact-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevents the default form submission

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'new_contact_action.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Clear the form fields
                document.getElementById('new-contact-form').reset();
                // Display the success message
                document.getElementById('save-message').innerText = 'Contact saved successfully.';
            } else {
                // Handle errors here
                document.getElementById('save-message').innerText = 'Error saving contact.';
            }
        };

        xhr.send(formData);
    });

</script>

</body>
</html>
