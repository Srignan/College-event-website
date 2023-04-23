<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch private events for the user's university from the database
$events = array();
$university_id = $_SESSION['university_id'];
$query = "SELECT * FROM events WHERE visibility = 'private' AND university_id = '$university_id'";
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
    <title>Private Events</title>
</head>
<body>
    <h1>Private Events</h1>

    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($events)) {
                foreach ($events as $event) {
                    echo "<tr>";
					echo "<td><a href='event_details.php?event_id=" . $event['id'] . "'>" . $event['name'] . "</a></td>";
                    echo "<td>" . $event['event_name'] . "</td>";
                    echo "<td>" . $event['event_category'] . "</td>";
                    echo "<td>" . $event['description'] . "</td>";
                    echo "<td>" . $event['start_time'] . "</td>";
                    echo "<td>" . $event['end_time'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No private events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
