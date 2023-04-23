<?php
require_once 'config.inc.php';

// Initialize variables
$error = '';
$success = '';

//registration logic here
if (isset($_POST['register'])) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $user_level = $conn->real_escape_string(trim($_POST['user_level']));
    
    // Check if the username and email are unique
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $error = 'Username or email already exists.';
    } else {
        // Insert the new user into the database
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password, user_level) VALUES ('$username', '$email', '$password_hash', '$user_level')";
        
        if ($conn->query($query) === TRUE) {
            $success = 'Registration successful! You can now log in.';
        } else {
            $error = 'Error: ' . $conn->error;
        }
    }
}

// HTML and PHP code
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    
    <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    }
    if (!empty($success)) {
        echo "<p style='color:green'>$success</p>";
    }
    ?>

    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="user_level">User Level:</label>
        <select name="user_level" id="user_level" required>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
            <option value="super_admin">Super Admin</option>
        </select>
        <br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
