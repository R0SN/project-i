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

        if (password_verify($cpw, $password)) {
            if ($npw === $cnpw) {
                if (strlen($npw) >= 6 && preg_match('/[A-Z]/', $npw) && preg_match('/[0-9]/', $npw)) {
                    $hnpw = password_hash($npw, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password='$hnpw' WHERE id=$userId";
                    $result2 = $con->query($query);
                    if ($result2) {
                        echo "Password changed Successfully";
                        header("refresh:1;url=profile.php");
                        exit;
                    }
                } else {
                    echo "Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!";
                }
            } else {
                echo "The passwords do not match";
            }
        } else {
            echo "Sorry, the current password you entered is incorrect. Please double-check and try again.";
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

        if (password_verify($cpw, $password)) {
            if ($npw === $cnpw) {
                if (strlen($npw) >= 6 && preg_match('/[A-Z]/', $npw) && preg_match('/[0-9]/', $npw)) {
                    $hnpw = password_hash($npw, PASSWORD_DEFAULT);
                    $query = "UPDATE workers SET password='$hnpw' WHERE id=$userId";
                    $result2 = $con->query($query);
                    if ($result2) {
                        echo "Password changed Successfully";
                        $firstLoginFalse = 2;
                        mysqli_query($con, "UPDATE workers SET firstLogin='$firstLoginFalse' WHERE id='$userId'") or die(mysqli_error($con));
                        header("refresh:1;url=profile.php");
                        exit;
                    }
                } else {
                    echo "Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!";
                }
            } else {
                echo "The passwords do not match";
            }
        } else {
            echo "Sorry, the current password you entered is incorrect. Please double-check and try again.";
        }
    }
    if (isset($_POST['cancel'])) {
        header("Location: profile.php");
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
    <title>Change Password</title>
    <link rel="stylesheet" href="edit.css">
</head>

<body>
    <div class='container'>
        <form action='changePw.php' method='post'>
            <h2>Change Password</h2>
            <div class='form-group'>
                <label for='cpw'>Current Password:</label>
                <input type='password' id='cpw' name='cpw' <?php echo isset($_POST['change']) ? 'required' : ''; ?>>
            </div>
            <div class='form-group'>
                <label for='npw'>New Password:</label>
                <input type='password' id='npw' name='npw' <?php echo isset($_POST['change']) ? 'required' : ''; ?>>
            </div>
            <div class='form-group'>
                <label for='cnpw'>Confirm New Password:</label>
                <input type='password' id='cnpw' name='cnpw' <?php echo isset($_POST['change']) ? 'required' : ''; ?>>
            </div>

            <div class='form-group'>
                <button type='submit' name='change'>Change Password</button>
                <button type='cancel' name='cancel'>Cancel</button>
            </div>
    </div>

</body>

</html>