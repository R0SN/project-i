<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  include "../connect.php";

    $umail = $_POST["email"];
    $upw = $_POST["password"];
    $accCheck = "SELECT * FROM users WHERE email = '$umail'";
    $accCheck1 = "SELECT * FROM workers WHERE email = '$umail'";
    $accCheck2 = "SELECT * FROM admin WHERE email = '$umail'";
    $result = $con->query($accCheck);
    $result1 = $con->query($accCheck1);
    $result2 = $con->query($accCheck2);
    
        $user = $result->fetch_assoc();
        $worker = $result1->fetch_assoc();
        $admin = $result2->fetch_assoc();
        
        if ($result->num_rows == 0 && $result1->num_rows == 0 && $result2->num_rows == 0) {
          echo "Account does not exist!";
        } else {
          if ( password_verify($upw, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../afterLogin/home.php");
            exit(); 
          }
          else if ( password_verify($upw, $worker['password'])) {
            $_SESSION['user_id'] = $worker['id'];
            header("Location: ../afterLogin/home.php");
            exit(); 
          }
          else if (password_verify($upw, $admin['password'])) {
            $_SESSION['user_id'] = $admin['id'];
            header("Location: ../admin/applications.php");
            exit(); 
          } else {
            echo "Invalid password!";
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
      <img src="../images\logo\house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.html">Home</a>
    <a href="service.html">Services</a>
    <a href="apply.php">Apply as a Worker</a>
    <a href="signin.php">Sign In</a>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <!-- ------------------- SIGN IN FORM ---------------------------- -->
  <div class="signin-container">
    <h1>Sign In</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="email">Email:</label>
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
