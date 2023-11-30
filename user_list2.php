<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List - Dolphin CRM</title>
    <link rel="stylesheet" href="user_list_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="top-bar"></div> <!-- Horizontal bar at the top -->
    <div class="side-panel">
        <ul class="sidebar-menu">
            <li><a href="home.html"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="new_user.html"><i class="fas fa-address-card"></i> New Contact</a></li>
            <li class="active"><a href="user_list2.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>    
    
    <!-- Fixed header container -->
<div class="fixed-header">
    <h2>User List</h2>
    <button type="button" class="add-user-button" onclick="location.href='new_user.html'">+ Add User</button>
</div>

<!-- Scrollable table container -->
<div class="scrollable-table">
    <!-- User Table Display -->
    <div class="user-table">
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    session_start();
                    require 'db.php';

                    // Check if the user is logged in and is an admin
                    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
                        // Display an error message and stop further execution
                        echo "<p>Access Denied. You must be an admin to view this page.</p>";
                        exit;
                    }

                    // SQL query to fetch all users
                    $sql = "SELECT firstname, lastname, email, role, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as created_at FROM users"; 
                    $result = $conn->query($sql);

                    // Check if there are any results
                    if ($result && $result->num_rows > 0) {
                        // Output the data for each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["firstname"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["lastname"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    // Close the database connection
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    </div>


</body>
</html>
