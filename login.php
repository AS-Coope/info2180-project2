<?php
session_start();
require 'db.php'; // Include database connection

// Sanitize user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Check if the password matches
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, so start a new session
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user['id'];
            $_SESSION["email"] = $email;
            
            // Redirect user to Dashboard
            header("Location: ----");
        } else {
            // Display an error message if password is not valid
            echo "The password you entered was not valid.";
        }
    } else {
        // Display an error message if email doesn't exist
        echo "No account found with that email.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
