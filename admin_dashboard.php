<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin</h2>

    <h3>Manage Profiles</h3>
    <ul>
        <li><a href="freelancer_adash.php">Freelancer Profiles</a></li>
        <li><a href="employee_adash.php">Employee Profiles</a></li> <!-- You will create this file similarly -->
    </ul>

    <a href="admin_logout.php">Logout</a>
</body>
</html>
