<?php
session_start();
require 'db.php';

// Check if the form data is set and not empty
if (isset($_POST['contactId'], $_POST['comment']) && !empty($_POST['comment'])) {
    $contactId = $_POST['contactId'];
    $comment = trim($_POST['comment']);
    $createdBy = $_SESSION['id']; 

    // Sanitize and prepare the SQL statement
    $comment = $conn->real_escape_string($comment);

    // Insert the note into the database
    $stmt = $conn->prepare("INSERT INTO Notes (contact_id, comment, created_by, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("isi", $contactId, $comment, $createdBy);
    $stmt->execute();

    // After inserting the note successfully
    if ($stmt->affected_rows > 0) {
        $response = [
            'success' => true,
            'authorName' => $_SESSION['username'], 
            'createdAt' => date('Y-m-d H:i:s') 
        ];
    } else {
        $response = [
            'success' => false,
            'error' => 'Failed to add note'
        ];
    }
    echo json_encode($response);

    $stmt->close();
    $conn->close();
} else {
    echo "Please fill in all fields";
}
?>
