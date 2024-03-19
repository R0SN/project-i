<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillSprint</title>
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="home.css" />
</head>

<body>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class="logo-container">
      <img src="../images\logo\house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.php" class="hovers">Home</a>
    <a href="service.php" class="hovers">Services</a>
    <a href="signout.php" class="hovers">Sign Out</a>

    <div class="profile-icon">
      <a href="profile.php"> <img src="../images/profile-user.png" alt="profile" class="profile" style="z-index: 1" />
      </a>
    </div>
  </nav>
  <!-- ------------------- NAVIGATION BAR -----------------
     -->

  <img src="../images/homeImages/david-pisnoy-46juD4zY1XA-unsplash.jpg" class="img1" height="400px" />
  <img src="../images/homeImages/frames-for-your-heart-iOLHAIaxpDA-unsplash.jpg" class="img2" height="400px" />
  <img src="../images/homeImages/spacejoy-h2_3dL9yLpU-unsplash.jpg" class="img3" height="500px" />
  <img src="../images/homeImages/valentin-petkov-z06oDT-8pKQ-unsplash.jpg" class="img4" height="300px" />

  <center>
    <div class="container">
      <h1>Welcome to SkillSprint</h1>
      <p>Find reliable and skilled workers for your home services.</p>
      <p>
        Whether you need plumbing, electrical work, or other services,
        SkillSprint connects you with qualified professionals.
      </p>
      <button onclick="goToPage()" onmouseover="change(this)" onmouseout="unchange(this)">
        Book Now
      </button>
    </div>
  </center>

  <script>
    function goToPage() {
      var destinationPage = "service.html";
      window.location.href = destinationPage;
    }

    function change(element) {
      element.style.backgroundColor = "white";
      element.style.color = "#333";
    }

    function unchange(element) {
      element.style.backgroundColor = "#333";
      element.style.color = "white";
    }
  </script>
</body>

</html>