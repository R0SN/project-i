<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    include "../connect.php";
    $cid = $_POST['change_id'];
    $cusername = $_POST['change_username'];
    $cemail = $_POST['change_email'];
    $clocation = $_POST['change_location'];
    $cphone = $_POST['change_phone'];

    $qry = "SELECT * FROM users WHERE id='$cid'";
    $result0 = $con->query($qry);
    $row = mysqli_fetch_assoc($result0);

    if (empty($cusername) || empty($cemail) || empty($cphone) || empty($clocation)) {
        echo "One or more required fields are empty, Please fill in all the fields.";
    } else {
        // Validate email and phone only if they have changed
        if ($cemail != $row['email'] || $cphone != $row['phone']) {
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $cemail)) {
                echo "Invalid email format!  ";
            } else if (!preg_match('/^(98|97)\d{8}/', $phone)) {
                echo "Enter a valid phone number!";
            } else {
                $accCheck = "SELECT * FROM users WHERE (email = '$email' OR phone='$phone')";
                $result_1 = $con->query($accCheck);
                if ($result_1->num_rows > 0) {
                    echo "<script>alert('User with given email or phone nubmer already exists.')</script>";
                } else {
                    // Update worker details in the database
                    $query = "UPDATE users SET username='$cusername', email='$cemail', phone='$cphone', location='$clocation' WHERE id=$cid";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        echo "<script>alert('Details updated successfully.'); window.location.href = 'users.php';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Error updating details.')</script>" . mysqli_error($con);
                    }
                }
            }
        } else {
            if (strlen($cusername) < 3 || strlen($cusername) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $cusername)) {
                echo "Enter a valid name!";
            } else if (strlen($clocation) < 5 || strlen($clocation) > 30) {
                echo "Enter a valid location!";
            } else {
                $query = "UPDATE users SET username='$cusername', location='$clocation' WHERE id=$cid";
                $result0 = mysqli_query($con, $query);
                if ($result0) {
                    echo "<script>alert('Details updated successfully.'); window.location.href = 'users.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Error updating details.')</script>" . mysqli_error($con);
                }
            }
        }
    }
    mysqli_close($con);
} elseif (isset($_POST['cancel'])) {
    header("Location: users.php");
    exit;
}
?>
