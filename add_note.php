<?php
session_start();
require 'db.php';

// Check if the form data is set and not empty
if (isset($_POST['contactId'], $_POST['comment']) && !empty($_POST['comment'])) {
    $contactId = $_POST['contactId'];
    $comment = trim($_POST['comment']);
    $createdBy = $_SESSION['id']; 

    // Begin transaction
    $conn->begin_transaction();

    // Sanitize and prepare the SQL statement for inserting note
    $comment = $conn->real_escape_string($comment);
    $stmt = $conn->prepare("INSERT INTO Notes (contact_id, comment, created_by, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("isi", $contactId, $comment, $createdBy);
    $stmt->execute();

    // Check if note insertion was successful
    if ($stmt->affected_rows > 0) {
        // Update the updated_at time in Contacts table
        $updateStmt = $conn->prepare("UPDATE Contacts SET updated_at = NOW() WHERE id = ?");
        $updateStmt->bind_param("i", $contactId);
        $updateStmt->execute();

        // Check if Contacts table was updated successfully
        if ($updateStmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'authorName' => $_SESSION['username'], 
                'createdAt' => date('Y-m-d H:i:s') 
            ];
            // Commit transaction
            $conn->commit();
        } else {
            $response = [
                'success' => false,
                'error' => 'Failed to update contact'
            ];
            // Rollback transaction
            $conn->rollback();
        }

        $updateStmt->close();
    } else {
        $response = [
            'success' => false,
            'error' => 'Failed to add note'
        ];
        // Rollback transaction
        $conn->rollback();
    }

    echo json_encode($response);

    $stmt->close();
    $conn->close();
} else {
    echo "Please fill in all fields";
}
?>
