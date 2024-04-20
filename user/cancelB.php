<?php
include "../connect.php";
// cancel_booking.php
if(isset($_GET['bid'])){
    $bid = $_GET['bid'];
    $qry = "DELETE FROM bookings WHERE id=$bid";
    $res = mysqli_query($con, $qry);
    // Redirect to the profile page after cancellation
    header("Location: profile.php");
    exit();
}
?>
