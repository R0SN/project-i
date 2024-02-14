<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "home_service";

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Connection to database failed: " . mysqli_connect_error());
}

$name = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm-password"];
if($password!==$confirm_password){
echo "the password do not match";
}

$sql = "INSERT INTO serviceuser (name, email, password) VALUES ('$name', '$email', '$password')";

if ($con->query($sql) === true) {
    echo "Account created successfully!";
} else {
    echo "There was an error: " . $con->error;
}

mysqli_close($con); 
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
      <img src="images/logo/house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.html">Home</a>
    <a href="service.html">Services</a>
    <a href="apply.html">Apply as a Worker</a>
    <a href="signin.html">Sign In</a>
    <a href="signout.html">Sign Out</a>

    <div class="profile-icon">
      <img src="images/profile-user.png" alt="profile" class="profile" style="z-index: 1">
    </div>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->

  <!-- ------------------- SIGN UP FORM ---------------------------- -->
  <div class="signup-container">
    <h1>Sign Up</h1>
    <form action="signup.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>

      <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="signin.html">Sign In</a></p>
  </div>
  <!-- ------------------- SIGN UP FORM ---------------------------- -->

</body>

</html>