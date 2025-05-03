<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../admin/Admin-images/FAST logo white trans.png">
    <link rel="stylesheet" href="../admin/Admin_Styles/admin_dashboard_style.css">
</head>

<body>
    <header>
      <div class="navigation_bar">
        <img src="../admin/Admin-images/FAST logo white trans.png" alt="FAST Logo">
      
        <div class="nav_menu_wrapper">
          <ul>
            <li><a href="admin_dashboard.php">ADMIN DASHBOARD</a></li>
            <li><a href="popular_requests.php">POPULAR REQUESTS</a></li>
            <li><a href="manage_applications.php">MANAGE APPLICATIONS</a></li>
            <li><a href="manage_tutor_applications.php">MANAGE TUTOR APPLICATIONS</a></li>
            <li><a href="manage_classes.php">MANAGE CLASSES</a></li>
            <li><a href="logout.php">LOG OUT</a></li>
          </ul>
        </div>
      </div>
    </header>
    
  <div class="carousel-image">
    <img src="Admin-images/carousel_1.jpg" alt="Hero Image 1" class="carousel-slide active">
    <img src="Admin-images/carousel_2.jpg" alt="Hero Image 2" class="carousel-slide">
    <img src="Admin-images/carousel_3.jpg" alt="Hero Image 3" class="carousel-slide">
    <img src="Admin-images/carousel_4.jpg" alt="Hero Image 4" class="carousel-slide">
  </div>

    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($admin_username); ?>!</h1>

        <div class="dashboard-widgets">
            <div class="widget">
                <h3>Pending Student Applications</h3>
                <p><?php echo htmlspecialchars($pending_applications); ?></p>
            </div>
            <div class="widget">
                <h3>Open Classes</h3>
                <p><?php echo htmlspecialchars($open_classes); ?></p>
            </div>
            <div class="widget">
                <h3>Pending Join Requests</h3>
                <p><?php echo htmlspecialchars($pending_requests); ?></p>
            </div>
            <div class="widget">
                <h3>Total Users</h3>
                <p><?php echo htmlspecialchars($total_users); ?></p>
            </div>
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
