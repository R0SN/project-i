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
  <link rel="stylesheet" href="service.css" />
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
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->


  <div class="main-container">
    <div class="card" onmouseover="showText(this)" onmouseout="hideText(this)">
      <img src="../images/services/f5dd6y9r.bmp" height="400px" alt="Service 2" />
      <div class="service-text">Electrician</div>
    </div>
    <div class="card" onmouseover="showText(this)" onmouseout="hideText(this)">
      <img src="../images/services/interio.jpg" height="400px" alt="Service 3" />
      <div class="service-text">Interior Design</div>
    </div>    
    <div class="card" onmouseover="showText(this)" onmouseout="hideText(this)">
      <img src="../images/services/carpenter.jpg" height="400px" alt="Service 4" />
      <div class="service-text">Carpenter</div>
    </div>
    <div class="card" onmouseover="showText(this)" onmouseout="hideText(this)">
      <img src="../images/services/painting.jpg" height="400px" alt="Service 5" />
      <div class="service-text">Painter</div>
    </div>
    <div class="card" onmouseover="showText(this)" onmouseout="hideText(this)">
      <img src="../images/services/iStock-1341381755-1024x683.jpg" height="400px" alt="Service 6" />
      <div class="service-text">Plumber</div>
    </div>
  </div>

  <script>
    function showText(element) {
      const textElement = element.querySelector('.service-text');
      textElement.style.display = 'block';
    }

    function hideText(element) {
      const textElement = element.querySelector('.service-text');
      textElement.style.display = 'none';
    }
  </script>
</body>

</html>