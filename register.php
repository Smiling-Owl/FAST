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

    if ($user_type == 'student') {
        $table_name = "students";
        $redirect_page = "/FAST/Student/student_dashboard.php";
        $login_page = "/FAST/Student/Main-Student-LogIn/StudentLogIn.html?login_error=1";
    } elseif ($user_type == 'tutor') {
        $table_name = "tutors";
        $redirect_page = "/FAST/Tutors/tutor_dashboard.php";
        $login_page = "/FAST/Tutors/Main-Tutor-Login/TutorLogIn.html?login_error=1";
    } else {
        echo "Invalid user type.";
        exit();
    }

    $sql = "SELECT id, password FROM $table_name WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $user_type;
            header("Location: " . $redirect_page);
        } else {
            header("Location: " . $login_page);
        }
    } else {
        header("Location: " . $login_page);
    }
    exit(); // Ensure script ends after redirection
} finally {
    // Close statement and connection if they were successfully created
    if ($stmt) {
        $stmt->close();
    }
    if ($conn) {
        $conn->close();
    }
}
?>