<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: home.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $server = "localhost";
  $username = "root";
  $password = "";
  $database = "home_service";

  $con = mysqli_connect($server, $username, $password, $database);

  if (!$con) {
    die("Connection to database failed: ");
  }
else{
  $umail = $_POST["email"];
  $upw = $_POST["password"];

  $accCheck = "SELECT * FROM user WHERE email = '$umail'";
  $result = $con->query($accCheck);
  $user = $result->fetch_assoc();

  if ($result->num_rows == 0) {
    echo "Account does not exist!";
  } else {

    if ($upw==$user['password']){
      $_SESSION['user_id'] = $user['id'];
      header("Location: home.html");
    } else {
      echo "Invalid password!";
    }
  }
}
  $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillSprint</title>
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="signin.css">
</head>

<body>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class="logo-container">
      <img src="images/logo/house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.html">Home</a>
    <a href="service.html">Services</a>
    <a href="apply.php">Apply as a Worker</a>
    <a href="signin.php">Sign In</a>
    <a href="signout.php">Sign Out</a>

    <div class="profile-icon">
      <img src="images/profile-user.png" alt="profile" class="profile" style="z-index: 1">
    </div>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <!-- ------------------- SIGN IN FORM ---------------------------- -->
  <div class="signin-container">
    <h1>Sign In</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="emial">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" name="submit">Sign In</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
  </div>
  <!-- ------------------- SIGN IN FORM ---------------------------- -->
  </div>
</body>

</html>