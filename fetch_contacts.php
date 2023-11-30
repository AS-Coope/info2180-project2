<?php
session_start();
require 'db.php';

$filterType = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$currentUserId = $_SESSION['id'];  // Ensure you are using the correct session variable

// Start with a base SQL query
$sql = "SELECT id, title, CONCAT(firstname, ' ', lastname) AS fullname, email, company, type FROM Contacts";

// Modify the query based on the filter type
switch ($filterType) {
    case 'sales':
        $sql .= " WHERE type = 'Sales Lead'";
        break;
    case 'support':
        $sql .= " WHERE type = 'Support'";
        break;
    case 'assigned':
        $sql .= " WHERE assigned_to = $currentUserId";
        break;
    // No default case needed as 'all' will use the base query
}

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
