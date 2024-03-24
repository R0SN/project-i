<?php
if (isset($_POST['submit'])) {
  include_once "../connect.php";
  $uname = $_POST["username"];
  $umail = $_POST["email"];
  $uphone = $_POST["phone"];
  $ulocation = $_POST['location'];
  $upw = $_POST["password"];
  $upwc = $_POST["confirm-password"];
  
  $accCheck = "SELECT * FROM users WHERE email = '$umail' OR phone='$uphone'";
  $result = $con->query($accCheck);
  if ($result->num_rows > 0) {
    echo "Account already exists!";
  } elseif ($upw !== $upwc) {
    echo "The passwords do not match";
  } else if (strlen($name) < 3 || strlen($name) > 20 || !preg_match('/^[a-zA-Z]$/', $name)) {
    echo "Enter a valid name!";
  }else if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format!";
  } else if (!preg_match('/^(98|97)\d{8}/', $uphone)) {
    echo "Enter a valid phone number!!";
  } else if (strlen($ulocation) < 5 || strlen($ulocation)>30) {
    echo "Enter a valid location!!";
  }else if (strlen($upwc) < 6 || !preg_match('/[A-Z]/', $upwc) || !preg_match('/[0-9]/', $upwc)) {
    echo "Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!";
  } else {
    // Hash the password before storing
    $hpw = password_hash($upw,PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, location, password, phone) VALUES ('$uname', '$umail', '$ulocation', '$hpw', '$uphone')";
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
      <input type="text" id="username" name="username" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone Number:</label>
      <input type="number" id="phone" name="phone" required>

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>

      <button type="submit" name="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="signin.php">Sign In</a></p>
  </div>
  <!-- ------------------- SIGN UP FORM ---------------------------- -->


</body>

</html>