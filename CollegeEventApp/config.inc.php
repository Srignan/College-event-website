<?php
$dbHost = "localhost"; 
$dbUsername = "Srignan";
$dbPassword = "Finger@101";
$dbName = "college_events";

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check for connection errors and display an error message if necessary
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
