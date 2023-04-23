<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in and is a student or admin
if (!isset($_SESSION['username']) || ($_SESSION['user_level'] != 'student' && $_SESSION['user_level'] != 'admin')) {
    header("Location: login.php");
    exit();
}

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
$success = '';

// RSO joining logic here
if (isset($_POST['join_rso'])) {
    $rso_id = $conn->real_escape_string(trim($_POST['rso_id']));
    $user_id = $_SESSION['user_id'];

    // Get RSO name for the success message
    $rso_name_query = "SELECT name FROM rsos WHERE id = '$rso_id'";
    $rso_name_result = $conn->query($rso_name_query);
    $rso_name = $rso_name_result->fetch_assoc()['name'];

    // Check if the user is already a member of the RSO
    $check_membership_query = "SELECT * FROM rso_members WHERE rso_id = '$rso_id' AND user_id = '$user_id'";
    $check_membership_result = $conn->query($check_membership_query);

    if ($check_membership_result->num_rows == 0) {
        // Insert the user into the RSO membership table
        $query = "INSERT INTO rso_members (rso_id, user_id) VALUES ('$rso_id', '$user_id')";
        if ($conn->query($query) === TRUE) {
            $success = "Thank you for joining " . $rso_name . "!";
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "You are already a member of this RSO.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... -->
</head>
<body>
    <h1>Join RSO</h1>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="events.php">Events</a>
        <a href="logout.php">Logout</a>
    </nav>
		
    <form action="join_rso.php" method="post">
        <label for="rso_id">RSO:</label>
        <select name="rso_id" id="rso_id" required>
            <?php
            // Fetch all RSOs from the database and display them in the dropdown
            $query = "SELECT * FROM rsos";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No RSOs found</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" name="join_rso" value="Join RSO">
    </form>
</body>
</html>
