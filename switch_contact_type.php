<?php
session_start();
require 'db.php';

if (isset($_POST['contactId']) && isset($_POST['newType'])) {
    $contactId = $_POST['contactId'];
    $newType = $_POST['newType'];

    // Update the contact's type in the database
    $stmt = $conn->prepare("UPDATE Contacts SET type = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $newType, $contactId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Contact type updated successfully.";
    } else {
        echo "Error or no changes made in type update.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
