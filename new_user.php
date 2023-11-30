<?php
session_start();
require 'db.php';

$message = ''; // Initialize a message variable

// Check if user is logged in and is an admin
$userIsAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';

// Process the form when it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$userIsAdmin) {
        echo "Elevation Required";
        exit;
    }

    // Sanitize and validate input
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate password strength
    if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $password)) {
        // Handle error - Password doesn't meet requirements
        exit('Password does not meet the requirements.');
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, password, email, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $firstname, $lastname, $hashed_password, $email, $role);
    $result = $stmt->execute();

    // Provide user with feedback
    if ($result) {
        echo "User successfully saved";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>