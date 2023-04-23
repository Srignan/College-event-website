<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || ($_SESSION['user_level'] != 'student' && $_SESSION['user_level'] != 'admin')) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$error = '';
$success = '';

if (isset($_POST['create_rso'])) {
    $rso_name = $conn->real_escape_string(trim($_POST['rso_name']));
    $rso_description = $conn->real_escape_string(trim($_POST['rso_description']));
    $admin_id = $_SESSION['user_id'];

    // Insert the RSO into the database
    $query = "INSERT INTO rsos (name, description, admin_id) VALUES ('$rso_name', '$rso_description', $admin_id)";
    if ($conn->query($query) === TRUE) {
        $success = "RSO created successfully!";
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
    <title>Create RSO</title>
</head>
<body>
    <h1>Create RSO</h1>

    <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    } elseif (!empty($success)) {
        echo "<p style='color:green'>$success</p>";
    }
    ?>

    <form action="create_rso.php" method="post">
        <label for="rso_name">RSO Name:</label>
        <input type="text" name="rso_name" id="rso_name" required>
        <br>
        <label for="rso_description">Description:</label>
        <textarea name="rso_description" id="rso_description" required></textarea>
        <br>
        <input type="submit" name="create_rso" value="Create RSO">
    </form>
</body>
</html>
