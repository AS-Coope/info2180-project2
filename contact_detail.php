
<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    die("Contact ID is required.");
}

// Check if the user is not logged in (adjust 'user_id' to your session variable)
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.html");
    exit();
}

$contactId = $_GET['id'];
$currentUserId = $_SESSION['id']; 

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
$notesStmt = $conn->prepare("SELECT Notes.*, CONCAT(Users.firstname, ' ', Users.lastname) AS author_name FROM Notes JOIN Users ON Notes.created_by = Users.id WHERE contact_id = ? ORDER BY Notes.created_at ASC");
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
    <img src="blank.png" alt="Profile Picture" class="contact-image" />
        <div>
            <h1><?php echo htmlspecialchars($contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']); ?></h1>
            <p>Created on <?php echo htmlspecialchars($contact['created_at']); ?> by <?php echo htmlspecialchars($contact['created_by_name']); ?></p>
            <p>Updated on <?php echo htmlspecialchars($contact['updated_at']); ?></p>
        </div>
    </div>
    <div class="contact-details-actions">
    <button id="assign-to-me" onclick="assignToMe(<?php echo $contactId; ?>, <?php echo $currentUserId; ?>)">
        Assign to me
    </button>

    <button id="switch-type" onclick="switchContactType(<?php echo $contactId; ?>, this)" data-current-type="<?php echo $contact['type']; ?>">
        Switch to <?php echo $contact['type'] === 'Support' ? 'Sales Lead' : 'Support'; ?>
    </button>
    </div>
</div>


<div class="contact-details-body">
    <div class="form-field">
        <label for="email">Email:</label>
        <p id="email"><?php echo htmlspecialchars($contact['email']); ?></p>
    </div>
    <div class="form-field">
        <label for="telephone">Telephone:</label>
        <p id="telephone"><?php echo htmlspecialchars($contact['telephone']); ?></p>
    </div>
    <div class="form-field">
        <label for="company">Company:</label>
        <p id="company"><?php echo htmlspecialchars($contact['company']); ?></p>
    </div>
    <div class="form-field">
        <label for="Assigned_to">Assigned To:</label>
        <p id="Assigned_to"><?php echo htmlspecialchars($contact['assigned_firstname'] . ' ' . $contact['assigned_lastname']); ?></p>
    </div>
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
                <input type="hidden" name="contactId" id="contact-id" value="<?php echo $contactId; ?>" />
                <textarea name="comment" id="note-comment" placeholder="Add a note about <?php echo htmlspecialchars($contact['firstname']); ?>"></textarea>
                <button type="submit">Add Note</button>
            </form>

        </div>
    </div>

    <script>
        function assignToMe(contactId, currentUserId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'assign_contact.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Contact assigned successfully');
                    // Optionally, refresh the page or update the UI to reflect the change
                } else {
                    alert('Error assigning contact');
                }
            };
            xhr.send('contactId=' + contactId + '&currentUserId=' + currentUserId);
}

        function switchContactType(contactId, button) {
            var currentType = button.getAttribute('data-current-type');
            var newType = currentType === 'Support' ? 'Sales Lead' : 'Support';
            var params = 'contactId=' + contactId + '&newType=' + newType;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'switch_contact_type.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Update the button text and data attribute
                    button.textContent = 'Switch to ' + (newType === 'Support' ? 'Sales Lead' : 'Support');
                    button.setAttribute('data-current-type', newType);
                    alert('Contact type updated to ' + newType);
                } else {
                    alert('Error updating contact type');
                }
            };
            xhr.send(params);
        }


        document.getElementById('add-note-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var comment = document.getElementById('note-comment').value;
            var contactId = document.getElementById('contact-id').value;

            if (comment.trim() === '') {
                alert('Please enter a note.');
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_note.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if(response.success) {
                        var notesContainer = document.getElementById('notes-container');
                        var newNoteDiv = document.createElement('div');
                        newNoteDiv.className = 'note';
                        newNoteDiv.innerHTML = `
                            <p><strong>${response.authorName}</strong> <em>${response.createdAt}</em></p>
                            <p>${comment}</p>
                        `;
                        notesContainer.appendChild(newNoteDiv); // Append to the end of the container
                        document.getElementById('note-comment').value = '';
                    } else {
                        alert(response.error);
                    }
                } else {
                    alert('Error adding note.');
                }
            };
            var data = 'contactId=' + encodeURIComponent(contactId) + '&comment=' + encodeURIComponent(comment);
            xhr.send(data);
        });



    </script>
</body>
</html>
