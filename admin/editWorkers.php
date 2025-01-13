<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../user/signin.php");
    exit();
}
include "../connect.php";

// Retain values in case of validation errors
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $skill = $_POST['skill'];
    $warea = $_POST['service_area'];
    $password = $_POST['password'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $cid = $_POST['change_id'];
    $cusername = $_POST['change_username'];
    $cemail = $_POST['change_email'];
    $cphone = $_POST['change_phone'];
    $carea = $_POST['change_warea'];
    $cpassword = $_POST['change_password'];

    // Validate if all required fields are filled
    if (empty($cusername) || empty($cemail) || empty($cphone) || empty($carea) || empty($cpassword)) {
        echo "<script>
            alert('One or more required fields are empty. Please fill in all the fields.');
        </script>";
    } else {
        // Check if the email or phone has been changed to a value that already exists
        $checkAcc = "SELECT * FROM workers WHERE (email = '$cemail' OR phone='$cphone') AND id != $cid";
        $res = $con->query($checkAcc);
        if ($res->num_rows > 0) {
            echo "<script>
                alert('Another user with the same email or phone already exists.');
            </script>";
        } else {
            // Validate email and phone
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9.]+@(?:gmail|yahoo|outlook).(com|me)$/', $cemail)) {
                echo "<script>
                alert('Invalid email format!');
                </script>";
            } else if (!preg_match('/^(98|97)\d{8}$/', $cphone)) {
                echo "<script>
                alert('Enter a valid phone number!');
                </script>";
            } else {
                // Hash the password before updating (if provided)
                $updatepw = "";
                if (!empty($cpassword)) {
                    $hcpassword = password_hash($cpassword, PASSWORD_DEFAULT);
                    $updatepw = ", password='$hcpassword'";
                }

                // Validate username and location
                if (strlen($cusername) < 3 || strlen($cusername) > 20 || !preg_match('/^[a-zA-Z\s]+$/', $cusername)) {
                    echo "<script>
                    alert('Enter a valid name!');
                    </script>";
                } else {
                    // Update worker details in the database
                    $query = "UPDATE workers SET name='$cusername', email='$cemail', phone='$cphone', service_area='$carea' $updatepw WHERE id=$cid";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        echo "<script>alert('Details updated successfully.'); window.location.href = 'workers.php';</script>";
                        exit;
                    } else {
                        echo "<script>
                        alert('Error updating details: " . mysqli_error($con) . "');
                        </script>";
                    }
                }
            }
        }
        mysqli_close($con);
    }
} elseif (isset($_POST['cancel'])) {
    header("Location: workers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editUser.css" />
    <title>Admin(SkillSprint) - Edit Worker</title>
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">
</head>

<body>
    <h1>Edit Worker</h1>
    <div class="container">
        <form action="" method="post">
            <label for="id">ID:</label>
            <input readonly type="number" id="id" name="change_id" value="<?php echo isset($_POST['change_id']) ? htmlspecialchars($_POST['change_id']) : $id; ?>"><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="change_username" value="<?php echo isset($_POST['change_username']) ? htmlspecialchars($_POST['change_username']) : $username; ?>"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="change_email" value="<?php echo isset($_POST['change_email']) ? htmlspecialchars($_POST['change_email']) : $email; ?>"><br>

            <label for="phone">Phone:</label>
            <input type="number" id="phone" name="change_phone" value="<?php echo isset($_POST['change_phone']) ? htmlspecialchars($_POST['change_phone']) : $phone; ?>"><br>

            <label for="warea">Service area:</label>
            <input type="text" id="warea" name="change_warea" value="<?php echo isset($_POST['change_warea']) ? htmlspecialchars($_POST['change_warea']) : $warea; ?>"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="change_password" value="<?php echo isset($_POST['change_password']) ? $_POST['change_password'] : $password; ?>"><br>

            <button type="submit" name="cancel">Cancel</button>
            <button type="submit" name="confirm">Confirm</button>
        </form>
    </div>
</body>

</html>
