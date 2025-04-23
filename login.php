<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = null;
$stmt = null;

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if (empty($username) || empty($password) || empty($user_type)) {
        echo "All fields are required.";
        exit();
    }

    if (strlen($username) < 3 || strlen($username) > 50) {
        echo "Username must be between 3 and 50 characters.";
        exit();
    }

    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        echo "Invalid username format. Only alphanumeric characters are allowed.";
        exit();
    }

    $table_name = '';
    $redirect_page = '';
    $login_page = '';

    if ($user_type === 'student') {
        $table_name = "students";
        $redirect_page = "/FAST/Student/student_dashboard.php";
        $login_page = "/FAST/Student/Main-Student-LogIn/StudentLogIn.html?login_error=1";
    } elseif ($user_type === 'tutor') {
        $table_name = "tutors";
        $redirect_page = "/FAST/Tutors/tutor_dashboard.php";
        $login_page = "/FAST/Tutors/Main-Tutor-Login/TutorLogIn.html?login_error=1";
    } else {
        error_log("Invalid user_type: " . $user_type . " from IP: " . $_SERVER['REMOTE_ADDR']);
        echo "Invalid login attempt.";
        exit();
    }

    $sql = "SELECT id, password FROM $table_name WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        echo "Database error. Please try again later.";
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $user_type;
            session_regenerate_id(true);
            header("Location: " . $redirect_page);
            exit();
        } else {
            error_log("Invalid password for user: " . $username . " from IP: " . $_SERVER['REMOTE_ADDR']);
            header("Location: " . $login_page);
            exit();
        }
    } else {
        error_log("Username not found: " . $username . " from IP: " . $_SERVER['REMOTE_ADDR']);
        header("Location: " . $login_page);
        exit();
    }

} finally {
    if ($stmt) {
        $stmt->close();
    }
    if ($conn) {
        $conn->close();
    }
}
?>