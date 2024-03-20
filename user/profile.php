<?php
session_start();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Profile</title>
    <link rel='stylesheet' href='profile.css'>
    <link rel='stylesheet' href='nav.css'>
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
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
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
                    <h2>Bookings</h2>
                    <div class='booking'>
                        <p>Booking 1: Date and Time</p>
                        <p>Booking 2: Date and Time</p>
                        <!-- Add more bookings as needed -->
                    </div>
                </div>
            </center>";
        } else if ($result1->num_rows > 0) {
            $row1 = mysqli_fetch_assoc($result1);
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
                    <p>Name: " . $name . "</p>
                    <p>Email: " . $email . "</p>
                    <p>Phone Number:  " . $phone . "</p>
                    <p>Service Area: " . $location . "</p>
                    <p>Skill:  " . $skill . "</p>
                        </center>";
            if (in_array($certificateExtension, ['jpg', 'jpeg', 'png'])) {
                echo "<div class='certiImg' style='position: absolute; top: 50px; left: 900px;'>Certificate:<a href='$certiImg' target='_blank'><img src='$certiImg' alt='$name' style='height: 90vh; width:400px;'></a></div>";
            } elseif ($certificateExtension === 'pdf') {
                echo "<div class='certiImg' style='position: absolute; top: 50px; left: 900px;'>Certificate:<embed src='$certiImg' style='height: 90vh;width:400px;'></div>";
            } else {
                echo "Unsupported file format";
            }
            echo "
                   <center>
                    <h2>Bookings</h2>
                    <div class='booking'>
                        <p>Booking 1: Date and Time</p>
                        <p>Booking 2: Date and Time</p>
                        <!-- Add more bookings as needed -->
                    </center>";
        }
    }
    ?>
</body>

</html>