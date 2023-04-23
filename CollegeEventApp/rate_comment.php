<?php
require_once 'config.inc.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$comment_id = $_POST['comment_id'];
$event_id = $_POST['event_id'];
$user_id = $_SESSION['user_id'];
$rating = $_POST['rating'];

$query = "INSERT INTO Ratings (comment_id, user_id, rating) VALUES (?, ?, ?)
          ON DUPLICATE KEY UPDATE rating = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $comment_id, $user_id, $rating, $rating);

if ($stmt->execute()) {
    header("Location: event_details.php?event_id=$event_id&success=rating_added");
} else {
    header("Location: event_details.php?event_id=$event_id&error=rating_error");
}

$stmt->close();
$conn->close();
?>
