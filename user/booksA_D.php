<?php

include "../connect.php";
if (isset($_POST['bid']) && isset($_POST['action'])) {
    $bid = $_POST['bid'];
    if ($_POST['action'] == "approve") {
        $q = "UPDATE bookings SET status=2 WHERE id=$bid";
        $con->query($q);
        $con->close();
        exit();
    } elseif ($_POST['action'] == "decline") {
        $q1 = "UPDATE bookings SET status=1 WHERE  id=$bid";
        $con->query($q1);
        $con->close();
        exit();
    }
}

