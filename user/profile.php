<?php
session_start();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Profile</title>
    <link rel='stylesheet' href='nav.css'>
    <link rel="stylesheet" href="profile.css" />

</head>

<body>
    <!-- Navigation Bar -->
    <nav>
        <div class='logo-container'>
            <img src='../images/logo/house-cleaning.png' alt='SkillSprint Logo' class='logo' style='z-index: 1' />
        </div>
        <a href='home.php' class='hovers'>Home</a>
        <a href='service.php' class='hovers'>Services</a>
        <a href='signout.php' class='hovers'>Sign Out</a>

        <div class='profile-icon'>
            <a href='profile.php'>
                <img src='../images/profile-user.png' alt='profile' class='profile' style='z-index: 1' />
            </a>
        </div>
    </nav>

    <?php
    include "../connect.php";
    if (!isset($_SESSION['user_id'])) {
        header("location:signin.php");
        exit();
    } else {
        $userId = $_SESSION['user_id'];
        $semail = $_SESSION['semail'];

        $qry = "SELECT * FROM users WHERE id=$userId AND email='$semail'";
        $qry1 = "SELECT * FROM workers WHERE id=$userId AND email='$semail'";

        $result = $con->query($qry);
        $result1 = $con->query($qry1);

        //===================user profile================== 
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $name = $row['username'];
            $email = $row['email'];
            $location = $row['location'];
            $phone = $row['phone'];
            echo "
            <center>
                <div class='container'>
                    <div class='img_container'> </div>
                    <img src='../images/Black-profile-user.png' alt='Profile Picture' class='profileImage' height='100px'>
                    <p>Name: " . $name . "</p>
                    <p>Email: " . $email . "</p>
                    <p>Phone Number: " . $phone . " </p>
                    <p>Location: " . $location . "</p>
                    <div class='books'>
                    <h2>Bookings</h2>
                    <table border='1'>
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Skill</th>
                        <th>Date and Time</th>
                        <th >Status</th>
                      </tr>
                    </thead>
            </center>";
            $getBooking = "SELECT * FROM bookings WHERE user_id=$id";
            $result2 = $con->query($getBooking);

            if (mysqli_num_rows($result2) > 0) {
                // Loop through each row of data
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $workerId = $row2['worker_id'];
                    $status = $row2['status'];
                    $dnt = $row2['dateTime'];
                    $bid = $row2['id'];

                    $getUserDetail = "SELECT * FROM workers WHERE id=$workerId";
                    $result3 = $con->query($getUserDetail);
                    $row3 = mysqli_fetch_assoc($result3);
                    $wname = $row3['name'];
                    $wmail = $row3['email'];
                    $wphone = $row3['phone'];
                    $wlocation = $row3['service_area'];
                    $wskill = $row3['skill'];
                    echo "<tr>
                        <td> $wname </td>
                        <td>$wmail</td>
                        <td>$wphone </td>
                        <td>$wlocation </td>
                        <td>$wskill </td>
                        <td>$dnt </td>";
                    if ($status == 1) {
                        echo "<td>Declined</td>";
                    } else if ($status == 2) {
                        echo "<td>Approved</td>";
                    } else {
                        echo "
                        <td>
                            <form action='profile.php' method='post'>
                            <input type='hidden' name='bid' value='$bid'>
                            <button type='submit' name='cancel'>Cancel</button>
                            </form>
                        </td>";
                    }
                }
                echo "</tr></table></div>";
            } else {
                // No data found in the database
                echo "<tr><td colspan='7'>No Bookings</td></tr>";
            }
        }
        // =============worker profile=================
        else if ($result1->num_rows > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $id = $row1['id'];
            $name = $row1['name'];
            $email = $row1['email'];
            $location = $row1['service_area'];
            $phone = $row1['phone'];
            $skill = $row1['skill'];
            $photo = $row1['photo'];
            $photoImg = "../images/workers/photo/{$photo}";
            $certificate = $row1['certificate'];
            $certiImg = "../images/workers/certificates/{$certificate}";
            $certificateExtension = pathinfo($certiImg, PATHINFO_EXTENSION);

            echo "
                    <center>
                    <div class='img_container'></div>
                    <img src='$photoImg' alt='Profile Picture' class='profileImage' height='100px'>
                    <p>Name: $name</p>
                    <p>Email: $email</p>
                    <p>Phone Number: $phone</p>
                    <p>Service Area: $location</p>
                    <p>Skill: $skill</p>
                    </center>";
            if (in_array($certificateExtension, ['jpg', 'jpeg', 'png'])) {
                echo "<div class='certiImg'><img src='$certiImg' alt='$name'></div>";
            } elseif ($certificateExtension === 'pdf') {
                echo "<div class='certiImg'><embed src='$certiImg'></div>";
            } else {
                echo "Unsupported file format";
            }
            echo "
            <div class='books'>
                    <h2>Bookings</h2>
                    <table border='1'>
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Date and Time</th>
                        <th colspan='2'>Status</th>
                      </tr>
                    </thead>";
            $getBooking = "SELECT * FROM bookings WHERE worker_id=$id";
            $result2 = $con->query($getBooking);

            if (mysqli_num_rows($result2) > 0) {
                // Loop through each row of data
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $userId = $row2['user_id'];
                    $status = $row2['status'];
                    $dnt = $row2['dateTime'];
                    $bid = $row2['id'];

                    $getUserDetail = "SELECT * FROM users WHERE id=$userId";
                    $result3 = $con->query($getUserDetail);
                    $row3 = mysqli_fetch_assoc($result3);
                    $uname = $row3['username'];
                    $umail = $row3['email'];
                    $uphone = $row3['phone'];
                    $ulocation = $row3['location'];
                    echo "<tr>
                        <td> $uname </td>
                        <td>$umail</td>
                        <td>$uphone </td>
                        <td>$ulocation </td>
                        <td>$dnt </td>";
                    if ($status == 1) {
                        echo "<td>Declined</td>";
                    } else if ($status == 2) {
                        echo "<td>Approved</td>";
                    } else {
                        echo "<td >
                            <form action='profile.php' method='post'>
                            <input type='hidden' name='bid' value='$bid'>
                            <button type='submit' name='approve'>Approve</button>
                            </form>
                        </td>
                        <td>
                            <form action='profile.php' method='post'>
                            <input type='hidden' name='bid' value='$bid'>
                            <button type='submit' name='decline'>Decline</button>
                            </form>
                        </td>";
                    }
                }
                echo "</tr></table></div>";
            } else {
                // No data found in the database
                echo "<tr><td colspan='6'>No Bookings</td></tr>";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
        $bid = $_POST['bid'];
        $q = "UPDATE bookings SET status=2 WHERE id=$bid";
        $con->query($q);
        header("refresh: 0");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline'])) {
        $bid = $_POST['bid'];
        $q1 = "UPDATE bookings SET status=1 WHERE  id=$bid";
        $con->query($q1);
        header("refresh: 0");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel'])) {
        $bid = $_POST['bid'];
        $q1 = "DELETE FROM bookings WHERE  id=$bid";
        $con->query($q1);
        header("refresh: 0");
    }
    ?>
</body>

</html>