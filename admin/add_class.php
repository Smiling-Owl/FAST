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

// Fetch all approved tutors (joining tutors and tutor_application tables to get fullname)
$sql_tutors = "SELECT
                    t.user_id AS tutor_id,  -- Changed to t.user_id
                    ta.fullname AS tutor_fullname
                FROM tutors t
                INNER JOIN tutor_application ta ON t.user_id = ta.user_id";
$result_tutors = $conn->query($sql_tutors);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add New Class - FAST Admin</title>
  <link rel="icon" type="image/x-icon" href="../Main-images/FAST logo white trans.png" />
  <link rel="stylesheet" href="../admin/Admin_Styles/add_class_style.css">
</head>
<body>
  <header>
    <div class="navigation-bar">
      <div class="logo-container">
        <img src="../Main-images/FAST logo white trans.png" alt="FAST Logo">
      </div>
      <ul>
        <li><a href="admin_dashboard.php">ADMIN DASHBOARD</a></li>
        <li><a href="popular_requests.php">POPULAR REQUESTS</a></li>
        <li><a href="manage_applications.php">MANAGE APPLICATIONS</a></li>
        <li><a href="manage_tutor_applications.php">MANAGE TUTOR APPLICATIONS</a></li>
        <li><a href="manage_classes.php">MANAGE CLASSES</a></li>
        <li><a href="logout.php">LOG OUT</a></li>
      </ul>
    </div>
  </header>

  <div class="carousel-image">
    <img src="Admin-images/carousel_1.jpg" alt="Hero Image 1" class="carousel-slide active">
    <img src="Admin-images/carousel_2.jpg" alt="Hero Image 2" class="carousel-slide">
    <img src="Admin-images/carousel_3.jpg" alt="Hero Image 3" class="carousel-slide">
    <img src="Admin-images/carousel_4.jpg" alt="Hero Image 4" class="carousel-slide">
  </div>

  <div class="container">
    <h1>ADD NEW CLASS</h1>
    <div class="form-container">
      <form method="POST" action="">
        <div class="form-group">
          <label for="class_name">Class Name:</label>
          <input type="text" id="class_name" name="class_name" required>
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
          <label for="room">Room:</label>
          <input type="text" id="room" name="room">
        </div>
        <div class="form-group">
          <label for="timeslot_day">Day:</label>
          <select id="timeslot_day" name="timeslot_day">
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
          </select>
        </div>
        <div class="form-group">
          <label for="timeslot_time">Time:</label>
          <input type="time" id="timeslot_time" name="timeslot_time">
        </div>
        <div class="form-group">
          <label for="tutor_id">Tutor:</label>
          <select id="tutor_id" name="tutor_id" required>
            <option value="">-- Select a Tutor --</option>
            <?php
              if ($result_tutors && $result_tutors->num_rows > 0) {
                while ($row_tutor = $result_tutors->fetch_assoc()) {
                  echo '<option value="' . htmlspecialchars($row_tutor['tutor_id']) . '">' . htmlspecialchars($row_tutor['tutor_fullname']) . '</option>';
                }
              } else {
                echo '<option value="">No approved tutors yet.</option>';
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="capacity">Class Capacity:</label>
          <input type="number" id="capacity" name="capacity" min="1" value="10" required>
        </div>
        <div class="form-group">
          <label for="is_open">Open for Enrollment:</label>
          <input type="checkbox" id="is_open" name="is_open" value="1" checked>
        </div>
        <div class="form-group">
          <button type="submit">Add Class</button>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <div class="footer-content">
      <p>&copy; <?php echo date("Y"); ?> Foundation of Ateneo Student Tutors - Admin Area</p>
    </div>
  </footer>

  <script src="../admin/JS_admin.js"></script>
</body>
</html>

<?php
// Close the database connection
if (isset($conn)) {
    $conn->close();
}
?>
