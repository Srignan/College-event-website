<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get event ID from the URL
$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

// Fetch event details from the database
$sql = "SELECT events.* FROM events WHERE events.id = $event_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    header("Location: events.php");
    exit();
}

// Fetch comments for the event
$sql = "SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.event_id = $event_id";
$comment_result = $conn->query($sql);

$comments = array();
if ($comment_result->num_rows > 0) {
    while ($row = $comment_result->fetch_assoc()) {
        $comments[] = $row;
    }
}

$query = "SELECT comment_id, AVG(rating) as average_rating FROM Ratings GROUP BY comment_id";
$result = $conn->query($query);

$ratings = [];
while ($row = $result->fetch_assoc()) {
    $ratings[$row['comment_id']] = round($row['average_rating'], 1);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
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

    <h1><?php echo $event['name']; ?></h1>
    <h2><?php echo $event['category']; ?></h2>
    <p><?php echo $event['description']; ?></p>
    <p>Start Time: <?php echo $event['start_time']; ?></p>
    <p>End Time: <?php echo $event['end_time']; ?></p>
    <p>Location: <?php echo $event['location']; ?></p>
    <p>Contact Phone: <?php echo $event['contact_phone']; ?></p>
    <p>Contact Email: <?php echo $event['contact_email']; ?></p>
    <p>Visibility: <?php echo $event['visibility']; ?></p>
    
    <h2>Comments</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Comment</th>
				<th>Timestamp</th>
				<th>Average Rating</th>
				<th>Actions</th>
            </tr>
        </thead>
        <tbody>
			<?php
			if (!empty($comments)) {
				foreach ($comments as $comment) {
					echo "<tr>";
					echo "<td>" . $comment['username'] . "</td>";
					echo "<td>" . $comment['content'] . "</td>";
					echo "<td>" . $comment['created_at'] . "</td>";
					echo "<td>";
					echo isset($ratings[$comment['id']]) ? $ratings[$comment['id']] : "Not Rated";
					echo "</td>";
					echo "<td>";
					echo "<form action='rate_comment.php' method='POST'>";
					echo "<input type='hidden' name='comment_id' value='" . $comment['id'] . "'>";
					echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
					echo "<select name='rating' required>";
					echo "<option value=''>Rate</option>";
					for ($i = 1; $i <= 5; $i++) {
						echo "<option value='$i'>$i</option>";
					}
					echo "</select>";
					echo "<button type='submit'>Submit</button>";
					echo "</form>";
					echo "</td>";
					if ($_SESSION['user_id'] == $comment['user_id']) {
						echo "<td>";
						echo "<a href='edit_comment.php?comment_id=" . $comment['id'] . "&event_id=" . $event_id . "'>Edit</a> | ";
						echo "<a href='delete_comment.php?comment_id=" . $comment['id'] . "&event_id=" . $event_id . "'>Delete</a>";
						echo "</td>";
					} else {
						echo "<td></td>";
					}
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='5'>No comments yet.</td></tr>";
			}
			?>
		</tbody>
    </table>

    <h2>Add Comment</h2>
    <form action="add_comment.php" method="POST">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <label for="comment">Comment:</label><br>
        <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Add Comment">
    </form>

</body>
</html>

