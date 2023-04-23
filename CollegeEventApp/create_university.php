<?php
require_once 'config.inc.php';

session_start();

// Check if the user is logged in and is a super admin
if (!isset($_SESSION['username']) || $_SESSION['user_level'] != 'super_admin') {
    header("Location: login.php");
    exit();
}

// Initialize variables
$error = '';
$success = '';

// University creation logic here
if (isset($_POST['create_university'])) {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $location = $conn->real_escape_string(trim($_POST['location']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $num_students = $conn->real_escape_string(trim($_POST['num_students']));

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $error = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (5MB limit)
    if ($_FILES["picture"]["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error = "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload the file
    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            // Insert the university into the database
            $query = "INSERT INTO universities (name, location, description, num_students, picture) VALUES ('$name', '$location', '$description', '$num_students', '$target_file')";
            if ($conn->query($query) === TRUE) {
                $success = "University created successfully!";
            } else {
                $error = "Error: " . $conn->error;
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create University</title>
</head>
<body>
    <h1>Create University</h1>

        <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    }
    if (!empty($success)) {
        echo "<p style='color:green'>$success</p>";
    }
    ?>

    <form action="create_university.php" method="post" enctype="multipart/form-data">
        <label for="name">University Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <br>
        <label for="num_students">Number of Students:</label>
        <input type="number" name="num_students" id="num_students" required>
        <br>
        <label for="picture">Picture:</label>
        <input type="file" name="picture" id="picture">
        <br>
        <input type="submit" name="create_university" value="Create University">
    </form>
</body>
</html>
