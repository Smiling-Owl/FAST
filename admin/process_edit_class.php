<?php
session_start();
ob_start(); // Buffer output for proper HTML rendering

$message = "";
$messageClass = "";

// Redirect if not logged in

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $class_id = $_POST['class_id'];
    $class_name = $_POST['class_name'];
    $description = $_POST['description'];
    $room = $_POST['room'];
    $timeslot_day = $_POST['timeslot_day'];
    $timeslot_time = $_POST['timeslot_time'];
    $tutor_id = $_POST['tutor_id'];
    $capacity = $_POST['capacity'];
    $is_open = isset($_POST['is_open']) ? 1 : 0;
    $is_done = isset($_POST['is_done']) ? 1 : 0;

    $conn = new mysqli("localhost", "root", "", "fastdb");
    if ($conn->connect_error) {
        $message = "Connection failed: " . $conn->connect_error;
        $messageClass = "error";
    } else {
        $stmt = $conn->prepare("UPDATE classes SET class_name=?, description=?, room=?, timeslot_day=?, timeslot_time=?, tutor_id=?, capacity=?, is_open=?, is_done=? WHERE class_id=?");
        $stmt->bind_param("sssssiiiii", $class_name, $description, $room, $timeslot_day, $timeslot_time, $tutor_id, $capacity, $is_open, $is_done, $class_id);

        if ($stmt->execute()) {
            // Redirect to manage_classes.php with a success flag
            header("Location: manage_classes.php?edit_success=1");
            exit();
        } else {
            $message = "Error updating class: " . htmlspecialchars($stmt->error);
            $messageClass = "error";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $message = "Invalid request.";
    $messageClass = "error";
}
ob_end_flush(); // Send output
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
    <link rel="stylesheet" href="Admin_Styles/process_styles.css">
</head>
<body>
    <div class="response-box">
        <div class="message <?= $messageClass ?>">
            <?= $message ?>
        </div>

        <div class="back-link">
            <a href="manage_classes.php">Back to Manage Classes</a>
        </div>
    </div>

</body>
</html>
