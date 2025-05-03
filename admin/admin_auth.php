<?php
session_start();

function showError($message) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login Error</title>
        <link rel="stylesheet" href="Admin_Styles/process_styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container">
            <div class="message error">
                $message
            </div>
            <div class="back-link">
                <a href="admin_login.php">Back to Login</a>
            </div>
        </div>
    </body>
    </html>
    HTML;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "", "fastdb");

    if ($conn->connect_error) {
        showError("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $role_stmt = $conn->prepare("SELECT r.role_name FROM user_roles ur
                                        INNER JOIN roles r ON ur.role_id = r.role_id
                                        WHERE ur.user_id = ? AND r.role_name = 'admin'");
            $role_stmt->bind_param("i", $user_id);
            $role_stmt->execute();
            $role_stmt->store_result();

            if ($role_stmt->num_rows > 0) {
                $_SESSION['admin_username'] = $db_username;
                $_SESSION['admin_id'] = $user_id;
                $role_stmt->close();
                $stmt->close();
                $conn->close();
                header("Location: admin_dashboard.php");
                exit();
            } else {
                showError("You do not have administrator privileges.");
            }
        } else {
            showError("Invalid username or password.");
        }
    } else {
        showError("Invalid username or password.");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: admin_login.php");
    exit();
}
?>