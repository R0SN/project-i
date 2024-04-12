<?php
session_start();
$userId = $_SESSION['user_id'];
include "../connect.php"; // Include your database connection script
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Profile</title>
    <link rel="stylesheet" href="Wprofile.css" />
</head>

<body>

<?php
$qry = "SELECT * FROM workers WHERE id=$userId";
$result1 = mysqli_query($con, $qry);
$row1 = mysqli_fetch_assoc($result1);
$id = $row1['id'];
$name = $row1['name'];
$email = $row1['email'];
$location = $row1['service_area'];
$phone = $row1['phone'];
$skill = $row1['skill'];
$bio = $row1['bio'];
$photo = $row1['photo'];
$photoImg = "../images/workers/photo/{$photo}";
$certificate = $row1['certificate'];
$certiImg = "../images/workers/certificates/{$certificate}";
$certificateExtension = pathinfo($certiImg, PATHINFO_EXTENSION);
echo "<div class='details'>
<img src='$photoImg' alt='Profile Picture' class='profileImage' height='100px'>
<a href='edit.php'><img src='../images/editIcon.png' class='edit'></a>
<p class='name'><span>Welcome</span> $name</p>
<p><span>Email:</span> $email</p>
<p><span>Phone Number:</span> $phone</p>
<p><span>Service Area:</span> $location</p>
<p><span>Skill:</span> $skill</p>";
if(!empty($bio)){
    echo "<p><span>Bio:</span> $bio</p>";
}
echo"<button onclick='redirect()'>Sign Out</button></div>";

echo "<div class='recent_books'>
        <h2>Recent Bookings</h2>
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

// Retrieve recent bookings
$getRecentBookings = "SELECT * FROM bookings WHERE worker_id=$userId AND status=0 ORDER BY dateTime ASC";
$resultRecent = $con->query($getRecentBookings);
$countRecent = mysqli_num_rows($resultRecent);

if ($countRecent > 0) {
    $countRes=1;
    while ($row2 = mysqli_fetch_assoc($resultRecent)) {
        $buserid = $row2['user_id'];
        $dnt = $row2['dateTime'];
        $bid = $row2['id'];

        $getUserDetail = "SELECT * FROM users WHERE id=$buserid";
        $result3 = $con->query($getUserDetail);
        $row3 = mysqli_fetch_assoc($result3);
        $uname = $row3['username'];
        $umail = $row3['email'];
        $uphone = $row3['phone'];
        $ulocation = $row3['location'];
        
        echo "<tr>
                <td>$uname</td>
                <td>$uphone</td>
                <td>$umail</td>
                <td>$ulocation</td>
                <td>$dnt</td>";
        
            echo "<td>
                    <form action='Wprofile.php' method='post'>
                        <input type='hidden' name='bid' value='$bid'>
                        <button type='submit' name='approve'>Approve</button>
                    </form>
                </td>
                <td>
                    <form action='Wprofile.php' method='post'>
                        <input type='hidden' name='bid' value='$bid'>
                        <button type='submit' name='decline'>Decline</button>
                    </form>
                </td></tr>";
            $countRes++;
            if($countRes>5){
                echo "<td colspan='7'><a href='books.php'>More Recent Books</a></td>";
                break;
            }
        }
    }else {
    echo "<tr><td colspan='7'>No Recent Bookings</td></tr>";
}
echo "</table>";



echo "<div class='accepted_books'>
        <h2>Accepted Bookings</h2>
        <table border='1'>
        <thead>
          <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Location</th>
            <th>Date and Time</th>
            <th>Status</th>
          </tr>
        </thead>";

// Retrieve accepted bookings
$getAcceptedBookings = "SELECT * FROM bookings WHERE worker_id=$userId AND status=2 ORDER BY dateTime ASC";
$reslutAccepted = $con->query($getAcceptedBookings);
$countAccept = mysqli_num_rows($reslutAccepted);

if ($countAccept > 0) {
    $countAcc=1;
    while ($row21 = mysqli_fetch_assoc($reslutAccepted)) {
        $buserid1 = $row21['user_id'];
        $dnt1 = $row21['dateTime'];
        $bid1 = $row21['id'];

        $getUserDetail = "SELECT * FROM users WHERE id=$buserid1";
        $result31 = $con->query($getUserDetail);
        $row31 = mysqli_fetch_assoc($result31);
        $uname1 = $row31['username'];
        $umail1 = $row31['email'];
        $uphone1 = $row31['phone'];
        $ulocation1 = $row31['location'];
        
        echo "<tr>
                <td>$uname1</td>
                <td>$uphone1</td>
                <td>$umail1</td>
                <td>$ulocation1</td>
                <td>$dnt1</td>
                <td class='green'>Approved</td>
                </tr>";
        $countAcc++;
        if($countAcc>5){
            echo "<td colspan='6'><a href='books.php'>More Accepted Bookings</a></td>";
            break;
        }
    }
}else {
    echo "<tr><td colspan='6'>No Accepted Bookings</td></tr>";
}
echo "</table>";
?>
<button class="more" style="margin-top: 20px;" onclick="redirect2()">View all Bookings</button>
<?php

if (in_array($certificateExtension, ['jpg', 'jpeg', 'png'])) {
    echo "<div class='certiImg'><img src='$certiImg' alt='$name'></div>";
} elseif ($certificateExtension === 'pdf') {
    echo "<div class='certiImg'><embed src='$certiImg'></div>";
} else {
    echo "Unsupported file format";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $bid = $_POST['bid'];
    $q = "UPDATE bookings SET status=2 WHERE id=$bid";
    $con->query($q);
    echo "<script>window.location.href='Wprofile.php';</script>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline'])) {
    $bid = $_POST['bid'];
    $q1 = "UPDATE bookings SET status=1 WHERE  id=$bid";
    $con->query($q1);
    echo "<script>window.location.href='Wprofile.php';</script>";

}

$con->close();
?>
<script>
    function redirect(){
        window.location.href='signout.php';
    }
    function redirect2(){
        window.location.href='books.php';
    }
</script>
</body>
</html>
