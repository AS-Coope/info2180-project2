<?php
session_start();

require 'db.php';  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $title = $conn->real_escape_string($_POST['title']);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $company = $conn->real_escape_string($_POST['company']);
    $type = $conn->real_escape_string($_POST['type']);
    $assigned_to = $conn->real_escape_string($_POST['assigned_to']);
    
    $created_by = $_SESSION['id']; 

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    
    // Bind the parameters to the SQL query
    $stmt->bind_param("ssssssiii", $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by);
    
    // Execute the query
    if ($stmt->execute()) {

        echo "New contact added successfully.";

    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: new_contact.php");
    exit;
}

?>
