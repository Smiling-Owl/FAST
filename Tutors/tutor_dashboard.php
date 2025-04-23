<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'tutor') {
    header("Location: Main-Tutor-Login/TutorLogIn.html"); // Redirect if not logged in as tutor
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Dashboard</title>
</head>
<body>
    <h1>Welcome to the Tutor Dashboard!</h1>
    <p>This is where tutor-specific content will go.</p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>