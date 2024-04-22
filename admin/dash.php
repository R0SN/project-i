<?php
session_start();
include "../connect.php";

$currentDateTime = date("Y-m-d H:i:s"); // Current time
// Calculate the time 3 hours ago
$threeHoursAgo = date("Y-m-d H:i:s", strtotime("-3 hours"));
$delBook = "DELETE FROM bookings WHERE dateTime < '$threeHoursAgo'";
mysqli_query($con, $delBook);


$qry1 = "SELECT * FROM users";
$qry2 = "SELECT * FROM workers";
$qry3 = "SELECT * FROM applications";
$res1 = mysqli_query($con, $qry1);
$res2 = mysqli_query($con, $qry2);
$res3 = mysqli_query($con, $qry3);
$totalUsers = mysqli_num_rows($res1);
$totalWorkers = mysqli_num_rows($res2);
$totalApplications = mysqli_num_rows($res3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin(SkillSprint)</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">

</head>

<body>
<button class="lbtn">Sign Out</button>
    <center> 
    <img src="../images/logo/house-cleaning.png" alt="logo" height="250">
    </center>
    <div class="container">
        <h1>Welcome to Home Service Booking Admin Dashboard</h1>
        <div class="stats-container">
            <div class="stat">
                <h2>Total Users</h2>
                <p id="totalUsers"><?php echo $totalUsers ?></p>
            </div>
            <div class="stat">
                <h2>Total Applications</h2>
                <p id="totalApplications"><?php echo $totalApplications ?></p>
            </div>
            <div class="stat">
                <h2>Active Skill Workers</h2>
                <p id="totalWorkers"><?php echo $totalWorkers ?></p>
            </div>
        </div>
        <p>Welcome to the Admin Dashboard of our Home Service Booking System. Here, you can manage users, bookings, skill workers, and more to ensure smooth operation of our platform.</p>
        <div class="navigation">
            <a href="users.php" class="button">Manage Users</a>
            <a href="applications.php" class="button">Manage Applications</a>
            <a href="workers.php" class="button">Manage Skill Workers</a>
        </div>
    </div>
</body>

</html>
