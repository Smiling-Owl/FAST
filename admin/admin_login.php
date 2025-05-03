<!DOCTYPE html>
<html>
<head>
<title>FAST Admin Login</title>
<title>Foundation of Ateneo Student Tutors</title>
    <link rel="icon" type="image/x-icon" href="Admin-images/FAST logo white trans.png">
    <link rel="stylesheet" type="text/css" href="../admin/Admin_Styles/admin_login_style.css">
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
</head>


<body>
    <div class="carousel-image">
            <img src="../admin/Admin-images/carousel_1.jpg" alt="Hero Image 1" class="carousel-slide">
            <img src="../admin/Admin-images/carousel_2.jpg" alt="Hero Image 2" class="carousel-slide">
            <img src="../admin/Admin-images/carousel_3.jpg" alt="Hero Image 3" class="carousel-slide">
            <img src="../admin/Admin-images/carousel_4.jpg" alt="Hero Image 4" class="carousel-slide">
    </div>

  <div class="container">
    <div class="logo">
      <img src="Admin-images/LOGIN FAST.png" alt="FAST Logo"> </div>

      <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
    
      <form id="adminloginForm" action="admin_auth.php" method="post">
        <input type="text" id="username" name="username" placeholder="Admin Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
      </form>
    

      <div class="links">
        <a href="../login/login.php">Log in as Student</a>
    </div>
  
    <script src="JS_admin.js"></script>
  </body>

</html>
