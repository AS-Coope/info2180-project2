<?php
session_start(); // Start the session

// Check if the user is not logged in (adjust 'user_id' to your session variable)
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Dolphin CRM</title>
    <link rel="stylesheet" href="assets/css/dashboard_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="top-bar">
    <div class="logo-container">
        <img src="assets/images/dolphin.png" alt="Dolphin CRM Logo" class="logo">
        <span class="top-bar-title">Dolphin CRM</span>
    </div>
</div>
    <div class="side-panel">
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="active"><a href="new_contact.php"><i class="fas fa-address-card"></i> New Contact</a></li>
            <li><a href="user_list.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>    
    
    <div class="main-content">
    <button type="button" class="add-user-button" onclick="location.href='new_contact.php'">+ Add Contact</button>
        <h2>Dashboard</h2>
        


        <!-- Contact Table Display -->
        <div class="contact-table">
                    <!-- Filters -->
        <div class="filters">
            <span>Filter By:</span>
            <button onclick="filterContacts('all')">All</button>
            <button onclick="filterContacts('sales')">Sales Leads</button>
            <button onclick="filterContacts('support')">Support</button>
            <button onclick="filterContacts('assigned')">Assigned to me</button>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Title and Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require 'db.php';
                        $currentUserId = $_SESSION['id'];

                        // SQL query to fetch all contacts
                        $sql = "SELECT id, title, CONCAT(firstname, ' ', lastname) AS fullname, email, company, type FROM Contacts";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["title"]) . " " . htmlspecialchars($row["fullname"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["company"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
                                echo "<td><button onclick='viewContact(" . htmlspecialchars($row["id"]) . ")'>View</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No contacts found</td></tr>";
                        }
                        $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function filterContacts(filter) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_contacts.php?filter=' + filter, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the table body with the filtered contacts
                document.querySelector('.contact-table tbody').innerHTML = xhr.responseText;
            } else {
                console.error('An error occurred fetching the contacts.');
            }
        };
        xhr.send();
    }

    function viewContact(contactId) {
        window.location.href = 'contact_detail.php?id=' + contactId;
    }
</script>

</body>
</html>
