<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Action</title>
    <link rel="stylesheet" href="Admin_Styles/process_styles.css">
</head>
<body>

    <div class="response-box">
        <?php

        if (!isset($_SESSION['admin_id'])) {
            http_response_code(403);
            echo "<p class='error'>Access denied.</p>";
            exit();
        }

        if (!isset($_POST['application_id'], $_POST['action'])) {
            http_response_code(400);
            echo "<p class='error'>Application ID or action not provided.</p>";
            exit();
        }

        $applicationId = $_POST['application_id'];
        $action = $_POST['action'];

        $conn = new mysqli("localhost", "root", "", "fastdb");

        if ($conn->connect_error) {
            http_response_code(500);
            echo "<p class='error'>Database connection failed: " . htmlspecialchars($conn->connect_error) . "</p>";
            exit();
        }

        $validActions = ['approve' => 'approved', 'reject' => 'rejected'];

        if (!array_key_exists($action, $validActions)) {
            http_response_code(400);
            echo "<p class='error'>Invalid action.</p>";
            $conn->close();
            exit();
        }

        $newStatus = $validActions[$action];

        $sql = "UPDATE student_application SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            http_response_code(500);
            echo "<p class='error'>Preparation failed: " . htmlspecialchars($conn->error) . "</p>";
            $conn->close();
            exit();
        }

        $stmt->bind_param("si", $newStatus, $applicationId);

        if ($stmt->execute()) {
            echo "<p class='success'>Application " . htmlspecialchars($action) . " successfully.</p>";
        } else {
            http_response_code(500);
            echo "<p class='error'>Error updating application status: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>

</body>
</html>