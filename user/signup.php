<?php
if (isset($_POST['submit'])) {
  include "../connect.php";
  $uname = $_POST["username"];
  $umail = $_POST["email"];
  $uphone = $_POST["phone"];
  $ulocation = $_POST['location'];
  $upw = $_POST["password"];
  $upwc = $_POST["confirm-password"];

  $accCheck = "SELECT * FROM users WHERE email = '$umail' OR phone='$uphone'";
  $result = $con->query($accCheck);
  if (empty($uname) || empty($umail) || empty($uphone) || empty($ulocation) || empty($upw) || empty($upwc)) {
    echo "<span class='err'>One or more required fields are empty. Please fill in all the fields. </span>";
  } else {
    if ($result->num_rows > 0) {
      echo "<span class='err'>Account already exists on given email or phone number!!</span>";
    } else if (strlen($uname) < 3 || strlen($uname) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $uname)) {
      echo "<span class='err'>Enter a valid name!  </span>";
    } else if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $umail)) {
      echo "<span class='err'>Invalid email format!  </span>";
    } else if (!preg_match('/^(98|97)\d{8}/', $uphone)) {
      echo "<span class='err'>Enter a valid phone number!!  </span>";
    } else if (strlen($ulocation) < 5 || strlen($ulocation) > 30) {
      echo "<span class='err'>Enter a valid location!!  </span>";
    } else if (strlen($upwc) < 6 || !preg_match('/[A-Z]/', $upwc) || !preg_match('/[0-9]/', $upwc)) {
      echo "<span class='err'>Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!  </span>";
    } else if ($upw != $upwc) {
      echo "<span class='err'>The password and confirm password fields do not match. Please make sure they are the same.</span>";
    } else {
      // Hash the password before storing
      $hpw = password_hash($upw, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (username, email, location, password, phone) VALUES ('$uname', '$umail', '$ulocation', '$hpw', '$uphone')";
      if ($con->query($sql) === true) {
        echo "Success";
        header("refresh:1,url='signin.php'");
      } else {
        echo "Failure: ";
      }

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
  <title>SkillSprint - Sign Up</title>
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="signup.css" />
</head>

<body>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class="logo-container">
      <img src="../images\logo\house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.php" class='hovers'>Home</a>
    <a href="service.php" class='hovers'>Services</a>
    <a href="apply.php" class='hovers'>Apply as a Worker</a>
    <a href="signin.php" class='hovers'>Sign In</a>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <!-- ------------------- SIGN UP FORM ---------------------------- -->
  <div class="signup-container">
    <h1>Sign Up</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">

      <label for="phone">Phone Number:</label>
      <input type="number" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" value="<?php echo isset($_POST['location']) ? $_POST['location'] : ''; ?>">

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" value="<?php echo isset($_POST['confirm-password']) ? $_POST['confirm-password'] : ''; ?>">

      <button type="submit" name="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="signin.php">Sign In</a></p>
  </div>
  <!-- ------------------- SIGN UP FORM ---------------------------- -->


</body>

</html>