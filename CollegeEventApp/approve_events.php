<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in and is a super admin
if (!isset($_SESSION['username']) || $_SESSION['user_level'] != 'super_admin') {
    header("Location: login.php");
    exit();
}

// Fetch events that need approval
$events = array();
$query = "SELECT * FROM events WHERE is_approved = 0 AND visibility = 'public'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Approve event
if (isset($_POST['approve_event']) && isset($_POST['event_id'])) {
    $event_id = $conn->real_escape_string(trim($_POST['event_id']));
    $query = "UPDATE events SET is_approved = 1 WHERE id = '$event_id'";
    if ($conn->query($query) === TRUE) {
        // Refresh the page to show updated events list
        header("Location: approve_events.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Events</title>
</head>
<body>

	<nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="events.php">Events</a>
        <a href="logout.php">Logout</a>
    </nav>
	
    <h1>Approve Public Events</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($events)) {
                foreach ($events as $event) {
                    echo "<tr>";
                    echo "<td>" . $event['id'] . "</td>";
                    echo "<td>" . $event['name'] . "</td>";
                    echo "<td>" . $event['description'] . "</td>";
                    echo '<td>
                        <form action="approve_events.php" method="post">
                            <input type="hidden" name="event_id" value="' . $event['id'] . '">
                            <input type="submit" name="approve_event" value="Approve">
                        </form>
                    </td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No events need approval.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
