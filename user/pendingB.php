<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location:signin.php");
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>SkillSprint - Pending Bookings</title>
    <!-- <link rel='stylesheet' href='nav.css'> -->
    <link rel="stylesheet" href="books.css" />
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">

</head>

<body>
    <!-- ------------------- SIDEBAR ---------------------------- -->
    <div class="sidebar">
        <h2>Filters</h2>
        <div>
            <input type="checkbox" id="pending" name="filter" value="0" onclick="handlePending()" checked>
            <label for="pending">Pending Bookings</label>
        </div>
        <div>
            <input type="checkbox" id="accepted" name="filter" value="2" onclick="handleAccepted()">
            <label for="accepted">Accepted Bookings</label>
        </div>
        <div>
            <input type="checkbox" id="declined" name="filter" value="1" onclick="handleDeclined()">
            <label for="declined">Declined Bookings</label>
        </div>

        <div class="line"></div>
        <div>
            <input type="button" id="back" name="filter" onclick="back()">
            <label for="back">Back</label>
        </div>
        <div>
            <input type="button" id="signout" name="filter" onclick="signout()">
            <label for="signout">Sign Out</label>
        </div>
    </div>
    <!-- ------------------- SIDEBAR ---------------------------- -->
    <div class="main">
        <table border='1' id="bookingsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Date and Time</th>
                    <th colspan='2'>Status</th>
                </tr>
            </thead>
            <?php
            include "../connect.php"; // Include your database connection script
            $userId = $_SESSION['user_id'];
            $getBooking = "SELECT * FROM bookings WHERE worker_id=$userId && status=0";
            $result2 = $con->query($getBooking);

            if (mysqli_num_rows($result2) > 0) {
                // Loop through each row of data
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    // Retrieve booking details
                    $userId1 = $row2['user_id'];
                    $status = $row2['status'];
                    $dnt = $row2['dateTime'];
                    $bid = $row2['id'];

                    // Retrieve user details
                    $getUserDetail = "SELECT * FROM users WHERE id=$userId1";
                    $result3 = $con->query($getUserDetail);
                    $row3 = mysqli_fetch_assoc($result3);
                    $uname = $row3['username'];
                    $umail = $row3['email'];
                    $uphone = $row3['phone'];
                    $ulocation = $row3['location'];

                    // Output booking row
                    echo "<tr class='booking-row status-$status'>
                        <td>$uname</td>
                        <td>$umail</td>
                        <td>$uphone</td>
                        <td>$ulocation</td>
                        <td>$dnt</td>";

                    // Output booking status or action buttons
                    if ($status == 1) {
                        echo "<td colspan='2' class='red'>Declined</td>";
                    } else if ($status == 2) {
                        echo "<td colspan='2' class='green'>Approved</td>";
                    } else {
                        echo "<td>
                        <button id=approve type='button' onclick='approveB($bid, this.id, this.parentElement)'>Approve</button>
                    </td>
                    <td>
                        <button id=decline type='button' onclick='declineB($bid, this.id, this.parentElement)'>Decline</button>
                    </td>";
                    }
                    echo "</tr>";
                }
                // Close table and div tags after all bookings are displayed
                echo "</table></div>";
            } else {
                // No data found in the database
                echo "<tr><td colspan='6'>No Bookings</td></tr>";
            }
            ?>
    </div>
    <script>
        function handlePending() {
            window.location.href = "books.php";
        }

        function handleAccepted() {
            window.location.href = "acceptedB.php";
        }

        function handleDeclined() {
            window.location.href = "declinedB.php";
        }

        function approveB(bid, action, tdElement) {
            if (confirm("Are you sure you want to approve the booking?")) {
                let actionToDo = action;
                let ajax = new XMLHttpRequest();
                ajax.open("POST", "booksA_D.php", true);
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onreadystatechange = function() {
                    if (ajax.readyState === 4) {
                        if (ajax.status == 200) {
                            let declineBtn = document.getElementById("decline");
                            declineBtn.parentElement.remove();
                            tdElement.innerHTML = "Approved";
                            tdElement.setAttribute("colspan", "2");
                            tdElement.setAttribute("class", "green");
                        } else {
                            alert("An error occurred while accepting the booking.");
                        }
                    }
                };
                ajax.send("bid=" + encodeURIComponent(bid) + "&action=" + encodeURIComponent(actionToDo));
            }
        }

        function declineB(bid, action, tdElement) {
            if (confirm("Are you sure you want to decline the booking?")) {
                let actionToDo = action;
                let ajax = new XMLHttpRequest();
                ajax.open("POST", "booksA_D.php", true);
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onreadystatechange = function() {
                    if (ajax.readyState === 4) {
                        if (ajax.status == 200) {
                            let acceptBtn = document.getElementById("approve");
                            acceptBtn.parentElement.remove();
                            tdElement.innerHTML = "Declined";
                            tdElement.setAttribute("colspan", "2");
                            tdElement.setAttribute("class", "red");
                        } else {
                            alert("An error occurred while declining the booking.");
                        }
                    }
                };
                ajax.send("bid=" + encodeURIComponent(bid) + "&action=" + encodeURIComponent(actionToDo));
            }
        }

        function back() {
            window.location.href = 'Wprofile.php';
        }

        function signout() {
            window.location.href = 'signout.php';
        }
    </script>

</body>

</html>