<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skill workers</title>
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="service.css" />
</head>

<body>
<?php
include "../connect.php";
if (!isset($_SESSION['user_id'])) {
  echo "
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class='logo-container'>
      <img src='../images\logo\house-cleaning.png' alt='SkillSprint Logo' class='logo' style='z-index: 1' />
    </div>
    <a href='home.php' class='hovers'>Home</a>
    <a href='service.php' class='hovers'>Services</a>
    <a href='apply.php' class='hovers'>Apply as a Worker</a>
    <a href='signin.php' class='hovers'>Sign In</a>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->";
} 
else {
  echo "
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class='logo-container'>
      <img src='../images\logo\house-cleaning.png' alt='SkillSprint Logo' class='logo' style='z-index: 1' />
    </div>
    <a href='home.php' class='hovers'>Home</a>
    <a href='service.php' class='hovers'>Services</a>
    <a href='signout.php' class='hovers'>Sign Out</a>

    <div class='profile-icon'>
      <a href='profile.php'> <img src='../images/profile-user.png' alt='profile' class='profile' style='z-index: 1' />
      </a>
    </div>
  </nav>
  <!-- ------------------- NAVIGATION BAR ------------------------------>";
}

 ?>
  <div class="main">
    <?php
    include "../connect.php";
    $query = "SELECT * FROM workers";
    $result = mysqli_query($con, $query);


    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $photoPath = "../images/workers/photo/{$row['photo']}";
        $name = $row['name'];
        $phone = $row['phone'];
        $skill = $row['skill'];
        $sarea = $row['service_area'];
        $id = $row['id'];


        echo "<div class='card'>
        <center>
          <div class='image'><img src='$photoPath'></div>
        </center>
        <div class='content'>
          Name: $name<br>
          Skill: $skill<br>
          Service Area: $sarea<br>";
          
      if (!isset($_SESSION['user_id'])) {
        echo "
        <a href='signin.php'><button type='submit' name='about'>more</button></a>
        </div>
      </div>";
      } else {
        $sid = $_SESSION['user_id'];
        $semail = $_SESSION['semail'];
        $check = "SELECT * FROM users WHERE id=$sid AND email='$semail'";
        $qry = $con->query($check);
        if(mysqli_num_rows($qry)>0){
          echo "<a href='aboutWorker.php'><form action='aboutWorker.php' method='post'>
          <input type='hidden' name='id' value='$id'>
         <button type='submit' name='about'>more</button>
        </form></a>
          </div>
        </div>";
        }
        else{
          echo "
       <button type='submit' name='about'>more</button>
        </div>
      </div>";
        }
      }
    }
  }
     else {
      // No data found in the database
      echo "No workers found";  
    }

    // Close the database connection
    mysqli_close($con);
    ?>
  </div>
</body>

</html>