<?php
session_start();
require 'db.php';

if (isset($_POST['contactId']) && isset($_POST['currentUserId'])) {
    $contactId = $_POST['contactId'];
    $currentUserId = $_POST['currentUserId'];

    // Update the contact to be assigned to the current user
    $stmt = $conn->prepare("UPDATE Contacts SET assigned_to = ? WHERE id = ?");
    $stmt->bind_param("ii", $currentUserId, $contactId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Contact assigned successfully.";
    } else {
        echo "Error or no changes made in assignment.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
