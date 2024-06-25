<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: ../user/signin.php");
}
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {

    $id = $_POST['id'];
    $query1 = "DELETE FROM bookings WHERE user_id = '$id'";
    $query = "DELETE FROM users WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $result1 = mysqli_query($con, $query1);

    if ($con->query($query) === false) {
        echo "User deletion failed";
    } else {
        header("Refresh:0; url=users.php");
    }
}
mysqli_close($con);
