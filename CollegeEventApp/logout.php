<?php
session_start();

// Unset session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the start page (assuming your start page is 'index.php')
header("Location: index.php");
exit();
?>
