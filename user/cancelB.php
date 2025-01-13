<?php
include "../connect.php";
// cancel_booking.php
if(isset($_POST['bid'])){
    $bid = intval($_POST['bid']); // Sanitize the input
    $qry = "DELETE FROM bookings WHERE id=$bid";
    $res = mysqli_query($con, $qry);
    $con->close();
    exit();
}
?>
