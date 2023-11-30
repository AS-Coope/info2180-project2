<?php

session_start();
require 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // User is not logged in, redirect to login page
    header("Location: user_list2.php");
    exit();
}

// Check if the user is not logged in
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
    <title>Add New User - Dolphin CRM</title>
    <link rel="stylesheet" href="new_userstyles.css">
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
            <li><a href="new_contact.php"><i class="fas fa-address-card"></i> New Contact</a></li>
            <li class="active"><a href="user_list2.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>    
    <div class="main-content">
        <h1>New User</h1>
        <form id="new-user-form">
            <div class="form-container">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email address" required autocomplete="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="Member">Member</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <button type="button" id="submit-button" class="save-button">Save</button>
            </form>
        </div>
        <div id="form-response"></div> <!-- Place to show the response message -->
    </div>
    <script src="new_user.js"></script>
</body>
</html>
