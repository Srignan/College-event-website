<?php
require_once 'config.inc.php';

// Initialize variables
$error = '';

// login logic here
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));

    // Check if the user exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
			// Successful login, start a session
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['user_level'] = $row['user_level'];
			$_SESSION['university_id'] = $row['university_id']; // Add this line
			header("Location: dashboard.php");
			exit();
        } else {
            $error = 'Incorrect password.';
        }
    } else {
        $error = 'User not found.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    
    <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    }
    ?>

    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
