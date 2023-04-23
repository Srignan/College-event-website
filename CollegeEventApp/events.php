<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch events from the database
$events = array();
$query = "SELECT events.*, rsos.name AS rso_name
          FROM events
          LEFT JOIN rsos ON events.rso_id = rsos.id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
	<nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="events.php">Events</a>
        <a href="logout.php">Logout</a>
    </nav>
	
    <h1>Events</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Location</th>
                <th>Contact Phone</th>
                <th>Contact Email</th>
                <th>Visibility</th>
                <th>RSO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($events)) {
                foreach ($events as $row) {
                    echo "<tr>";
                    echo "<td><a href='event_details.php?event_id=" . $row['id'] . "'>" . $row['name'] . "</a></td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>"; // Display the location name.
                    echo "<td>" . $row['contact_phone'] . "</td>";
                    echo "<td>" . $row['contact_email'] . "</td>";
                    echo "<td>" . $row['visibility'] . "</td>";
                    echo "<td>" . $row['rso_name'] . "</td>"; // Display the RSO name.
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
