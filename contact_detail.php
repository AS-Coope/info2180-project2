<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    die("Contact ID is required.");
}

$contactId = $_GET['id'];
$currentUserId = $_SESSION['id']; // Make sure this is correctly set when the user logs in

// Fetch the contact details
$stmt = $conn->prepare("SELECT Contacts.*, CONCAT(Users.firstname, ' ', Users.lastname) AS created_by_name, Users2.firstname AS assigned_firstname, Users2.lastname AS assigned_lastname FROM Contacts LEFT JOIN Users ON Contacts.created_by = Users.id LEFT JOIN Users as Users2 ON Contacts.assigned_to = Users2.id WHERE Contacts.id = ?");
$stmt->bind_param("i", $contactId);
$stmt->execute();
$contactResult = $stmt->get_result();
$contact = $contactResult->fetch_assoc();

if (!$contact) {
    die("Contact not found.");
}

// Fetch the notes for the contact
$notesStmt = $conn->prepare("SELECT Notes.*, CONCAT(Users.firstname, ' ', Users.lastname) AS author_name FROM Notes JOIN Users ON Notes.created_by = Users.id WHERE contact_id = ? ORDER BY Notes.created_at DESC");
$notesStmt->bind_param("i", $contactId);
$notesStmt->execute();
$notesResult = $notesStmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Details - Dolphin CRM</title>
    <link rel="stylesheet" href="view_contact.css">
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
            <li class="active"><a href="new_contact.php"><i class="fas fa-address-card"></i> New Contact</a></li>
            <li><a href="user_list2.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>    

    <div class="contact-details-container">
        
    <div class="contact-details-header">
    <div>
        <h1><?php echo htmlspecialchars($contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']); ?></h1>
        <p>Created on <?php echo htmlspecialchars($contact['created_at']); ?> by <?php echo htmlspecialchars($contact['created_by_name']); ?></p>
        <p>Updated on <?php echo htmlspecialchars($contact['updated_at']); ?></p>
    </div>
    <div class="contact-details-actions">
        <button id="assign-to-me" onclick="assignToMe(<?php echo $contactId; ?>, <?php echo $currentUserId; ?>)">Assign to me</button>
        <button id="switch-type" onclick="switchContactType(<?php echo $contactId; ?>, '<?php echo $contact['type']; ?>')">Switch to <?php echo $contact['type'] === 'Support' ? 'Sales Lead' : 'Support'; ?></button>
    </div>
</div>

        <div class="contact-details-body">
            <p>Email: <?php echo htmlspecialchars($contact['email']); ?></p>
            <p>Telephone: <?php echo htmlspecialchars($contact['telephone']); ?></p>
            <p>Company: <?php echo htmlspecialchars($contact['company']); ?></p>
            <p>Assigned To: <?php echo htmlspecialchars($contact['assigned_firstname'] . ' ' . $contact['assigned_lastname']); ?></p>
        </div>

        <div class="contact-details-notes">
            <h2>Notes</h2>
            <?php while($note = $notesResult->fetch_assoc()): ?>
                <div class="note">
                    <p><?php echo htmlspecialchars($note['author_name']); ?></p>
                    <p><?php echo htmlspecialchars($note['comment']); ?></p>
                    <p><?php echo htmlspecialchars($note['created_at']); ?></p>
                </div>
            <?php endwhile; ?>
            <form id="add-note-form">
                <textarea name="comment" id="note-comment" placeholder="Add a note about <?php echo htmlspecialchars($contact['firstname']); ?>"></textarea>
                <button type="submit">Add Note</button>
            </form>
        </div>
    </div>

    <script>
        function assignToMe(contactId, currentUserId) {
            // AJAX call to assign the contact to the current user
        }

        function switchContactType(contactId, currentType) {
            // AJAX call to switch the contact's type
        }

        document.getElementById('add-note-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var comment = document.getElementById('note-comment').value;
            // AJAX call to add the note
        });
    </script>
</body>
</html>
