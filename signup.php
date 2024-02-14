<?php
if(isset($_POST['username'])){
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "home_service";

    $con = mysqli_connect($server, $username, $password, $database);

    if (!$con) {
        die("Connection to database failed: ");
    }
  
    $uname = $_POST["username"];
    $umail = $_POST["email"];
    $upw = $_POST["password"];
    $upwc = $_POST["confirm-password"];
    $accCheck = "SELECT * FROM serviceuser WHERE email = '$umail'";
    $result = $con->query($accCheck);
    if($result->num_rows   > 0) {
        echo "Account already exists!";
    } elseif($upw !== $upwc) {
        echo "The passwords do not match";
    } else {
        $sql = "INSERT INTO 'serviceuser' ('username', 'email', 'password') VALUES ('$uname', '$umail', '$upwc')";
        if($con->query($sql) === true) {
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