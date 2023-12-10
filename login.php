<?php
session_start();
require 'db.php'; // Include database connection

// Check if the user is already logged in, if yes then redirect to dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/loginstyles.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo-container">
            <img src="assets/images/dolphin.png" alt="Dolphin CRM Logo" class="logo">
        </div>
        <div class="title-container">
            <span>Dolphin CRM</span>
        </div>
    </div>
    <div id="login-container">
    <form id="login-form" action="handle_login.php" method="post">
    <h1>Login</h1>
            <div class="input-container">
                <input type="email" id="email" name="email" placeholder="Email address" required>
            </div>
            <div class="input-container password-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span id="toggle-password" class="eye-icon">👁️</span> <!-- Eye icon -->
            </div>
            <div class="input-container">
                <button type="submit">Login</button>
            </div>
        </form>
        <footer>
            <p>&copy; 2022 Dolphin CRM</p>
        </footer>
    </div>

   <script src="assets/js/validation.js" type="text/javascript"></script>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function (e) {
            // Toggle the type attribute using getAttribute() and setAttribute()
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
    
            // Toggle the eye icon
            this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️'; // Update with appropriate icons
        });
    </script>
    
</body>
</html>
