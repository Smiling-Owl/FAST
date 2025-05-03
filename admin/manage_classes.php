<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "fastdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending student applications with student username
$sql_applications = "SELECT sa.id AS application_id,
                             sa.fullname,
                             sa.student_id,
                             sa.email,
                             sa.application_date,
                             sa.status,
                             u.username AS student_username
                     FROM student_application sa
                     INNER JOIN users u ON sa.user_id = u.id
                     WHERE sa.status = 'pending'";
$result_applications = $conn->query($sql_applications);

if ($result_applications === false) {
    echo "Error executing query: " . $conn->error;
    die();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - FAST Admin</title>
    <link rel="icon" type="image/x-icon" href="../images/FAST logo white trans.png">
    <link rel="icon" type="image/x-icon" href="/Main-images/FAST logo white trans.png">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="manage_classes.css">
</head>
<body>
    <header>
        <div class="navigation-bar">
            <div id="navigation-container">
                <img src="../Main-images/FAST logo white trans.png" alt="FAST Logo">
                <ul>
                    <li><a href="admin_dashboard.php" aria-label="Admin Dashboard">ADMIN DASHBOARD</a></li>
                    <li><a href="popular_requests.php" aria-label="Popular Requests">POPULAR REQUESTS</a></li>
                    <li><a href="manage_applications.php" aria-label="Manage Applications">MANAGE APPLICATIONS</a></li>
                    <li><a href="manage_tutor_applications.php" aria-label="Manage Tutor Applications">MANAGE TUTOR APPLICATIONS</a></li>
                    <li><a href="manage_classes.php" aria-label="Manage Classes">MANAGE CLASSES</a></li>
                    <li><a href="logout.php">LOG OUT</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>Manage Classes</h1>

        <div class="add-new-class">
            <a href="add_class.php">Add New Class</a>
        </div>

        <div class="class-list">
            <?php
            if ($result_classes && $result_classes->num_rows > 0) {
                while ($row = $result_classes->fetch_assoc()) {
                    echo '<div class="class-item">';
                    echo '<div><strong>Class:</strong> ' . htmlspecialchars($row['class_name']) . '</div>';
                    echo '<div><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</div>';
                    echo '<div><strong>Room:</strong> ' . htmlspecialchars($row['room']) . '</div>';
                    echo '<div><strong>Day:</strong> ' . htmlspecialchars($row['timeslot_day']) . '</div>';
                    echo '<div><strong>Time:</strong> ' . htmlspecialchars(date("h:i A", strtotime($row['timeslot_time']))) . '</div>';
                    echo '<div><strong>Tutor:</strong> ' . htmlspecialchars($row['tutor_name'] ? $row['tutor_name'] : 'Not Assigned') . '</div>';
                    echo '<div><strong>Status:</strong> ' . (htmlspecialchars($row['is_open']) ? 'Open' : 'Closed') . '</div>';
                    echo '<div class="action-buttons">';
                    echo '<a href="edit_class.php?class_id=' . htmlspecialchars($row['class_id']) . '" class="edit-button">Edit</a>';
                    echo '<form method="post" action="process_delete_class.php" style="display:inline;">';
                    echo '<input type="hidden" name="class_id" value="' . htmlspecialchars($row['class_id']) . '">';
                    echo '<button type="submit" class="delete-button" onclick="return confirm(\'Are you sure you want to delete this class?\');">Delete</button>';
                    echo '</form>';
                    echo '</div>';

                    echo '</div>';
                }
            } else {
                echo '<p>No classes available.</p>';
            }
            ?>
        </div>
    </div>
    <div class="carousel-image">
            <img src="../Main-images/carousel_1.jpg" alt="Hero Image 1" class="carousel-slide">
            <img src="../Main-images/carousel_2.jpg" alt="Hero Image 2" class="carousel-slide">
            <img src="../Main-images/carousel_3.jpg" alt="Hero Image 3" class="carousel-slide">
            <img src="../Main-images/carousel_4.jpg" alt="Hero Image 4" class="carousel-slide">
          </div>
          <div class="carousel-overlay"></div>
        <footer>
            <div class="footer-content">
                <p>&copy; <?php echo date("Y"); ?> Foundation of Ateneo Student Tutors - Admin Area</p>
            </div>
        </footer>
        <script src="JS_admin.js"></script>
</body>
</html>

<?php
// Close the database connection
if (isset($conn)) {
    $conn->close();
}
?>