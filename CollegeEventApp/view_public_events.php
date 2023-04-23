<?php
require_once 'config.inc.php';

// Fetch public events from the database
$events = array();
$query = "SELECT * FROM events WHERE visibility = 'public' AND is_approved = 1";
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
    <title>Public Events</title>
</head>
<body>
    <h1>Public Events</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($events)) {
                foreach ($events as $event) {
                    echo "<tr>";
					echo "<td><a href='event_details.php?event_id=" . $event['id'] . "'>" . $event['name'] . "</a></td>";
                    echo "<td>" . $event['name'] . "</td>";
                    echo "<td>" . $event['category'] . "</td>";
                    echo "<td>" . $event['description'] . "</td>";
                    echo "<td>" . $event['start_time'] . "</td>";
                    echo "<td>" . $event['end_time'] . "</td>";
                    echo "<td>" . $event['location'] . "</td>"; // may want to query the location name from the Locations table using location.
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No public events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
