<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$error = '';
$success = '';

// creation logic here
if (isset($_POST['create_event'])) {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $category = $conn->real_escape_string(trim($_POST['category']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $start_time = $conn->real_escape_string(trim($_POST['start_time']));
    $end_time = $conn->real_escape_string(trim($_POST['end_time']));
    $location = $conn->real_escape_string(trim($_POST['location']));
    $contact_phone = $conn->real_escape_string(trim($_POST['contact_phone']));
    $contact_email = $conn->real_escape_string(trim($_POST['contact_email']));
    $visibility = $conn->real_escape_string(trim($_POST['visibility']));
    $rso_id = $conn->real_escape_string(trim($_POST['rso_id']));

    // Insert the event into the database
    $query = "INSERT INTO events (name, category, description, start_time, end_time, location, contact_phone, contact_email, visibility, rso_id) VALUES ('$name', '$category', '$description', '$start_time', '$end_time', '$location', '$contact_phone', '$contact_email', '$visibility', '$rso_id')";
    if ($conn->query($query) === TRUE) {
        $success = "Event created successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
</head>
<body>
    <h1>Create Event</h1>
    
    <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    }
    ?>

    <form action="create_event.php" method="post">
        <label for="name">Event Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="social">Social</option>
            <option value="fundraising">Fundraising</option>
            <option value="tech_talk">Tech Talk</option>
            <option value="sports">Sports</option>
            <option value="academic">Academic</option>
            <option value="cultural">Cultural</option>
            <option value="community service">Community Service</option>
            <option value="art">Art</option>
            <option value="career">Career</option>
            <option value="other">Other</option>
        </select>
        <br>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <br>
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" name="start_time" id="start_time" required>
        <br>
        <label for="end_time">End Time:</label>
        <input type="datetime-local" name="end_time" id="end_time" required>
        <br>
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" required>
        <br>
        <label for="contact_phone">Contact Phone:</label>
        <input type="tel" name="contact_phone" id="contact_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" required>
        <br>
        <label for="contact_email">Contact Email:</label>
        <input type="email" name="contact_email" id="contact_email" required>
        <br>
        <label for="visibility">Visibility:</label>
        <select name="visibility" id="visibility" required>
            <option value="public">Public</option>
            <option value="private">Private</option>
            <option value="RSO">RSO</option>
        </select>
        <br>
        <label for="rso_id">RSO ID:</label>
        <input type="number" name="rso_id" id="rso_id">
        <br>
        <input type="submit" name="create_event" value="Create Event">
    </form>
</body>
</html>

