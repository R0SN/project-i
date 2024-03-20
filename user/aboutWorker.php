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
    <link rel="stylesheet" href="profile.css" />
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
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['about'])) {
            $id = $_POST['id'];
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
                $photo = $row['photo'];
                $photoImg = "../images/workers/photo/{$photo}";
                $certificate = $row['certificate'];
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
                            <label for='dateTime'>Choose Date and Time:</label>
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
            $userId= $_SESSION['user_id'];
            $workerId = $_POST['id'];

            $sql = "INSERT INTO bookings (user_id, worker_id, dateTime) 
                    VALUES ('$userId', '$workerId', '$bookingDateTime')";
        
            if (mysqli_query($con, $sql)) {
                echo "Booked Succesfully";
                header("refresh:1;url=profile.php");
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
    </script>


</body>

</html>