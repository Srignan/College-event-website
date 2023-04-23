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

if (isset($_POST['leave_rso'])) {
    $rso_id = intval($_POST['rso_id']);
    $user_id = $_SESSION['user_id'];

    // Delete the RSO_Members entry for the user and the RSO
    $query = "DELETE FROM RSO_Members WHERE rso_id = $rso_id AND user_id = $user_id";
    if ($conn->query($query) === TRUE) {
        $success = "You have successfully left the RSO!";
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
    <title>Leave RSO</title>
</head>
<body>
    <h1>Leave RSO</h1>

    <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    } elseif (!empty($success)) {
        echo "<p style='color:green'>$success</p>";
    }
    ?>

    <form action="leave_rso.php" method="post">
        <label for="rso_id">RSO ID:</label>
        <input type="number" name="rso_id" id="rso_id" required>
        <br>
        <input type="submit" name="leave_rso" value="Leave RSO">
    </form>
</body>
</html>
