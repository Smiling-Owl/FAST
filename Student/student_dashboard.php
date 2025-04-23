<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'student') {
    header("Location: Main-Student-LogIn/StudentLogIn.html"); // Redirect if not logged in as student
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Welcome to the Student Dashboard!</h1>
    <p>This is where student-specific content will go.</p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>