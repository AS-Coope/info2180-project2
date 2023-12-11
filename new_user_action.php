<?php
session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    // Confirm if user already exists
    // Prepare an SQL statement to prevent SQL injection
    $checkEmailStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");

    // Bind the parameters to the SQL query
    $checkEmailStmt->bind_param("s", $email);

    // Execute the query and retrieve result.
    $checkEmailStmt->execute();
    $result = $checkEmailStmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: A user already exists with this email address.";
    } else{
        // Password validation
        if (!preg_match("/^(?=.\d)(?=.[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
            echo "Error: Password must be at least 8 characters long and include at least one number and one uppercase letter.";
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, password, email, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");

        // Bind the parameters to the SQL query
        $stmt->bind_param("sssss", $firstname, $lastname, $hashed_password, $email, $role);

        // Execute the query
        if ($stmt->execute()) {
            echo "New user added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
    $checkEmailStmt->close();
} else {
    header("Location: new_user.php?error=invalid_request");
    exit;
}
?>