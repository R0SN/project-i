<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/signin.php");
    exit();
}

include "../connect.php";

// Check if editing is initiated
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['name'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
}

// Check if confirmation or cancellation is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $cid = $_POST['change_id'];
    $cusername = $_POST['change_username'];
    $cemail = $_POST['change_email'];
    $clocation = $_POST['change_location'];
    $cphone = $_POST['change_phone'];

    $qry = "SELECT * FROM users WHERE id='$cid'";
    $result0 = $con->query($qry);
    $row = mysqli_fetch_assoc($result0);

    // Validate fields
    if (empty($cusername) || empty($cemail) || empty($cphone) || empty($clocation)) {
        echo "<script>alert('One or more required fields are empty.');</script>";
    } elseif ($cemail != $row['email'] || $cphone != $row['phone']) {
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9.]+@(?:gmail|yahoo|outlook).(com|me)$/', $cemail)) {
            echo "<script>alert('Invalid email format.');</script>";
        } elseif (!preg_match('/^(98|97)\d{8}$/', $cphone)) {
            echo "<script>alert('Enter a valid phone number.');</script>";
        } else {
            $accCheck = "SELECT * FROM users WHERE (email = '$cemail' OR phone='$cphone')";
            $result_1 = $con->query($accCheck);
            if ($result_1->num_rows > 0) {
                echo "<script>alert('User with given email or phone number already exists.');</script>";
            } else {
                $query = "UPDATE users SET username='$cusername', email='$cemail', phone='$cphone', location='$clocation' WHERE id=$cid";
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo "<script>alert('Details updated successfully.'); window.location.href = 'users.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Error updating: " . mysqli_error($con) . "');</script>";
                }
            }
        }
    } else {
        if (strlen($cusername) < 3 || strlen($cusername) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $cusername)) {
            echo "<script>alert('Enter a valid name.');</script>";
        } elseif (strlen($clocation) < 5 || strlen($clocation) > 30) {
            echo "<script>alert('Enter a valid location.');</script>";
        } else {
            $query = "UPDATE users SET username='$cusername', location='$clocation' WHERE id=$cid";
            $result0 = mysqli_query($con, $query);
            if ($result0) {
                echo "<script>alert('Details updated successfully.'); window.location.href = 'users.php';</script>";
                exit;
            } else {
                echo "<script>alert('Error updating: " . mysqli_error($con) . "');</script>";
            }
        }
    }
} elseif (isset($_POST['cancel'])) {
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin(SkillSprint) - Edit User</title>
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">
    <link rel="stylesheet" href="editUser.css" />
</head>
<body>
    <h1>Edit User</h1>
    <div class="container">
<form action="" method="post">
    <label for="id">ID:</label>
    <input readonly type="number" id="id" name="change_id" value="<?php echo isset($_POST['change_id']) ? htmlspecialchars($_POST['change_id']) : $id; ?>"><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="change_username" value="<?php echo isset($_POST['change_username']) ? htmlspecialchars($_POST['change_username']) : $username; ?>"><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="change_email" value="<?php echo isset($_POST['change_email']) ? htmlspecialchars($_POST['change_email']) : $email; ?>"><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="change_location" value="<?php echo isset($_POST['change_location']) ? htmlspecialchars($_POST['change_location']) : $location; ?>"><br>

    <label for="phone">Phone:</label>
    <input type="number" id="phone" name="change_phone" value="<?php echo isset($_POST['change_phone']) ? htmlspecialchars($_POST['change_phone']) : $phone; ?>"><br>

    <button type="submit" name="cancel">Cancel</button>
    <button type="submit" name="confirm">Confirm</button>
</form>

    </div>
</body>
</html>
