<?php
require_once 'config.inc.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$event_id = $_POST['event_id'];
$user_id = $_SESSION['user_id'];
$content = $_POST['comment'];

if (empty($content)) {
    header("Location: event_details.php?event_id=$event_id&error=empty_comment");
    exit();
}

$query = "INSERT INTO Comments (event_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $event_id, $user_id, $content);

if ($stmt->execute()) {
    header("Location: event_details.php?event_id=$event_id&success=comment_added");
} else {
    header("Location: event_details.php?event_id=$event_id&error=comment_error");
}

$stmt->close();
$conn->close();
?>
