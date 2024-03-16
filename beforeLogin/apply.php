<?php
if (isset($_POST['submit'])) {
  include_once "../connect.php";

  $wname = $_POST["name"];
  $wmail = $_POST["email"];
  $wphone = $_POST["phone"];
  $wskill = $_POST["skills"];
  $wphoto = $_POST["photo"];
  $wc = $_POST["certificate"];
  $accCheck = "SELECT * FROM applications WHERE email = '$wmail' OR phone='$wphone'";
  $result = $con->query($accCheck);
  if ($result->num_rows > 0) {
    echo "Account already exists!";
  } else if (strlen($wname) < 3) {
    echo "Enter a valid name!";
  } else if (!preg_match('/^(98|97)\d{8}$/', $wphone)) {
    echo "Enter a valid phone number!!";
  } else {
    $sql = "INSERT INTO applications (name,phone,email,skill,photo,certificate) VALUES ('$wname', '$wphone', '$wmail', '$wskill','$wphoto','$wc')";
    if ($con->query($sql) === true) {
      echo "Success";
    } else {
      echo "Failure: ";
    }
  }
  $con->close();
}
?>


<!-- backend backend backend backend backend backend backend backend backend backend backend backend backend backend backend backend  -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillSprint</title>
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="apply.css" />
</head>

<body>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class="logo-container">
      <img src="../images/logo/house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.html">Home</a>
    <a href="service.html">Services</a>
    <a href="apply.php">Apply as a Worker</a>
    <a href="signin.php">Sign In</a>
    <a href="signout.php">Sign Out</a>

    <div class="profile-icon">
      <img src="../images/profile-user.png" alt="profile" class="profile" style="z-index: 1">
    </div>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->

  <div class="apply-container">
    <h1>Apply as Skill Worker</h1>
    <form action="apply.php" method="post">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone Number:</label>
      <input type="number" id="phone" name="phone" required>

      <label for="skills">Skills:</label>
      <input type="text" id="skills" name="skills" required>

      <label for="photo">Upload Photo:</label>
      <input type="file" id="photo" name="photo" accept=".jpg, .jpeg" required>

      <label for="certificate">Upload Certificate:</label>
      <input type="file" id="certificate" name="certificate" accept=".pdf, .doc, .docx,.png, .jpg, .jpeg" required>

      <button type="submit" name="submit" onmouseover="change(this)" onmouseout="unchange(this)">Submit Application</button>
    </form>
  </div>

  <script>
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