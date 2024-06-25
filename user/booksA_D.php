<?php

include "../connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
                $bid = $_POST['bid'];
                $q = "UPDATE bookings SET status=2 WHERE id=$bid";
                $con->query($q);
                header("Location:books.php");            }
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline'])) {
                $bid = $_POST['bid'];
                $q1 = "UPDATE bookings SET status=1 WHERE  id=$bid";
                $con->query($q1);
                header("Location:books.php");            
            }
?>