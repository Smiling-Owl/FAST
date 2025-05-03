<?php
session_start();
ob_start(); // Start output buffering to manage HTML output timing

$message = "";
$messageClass = "";

// Redirect if not logged in

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['subject_to_delete'])) {
    $subject_to_delete = $_POST['subject_to_delete'];

    $conn = new mysqli("localhost", "root", "", "fastdb");
    if ($conn->connect_error) {
        $message = "Connection failed: " . $conn->connect_error;
        $messageClass = "error";
    } else {
        $stmt = $conn->prepare("DELETE FROM tutoring_requests WHERE subject = ?");
        $stmt->bind_param("s", $subject_to_delete);

        if ($stmt->execute()) {
            $message = "All requests for subject '<strong>" . htmlspecialchars($subject_to_delete) . "</strong>' deleted successfully!";
            $messageClass = "success";
        } else {
            $message = "Error deleting requests: " . htmlspecialchars($stmt->error);
            $messageClass = "error";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $message = "Invalid request.";
    $messageClass = "error";
}
ob_end_flush(); // Send the output
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Requests</title>
    <link rel="stylesheet" href="Admin_Styles/process_styles.css">
</head>
<body>
    <div class="response-box">
        <div class="message <?= $messageClass ?>">
            <?= $message ?>
        </div>

        
        <a href="popular_requests.php">Back to Popular Requests</a>
    </div>
</body>
</html>