<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSprint - Skill Worker</title>
    <link rel="stylesheet" href="nav.css" />
    <link rel="stylesheet" href="profile.css" />  
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">

</head>

<body>
    <!-- ------------------- NAVIGATION BAR ---------------------------- -->
    <nav>
        <div class="logo-container">
            <img src="../images\logo\house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
        </div>
        <a href="home.php" class="hovers">Home</a>
        <a href="service.php" class="hovers">Services</a>
        <a href="signout.php" class="hovers">Sign Out</a>

        <div class="profile-icon">
            <a href="profile.php"> <img src="../images/profile-user.png" alt="profile" class="profile" style="z-index: 1" />
            </a>
        </div>
    </nav>
    <!-- ------------------- NAVIGATION BAR ------------------->
    <div class="main">
        <!-- Table for Applications -->
        <?php
        include "../connect.php";
        if ($_GET['id']) {
            $id = $_GET['id'];
            $query = "SELECT * FROM workers where id=$id";
            $result = mysqli_query($con, $query);


            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $name = $row['name'];
                $email = $row['email'];
                $location = $row['service_area'];
                $phone = $row['phone'];
                $skill = $row['skill'];
                $bio = $row['bio'];
                $photo = $row['photo'];
                $photoImg = "../images/workers/photo/{$photo}";
                $certificate = $row['certificate'];
                $certiImg = "../images/workers/certificates/{$certificate}";
                $certificateExtension = pathinfo($certiImg, PATHINFO_EXTENSION);

                echo "<div class='nNb'><div class='notice'>Note that service providers and customers should directly discuss prices and costs. Users can talk to the service provider about more specifics during the scheduled session.</div>
                <button onclick='backToServicePg()' onmouseover='change(this)' onmouseout='unchange(this)' style='margin:20px 130px' >Back</button></div>
                        <center style='margin-top:10px;'>
                        <div class='img_container' ></div>
                        <img src='$photoImg' alt='Profile Picture' class='profileImage' height='100px'>
                        <p><span class='det'>Name: </span>" . $name . "</p>
                        <p><span class='det'>Email: </span>" . $email . "</p>
                        <p><span class='det'>Phone Number:  </span>" . $phone . "</p>
                        <p><span class='det'>Service Area: </span>" . $location . "</p>
                        <p><span class='det'>Skill:  </span>" . $skill . "</p>";
                if (!empty($bio)) {
                    echo "<div style=' display: flex;justify-content: space-between;max-width:350px;'>
                    <p><span class='det'>Bio:  </span></p>
                    <p><span style=' text-align: justify;'>" . $bio . "</span></p>
                    </div>
                    ";
                }

                echo "</center>";

                if (in_array($certificateExtension, ['jpg', 'jpeg', 'png'])) {
                    echo "<div class='certiImg'><a href='$certiImg' target='_blank'><img src='$certiImg' alt='$name' style='height: 90vh; width:400px;'></a></div>";
                } elseif ($certificateExtension === 'pdf') {
                    echo "<div class='certiImg'><embed src='$certiImg' style='height: 90vh;width:400px;'></div>";
                } else {
                    echo "Unsupported file format";
                }
                echo "
                    <center>
                        <form id='bookingForm' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post' onsubmit='return validateDateTime()'>
                            <input type='hidden' name='id' value='$id'>
                            <label for='dateTime' style='font-size:large;  font-weight: bold; color:#333'>Choose Date and Time:</label>
                            <input type='datetime-local' id='dateTime' name='dateTime' required>
                            <button id='submit' name='book' onmouseover='change(this)' onmouseout='unchange(this)'>Book Now</button>
                        </form>
                    </center>
                ";
            } else {
                echo "wrorker not found";
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
            $bookingDateTime = $_POST['dateTime'];
            $userId = $_SESSION['user_id'];
            $workerId = $_POST['id'];

            $sql = "INSERT INTO bookings (user_id, worker_id, dateTime) 
                    VALUES ('$userId', '$workerId', '$bookingDateTime')";

            if (mysqli_query($con, $sql)) {
                header("refresh:0;url=profile.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }

            // Close database connection
            mysqli_close($con);
        }
        ?>
    </div>
    <script>
        function validateDateTime() {
            var dateTimeInput = document.getElementById('dateTime');
            var selectedDateTime = new Date(dateTimeInput.value);
            var currentDateTime = new Date();
            // Set the maximum date as current date + 30 days
            var maxDateTime = new Date(currentDateTime.getTime() + (30 * 24 * 60 * 60 * 1000));
            // Set the minimum date as current date and time
            var minDateTime = new Date();
            // Check if the selected date is in the past or too far in the future
            if (selectedDateTime < minDateTime || selectedDateTime > maxDateTime) {
                alert('Please select a date and time within the valid range (up to 30 days in the future).');
                return false;
            }
            return true;
        }

        function change(element) {
            element.style.backgroundColor = "white";
            element.style.color = "#333";
        }

        function unchange(element) {
            element.style.backgroundColor = "#333";
            element.style.color = "white";
        }
        function backToServicePg(){
            window.location.href="service.php";
        }
    </script>


</body>

</html>