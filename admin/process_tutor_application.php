<?php
session_start();
ob_start();

$message = "";
$messageClass = "";

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    $message = "Access denied. Admin login required.";
    $messageClass = "error";
} elseif (isset($_POST['application_id']) && isset($_POST['action'])) {
    $applicationId = $_POST['application_id'];
    $action = $_POST['action'];

    $conn = new mysqli("localhost", "root", "", "fastdb");

    if ($conn->connect_error) {
        http_response_code(500);
        $message = "Database connection failed: " . $conn->connect_error;
        $messageClass = "error";
    } else {
        if ($action === 'approve') {
            // Get user_id from tutor_application
            $stmt_select_user = $conn->prepare("SELECT user_id FROM tutor_application WHERE id = ?");
            $stmt_select_user->bind_param("i", $applicationId);
            $stmt_select_user->execute();
            $result_user = $stmt_select_user->get_result();

            if ($result_user->num_rows === 1) {
                $row_user = $result_user->fetch_assoc();
                $tutor_user_id = $row_user['user_id'];

                // Insert into tutors table
                $stmt_insert_tutor = $conn->prepare("INSERT INTO tutors (user_id) VALUES (?)");
                $stmt_insert_tutor->bind_param("i", $tutor_user_id);

                if ($stmt_insert_tutor->execute()) {
                    // Update application status
                    $stmt_update_application = $conn->prepare("UPDATE tutor_application SET status = 'approved' WHERE id = ?");
                    $stmt_update_application->bind_param("i", $applicationId);
                    $stmt_update_application->execute();

                    $message = "Tutor application approved and added to tutors.";
                    $messageClass = "success";
                    $stmt_update_application->close();
                } else {
                    http_response_code(500);
                    $message = "Error adding tutor: " . $stmt_insert_tutor->error;
                    $messageClass = "error";
                }

                $stmt_insert_tutor->close();
            } else {
                http_response_code(404);
                $message = "Tutor application not found.";
                $messageClass = "error";
            }

            $stmt_select_user->close();

        } elseif ($action === 'reject') {
            $stmt_update_application = $conn->prepare("UPDATE tutor_application SET status = 'rejected' WHERE id = ?");
            $stmt_update_application->bind_param("i", $applicationId);

            if ($stmt_update_application->execute()) {
                $message = "Tutor application rejected.";
                $messageClass = "success";
            } else {
                http_response_code(500);
                $message = "Error rejecting application: " . $stmt_update_application->error;
                $messageClass = "error";
            }

            $stmt_update_application->close();
        } else {
            http_response_code(400);
            $message = "Invalid action.";
            $messageClass = "error";
        }

        $conn->close();
    }
} else {
    http_response_code(400);
    $message = "Application ID or action not provided.";
    $messageClass = "error";
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Processing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin_Styles/process_styles.css">
</head>
<body>
    <div class="response-box">
        <div class="message <?= $messageClass ?>">
            <?= $message ?>
        </div>

        <div class="back-link">
        <a href="manage_tutor_applications.php">Back to Tutor Applications</a>
        </div>
    </div>
</body>
</html>