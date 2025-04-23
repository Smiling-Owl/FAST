<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student's Application Page</title>
    <link rel="icon" type="image/x-icon" href="/Main-images/FAST logo white trans.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Student-application.css">
</head>
<body>

    <div class="Coloryey"></div>
    
    <div class="carousel-image">
        <img src="Main-Images/carousel_1.jpg" alt="Hero Image 1" class="carousel-slide">
        <img src="Main-Images/carousel_2.jpg" alt="Hero Image 2" class="carousel-slide">
        <img src="Main-Images/carousel_3.jpg" alt="Hero Image 3" class="carousel-slide">
    </div>

    <div class="Form_Contents">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = new mysqli("localhost", "root", "", "user");

            if ($conn->connect_error) {
                die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
            }

            $fullname = $_POST['fullname'];
            $student_id = $_POST['student_id'];
            $birthdate = $_POST['birthdate'];
            $email = $_POST['email'];
            $contact_number = $_POST['contact_number'];
            $year_course = $_POST['year_course'];
            $fb_link = $_POST['fb_link'];
            $course_tutored = $_POST['course_tutored'];
            $topics = $_POST['topics'];

            $stmt = $conn->prepare("INSERT INTO student_application (fullname, student_id, birthdate, email, contact_number, year_course, fb_link, course_tutored, topics) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $fullname, $student_id, $birthdate, $email, $contact_number, $year_course, $fb_link, $course_tutored, $topics);

            if ($stmt->execute()) {
                echo "<p style='color:green; text-align:center;'>Application submitted successfully!</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <form method="POST" action="">
            <h2>STUDENT'S APPLICATION FORM</h2>

            <div class="Form_Info">
                <label>Full Name:</label>
                <input type="text" name="fullname" required>
            </div>

            <div class="Form_Info">
                <label>Student ID Number:</label>
                <input type="text" name="student_id" required>
            </div>

            <div class="Form_Info">
                <label>Birthdate:</label>
                <input type="date" name="birthdate" required>
            </div>

            <div class="Form_Info">
                <label>Email Address:</label>
                <input type="email" name="email" required>
            </div>

            <div class="Form_Info">
                <label>Contact Number:</label>
                <input type="tel" name="contact_number" required>
            </div>

            <div class="Form_Info">
                <label>Year & Course:</label>
                <input type="text" name="year_course" required>
            </div>

            <div class="Form_Info">
                <label>FB Account Link (for chat):</label>
                <input type="url" name="fb_link" placeholder="https://facebook.com/yourprofile" required>
            </div>

            <div class="Form_Info">
                <label>Course/Subject Being Tutored:</label>
                <input type="text" name="course_tutored" required>
            </div>

            <div class="Form_Info">
                <label>Specific Topics or Concepts Student is Struggling With:</label>
                <textarea name="topics" rows="4" required></textarea>
            </div>

            <button type="submit">Submit Application</button>
        </form>
    </div>

    <script src="Student-application.js"></script>
</body>
</html>
