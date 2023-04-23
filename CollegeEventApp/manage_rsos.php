<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage RSOs</title>
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="events.php">Events</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Manage RSOs</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Admin</th>
                <th>Members</th> <!-- Added table header for members -->
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($rsos)) {
                foreach ($rsos as $rso) {
                    // Fetch members of the RSO
                    $rso_id = $rso['id'];
                    $members_query = "SELECT Users.username FROM Users INNER JOIN rso_members ON Users.id = rso_members.user_id WHERE rso_members.rso_id = '$rso_id'";
                    $members_result = $conn->query($members_query);
                    $members = array();
                    while ($row = $members_result->fetch_assoc()) {
                        $members[] = $row['username'];
                    }
                    $members_str = implode(', ', $members);

                    echo "<tr>";
                    echo "<td>" . $rso['name'] . "</td>";
                    echo "<td>" . $rso['description'] . "</td>";
                    echo "<td>" . $rso['admin_id'] . "</td>"; // may want to query the admin's username from the Users table using admin_id.
                    echo "<td>" . $members_str . "</td>"; // Added table cell for members
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No RSOs found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Create RSO</h2>
    <p><a href="create_rso.php">Create a new RSO</a></p>

    <h2>Join RSO</h2>
    <p><a href="join_rso.php">Join an existing RSO</a></p>
</body>
</html>
