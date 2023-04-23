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

if (isset($_POST['confirm_delete'])) {
    // Delete associated ratings for the comment
    $query = "DELETE FROM Ratings WHERE comment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();

    // Delete the comment
    $query = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();

    header("Location: event_details.php?event_id=$event_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Comment</title>
</head>
<body>
    <h1>Delete Comment</h1>

    <p>Are you sure you want to delete this comment?</p>

    <form action="delete_comment.php?comment_id=<?php echo $comment_id; ?>&event_id=<?php echo $event_id; ?>" method="post">
        <input type="submit" name="confirm_delete" value="Yes, Delete">
        <a href="event_details.php?event_id=<?php echo $event_id; ?>">No, Cancel</a>
    </form>
</body>
</html>
