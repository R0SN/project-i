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
    $row = mysqli_fetch_assoc($result);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];

        // Validate email and phone only if they have changed
        if ($email != $semail || $phone != $row['phone']) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
            } else if (!preg_match('/^(98|97)\d{8}/', $phone)) {
                echo "Enter a valid phone number!";
            } else {
                // Check if the new email or phone already exists
                $accCheck = "SELECT * FROM workers WHERE (email = '$email' OR phone='$phone') AND id != $userId";
                $result_1 = $con->query($accCheck);
                if ($result_1->num_rows > 0) {
                    echo "An account with the given email or phone already exists!";
                } else {
                    // Update worker details in the database
                    $query = "UPDATE users SET username='$name', email='$email', phone='$phone', location='$location' WHERE id=$userId";
                    $result0 = mysqli_query($con, $query);
                    if ($result0) {
                        header("refresh:0;url=profile.php");
                        exit;
                    } else {
                        echo "Error updating details: " . mysqli_error($con);
                    }
                }
            }
        } else {
            // Update worker details in the database if other fields have changed
            if (strlen($name) < 3 || strlen($name) > 20 || !preg_match('/^[a-zA-Z]+$/', $name)) {
                echo "Enter a valid name!";
            } else if (strlen($location) < 5 || strlen($location) > 30) {
                echo "Enter a valid location!";
            } else {
                $query = "UPDATE users SET username='$name', location='$location' WHERE id=$userId";
                $result0 = mysqli_query($con, $query);
                if ($result0) {
                    header("refresh:0;url=profile.php");
                    exit;
                } else {
                    echo "Error updating details: " . mysqli_error($con);
                }
            }
        }
    } else if (isset($_POST['cancel'])) {
        header("Location: profile.php");
    }
}


// -----------------------worker-----------------------------
else if ($result1->num_rows > 0) {
    $row1 = mysqli_fetch_assoc($result1);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];

        // Validate email and phone only if they have changed
        if ($email != $semail || $phone != $row1['phone']) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
            } else if (!preg_match('/^(98|97)\d{8}/', $phone)) {
                echo "Enter a valid phone number!";
            } else {
                // Check if the new email or phone already exists
                $accCheck = "SELECT * FROM workers WHERE (email = '$email' OR phone='$phone') AND id != $userId";
                $result_1 = $con->query($accCheck);
                if ($result_1->num_rows > 0) {
                    echo "An account with the given email or phone already exists!";
                } else {
                    // Update worker details in the database
                    $query = "UPDATE workers SET name='$name', email='$email', phone='$phone', service_area='$location' WHERE id=$userId";
                    $result0 = mysqli_query($con, $query);
                    if ($result0) {
                        header("refresh:0;url=profile.php");
                        exit;
                    } else {
                        echo "Error updating details: " . mysqli_error($con);
                    }
                }
            }
        } else {
            // Update worker details in the database if other fields have changed
            if (strlen($name) < 3 || strlen($name) > 20 || !preg_match('/^[a-zA-Z]+$/', $name)) {
                echo "Enter a valid name!";
            } else if (strlen($location) < 5 || strlen($location) > 30) {
                echo "Enter a valid location!";
            } else {
                $query = "UPDATE workers SET name='$name', service_area='$location' WHERE id=$userId";
                $result0 = mysqli_query($con, $query);
                if ($result0) {
                    header("refresh:0;url=profile.php");
                    exit;
                } else {
                    echo "Error updating details: " . mysqli_error($con);
                }
            }
        }
    } else if (isset($_POST['cancel'])) {
        header("Location: profile.php");
    }
}
mysqli_close($con);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Edit</title>
    <link rel='stylesheet' href='edit.css' />

</head>

<body><?php
        if ($result->num_rows > 0) {
            echo "
    <div class='container'>
        <form action='edit.php' method='post'>
            <h2>Edit Details</h2>
            <div class='form-group'>
                <label for='name'>Name:</label>
                <input type='text' id='name' name='name' value='{$row['username']}'>
            </div>
            <div class='form-group'>
                <label for='email'>Email:</label>
                <input type='email' id='email' name='email'  value='{$row['email']}'>
            </div>
            <div class='form-group'>
                <label for='phone'>Phone:</label>
                <input type='text' id='phone' name='phone'  value='{$row['phone']}'>
            </div>
            <div class='form-group'>
                <label for='location'>Location:</label>
                <input type='text' id='location' name='location'  value='{$row['location']}'>
            </div>
            <div class='form-group'>
            <button type='cancel' name='cancel'>Cancel</button>
            <button type='submit' name='change'>Confirm</button>
            <a href='changePw.php'>Change Password</a>
            </div>    
            </div>";
        } else if ($result1->num_rows > 0) {
            echo "
            <div class='container'>
            <form action='edit.php' method='post'>
            <h2>Edit Details</h2>
                <div class='form-group'>
                    <label for='name'>Name:</label>
                    <input type='text' id='name' name='name' value='{$row1['name']}'>
                </div>
                <div class='form-group'>
                    <label for='email'>Email:</label>
                    <input type='email' id='email' name='email'  value='{$row1['email']}'>
                </div>
                <div class='form-group'>
                    <label for='phone'>Phone:</label>
                    <input type='text' id='phone' name='phone'  value='{$row1['phone']}'>
                </div>
                <div class='form-group'>
                    <label for='location'>Location:</label>
                    <input type='text' id='location' name='location'  value='{$row1['service_area']}'>
                </div>
                <div class='form-group'>
                <button type='cancel' name='cancel'>Cancel</button>
                <button type='submit' name='change'>Confirm</button>
                <a href='changePw.php'>Change Password</a>
                </div>
        </div>";
        }
        ?>
    </div>

</body>

</html>