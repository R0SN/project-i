<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location:signin.php");
}
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
    if (isset($_POST['change'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];
        if (empty($name) || empty($email) || empty($phone) || empty($location)) {
            echo "<script>alert('Please fill in all the fileds')</script>";
        } else {
            if (strlen($name) < 3 || strlen($name) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $name)) {
                echo "<script>alert('Please enter a valid name.')</script>";
            } else if (strlen($location) < 5 || strlen($location) > 30) {
                echo "<script>alert('Please enter a valid location')</script>";
            } else {
                // Validate email and phone only if they have changed
                if ($email != $semail || $phone != $row['phone']) {
                    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
                        echo "<script>alert('Invalid email format.')</script>";
                    } else if (!preg_match('/^(98|97)\d{8}/', $phone)) {
                        echo "<script>alert('Please enter a valid phone number.')</script>";
                    } else {
                        // Check if the new email or phone already exists
                        $accCheck = "SELECT * FROM users WHERE (email = '$email' OR phone='$phone') AND id != $userId";
                        $result_1 = $con->query($accCheck);
                        if ($result_1->num_rows > 0) {
                            echo "<script>alert('An accout with given email or phone already exists.')</script>";
                        } else {
                            // Update worker details in the database
                            $query = "UPDATE users SET username='$name', email='$email', phone='$phone', location='$location' WHERE id=$userId";
                            $result0 = mysqli_query($con, $query);
                            if ($result0) {
                                $_SESSION['semail'] = $email;
                                header("location:profile.php");
                                exit;
                            } else {
                                echo "Error updating details: " . mysqli_error($con);
                            }
                        }
                    }
                } else {
                    // Update user details in the database if other fields have changed
                    $query = "UPDATE users SET username='$name', location='$location' WHERE id=$userId";
                    $result0 = mysqli_query($con, $query);
                    if ($result0) {
                        header("location:profile.php");
                        exit;
                    } else {
                        echo "Error updating details: " . mysqli_error($con);
                    }
                }
            }
        }
    } else if (isset($_POST['cancel'])) {
        header("location:profile.php");
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
        $bio = $_POST['bio'];
        if (empty($name) || empty($email) || empty($phone) || empty($location)) {
            echo "<script>alert('Please fill in all the fileds')</script>";
        } else{ 
            if (strlen($name) < 3 || strlen($name) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $name)) {
            echo "<script>alert('Please enter a valid name.')</script>";
        } else if (strlen($location) < 5 || strlen($location) > 30) {
            echo "<script>alert('Please enter a valid location.')</script>";
        } else if (!empty($bio) && (strlen($bio) < 50 || strlen($bio) > 300)) {
            echo "<script>alert('Length of bio should be between 50 and 300 characters.')</script>";
        } else {
            // Validate email and phone only if they have changed
            if ($email != $semail || $phone != $row1['phone']) {
                if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
                    echo "<script>alert('Invalid email format.')</script>";
                } else if (!preg_match('/^(98|97)\d{8}/', $phone)) {
                    echo "<script>alert('Please enter a valid phone number.')</script>";
                } else {
                    // Check if the new email or phone already exists
                    $accCheck = "SELECT * FROM workers WHERE (email = '$email' OR phone='$phone') AND id != $userId";
                    $result_1 = $con->query($accCheck);
                    if ($result_1->num_rows > 0) {
                        echo "<script>alert('An accout with given email or phone already exists.')</script>";
                    } else {
                        // Update worker details in the database
                        $query = "UPDATE workers SET name='$name', email='$email', phone='$phone', service_area='$location', bio='$bio' WHERE id=$userId";
                        $result0 = mysqli_query($con, $query);
                        if ($result0) {
                            $_SESSION['semail'] = $email;
                            header("refresh:0;url=Wprofile.php");
                            exit;
                        } else {
                            echo "Error updating details: " . mysqli_error($con);
                        }
                    }
                }
            } else {
                // Update worker details in the database if other fields have changed

                $query = "UPDATE workers SET name='$name', service_area='$location', bio='$bio' WHERE id=$userId";
                $result0 = mysqli_query($con, $query);
                if ($result0) {
                    header("refresh:0;url=Wprofile.php");
                    exit;
                } else {
                    echo "Error updating details: " . mysqli_error($con);
                }
            }
        }
    } 
}else if (isset($_POST['cancel'])) {
        header("Location:Wprofile.php");
    }
}
mysqli_close($con);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>SkillSprint - Edit Profile</title>
    <link rel='stylesheet' href='edit.css' />
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">


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
                <div>
                    <label for='bio'>Bio:</label>
                    <textarea name='bio' placeholder='Add a Bio'>{$row1['bio']}</textarea>
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