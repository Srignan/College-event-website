<?php
require_once 'config.inc.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$comment_id = intval($_GET['comment_id']);
$event_id = intval($_GET['event_id']);

if (isset($_POST['update_comment'])) {
    $comment = $conn->real_escape_string(trim($_POST['comment']));
    $rating = intval($_POST['rating']);

    $query = "UPDATE comments SET content = '$comment' WHERE id = '$comment_id'";
    $conn->query($query);
    header("Location: event_details.php?event_id=$event_id");
    exit();
}

$query = "SELECT * FROM comments WHERE id = '$comment_id'";
$result = $conn->query($query);
$comment_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
</head>
<body>
    <h1>Edit Comment</h1>

    <form action="edit_comment.php?comment_id=<?php echo $comment_id; ?>&event_id=<?php echo $event_id; ?>" method="post">
		<label for="comment">Comment:</label>
		<textarea name="comment" id="comment" required><?php echo $comment_data['content']; ?></textarea>
		<input type="submit" name="update_comment" value="Update">
	</form>
</body>
</html>
