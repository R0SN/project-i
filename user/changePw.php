<?php
session_start();
include "../connect.php";

$userId = $_SESSION['user_id'];
$semail = $_SESSION['semail'];

$qry = "SELECT * FROM users WHERE id=$userId AND email='$semail'";
$qry1 = "SELECT * FROM workers WHERE id=$userId AND email='$semail'";

$result = $con->query($qry);
$result1 = $con->query($qry1);

// -----------------------user-----------------------------
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change'])) {
        $cpw = $_POST['cpw'];
        $npw = $_POST['npw'];
        $cnpw = $_POST['cnpw'];
        $password = $row['password'];
        if (empty($cpw) || empty($npw) || empty($cnpw)) {
            echo "<script>alert('One or more required fields are empty, Please fill in all the fields.')</script>";
        }else{
        if (password_verify($cpw, $password)) {
            if ($npw === $cnpw) {
                if (strlen($npw) >= 6 && preg_match('/[A-Z]/', $npw) && preg_match('/[0-9]/', $npw)) {
                    $hnpw = password_hash($npw, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password='$hnpw' WHERE id=$userId";
                    $result2 = $con->query($query);
                    if ($result2) {
                        echo "<script>alert('Password changed Successfully');window.location.href = 'profile.php';</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!')</script>";
                }
            } else {
                echo "<script>alert('The passwords do not match')</script>";
            }
        } else {
            echo "<script>alert('Sorry, the current password you entered is incorrect. Please double-check and try again.')</script>";
        }
    }
}
    if (isset($_POST['cancel'])) {
        header("Location: profile.php");
        exit;
    }
}
// --------------------------------------worker------------------------------------------
elseif ($result1->num_rows > 0) {
    $row = $result1->fetch_assoc();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change'])) {
        $cpw = $_POST['cpw'];
        $npw = $_POST['npw'];
        $cnpw = $_POST['cnpw'];
        $password = $row['password'];
        if (empty($cpw) || empty($npw) || empty($cnpw)) {
            echo "<script>alert('One or more required fields are empty, Please fill in all the fields.')</script>";
        }
        else{
        if (password_verify($cpw, $password)) {
            if ($npw === $cnpw) {
                if (strlen($npw) >= 6 && preg_match('/[A-Z]/', $npw) && preg_match('/[0-9]/', $npw)) {
                    $hnpw = password_hash($npw, PASSWORD_DEFAULT);
                    $query = "UPDATE workers SET password='$hnpw' WHERE id=$userId";
                    $result2 = $con->query($query);
                    if ($result2) {
                        echo "<script>alert('Password changed Successfully');window.location.href = 'profile.php';</script>";
                        $firstLoginFalse = 2;
                        mysqli_query($con, "UPDATE workers SET firstLogin='$firstLoginFalse' WHERE id='$userId'") or die(mysqli_error($con));
                        header("refresh:1;url=profile.php");
                        exit;
                    }
                } else {
                    echo "<script>alert('Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!')</script>";
                }
            } else {
                echo "<script>alert('The passwords do not match')</script>";
            }
        } else {
            echo "<script>alert('Sorry, the current password you entered is incorrect. Please double-check and try again.')</script>";
        }
    }
}
    if (isset($_POST['cancel'])) {
        header("Location: Wprofile.php");
        exit;
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSprint - Change Password</title>
    <link rel="stylesheet" href="edit.css">
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">

</head>

<body>
    <div class='container'>
        <form action='changePw.php' method='post'>
            <h2>Change Password</h2>
            <div class='form-group'>
                <label for='cpw'>Current Password:</label>
                <input type='password' id='cpw' name='cpw'>
            </div>
            <div class='form-group'>
                <label for='npw'>New Password:</label>
                <input type='password' id='npw' name='npw'>
            </div>
            <div class='form-group'>
                <label for='cnpw'>Confirm New Password:</label>
                <input type='password' id='cnpw' name='cnpw'>
            </div>

            <div class='form-group'>
            <button type='cancel' name='cancel'>Cancel</button>
                <button type='submit' name='change'>Change Password</button>
            </div>
    </div>

</body>

</html>