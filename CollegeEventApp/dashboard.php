<?php
require_once 'config.inc.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
	<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        nav {
            background-color: #333;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: #fff;
            margin: 0 5px;
            text-decoration: none;
            font-size: 1.1em;
        }

        nav a:hover {
            background-color: #555;
            padding: 5px 10px;
            border-radius: 5px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            color: #555;
        }

        .dashboard-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .dashboard-link {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            font-size: 1.2em;
        }

        .dashboard-link:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="events.php">Events</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

    <?php
    if ($_SESSION['user_level'] == 'super_admin') {
        // Super admin content
        echo "<h2>Super Admin Dashboard</h2>";
        echo '<a href="create_university.php">Create University</a><br>';
        echo '<a href="approve_events.php">Approve Events</a><br>';
        // Add more links to manage universities, approve events, etc.
    } elseif ($_SESSION['user_level'] == 'admin') {
        // Admin content
        echo "<h2>Admin Dashboard</h2>";
        echo '<a href="create_event.php">Create Event</a><br>';
        echo '<a href="manage_rsos.php">Manage RSOs</a><br>';
        echo '<a href="event_details.php">Event Details</a><br>'; // Added event_details link
        // Add more links to create events, manage RSOs, etc.
    } else {
        // Student content
        echo "<h2>Student Dashboard</h2>";
        echo '<a href="event_details.php">Event Details</a><br>'; // Added event_details link
        echo '<a href="join_rso.php">Join an RSO</a><br>';
        echo '<a href="request_create_rso.php">Request to Create an RSO</a><br>';
        // Add more links to view events, join RSOs, etc.
    }
    ?>

</body>
</html>
