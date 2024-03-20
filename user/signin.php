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

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($upw, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['semail'] = $user['email'];
            header("Location:home.php");
            exit();
        }
    } elseif ($result1 && $result1->num_rows > 0) {
        $worker = $result1->fetch_assoc();
        if (password_verify($upw, $worker['password'])) {
            $_SESSION['user_id'] = $worker['id'];
            $_SESSION['semail'] = $worker['email'];
            header("Location:home.php");
            exit();
        }
    } elseif ($result2 && $result2->num_rows > 0) {
        $admin = $result2->fetch_assoc();
        if (password_verify($upw, $admin['password'])) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['semail'] = $admin['email'];
            header("Location: ../admin/applications.php");
            exit();
        }
    }

    // If none of the conditions above are met, it means the email or password is invalid
    echo "Invalid email or password!";

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
    <a href="home.php" class='hovers'>Home</a>
    <a href="service.php" class='hovers'>Services</a>
    <a href="apply.php" class='hovers'>Apply as a Worker</a>
    <a href="signin.php" class='hovers'>Sign In</a>
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
