<?php
session_start();
ob_start(); // Start output buffering so we can output HTML later

$message = "";
$messageClass = "";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];

    $conn = new mysqli("localhost", "root", "", "fastdb");
    if ($conn->connect_error) {
        $message = "Connection failed: " . $conn->connect_error;
        $messageClass = "error";
    } else {
        $stmt = $conn->prepare("DELETE FROM classes WHERE class_id = ?");
        $stmt->bind_param("i", $class_id);

        if ($stmt->execute()) {
            $message = "Class deleted successfully!";
            $messageClass = "success";
        } else {
            $message = "Error deleting class: " . htmlspecialchars($stmt->error);
            $messageClass = "error";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $message = "Invalid request.";
    $messageClass = "error";
}
ob_end_flush(); // Output everything after buffering
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Class</title>
    <link rel="stylesheet" href="Admin_Styles/process_styles.css">
</head>
<body>
    <div class="response-box">
        <div class="message <?= $messageClass ?>">
            <?= $message ?>
        </div>
        <a href="manage_classes.php">Back to Manage Classes</a>
    </div>
</body>
</html>