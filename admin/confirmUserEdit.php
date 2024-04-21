<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin(SkillSprint) - Confirm Edit</title>
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">

</head>
<body>
<?php
    include "../connect.php";
    $query = "SELECT * FROM users"; // Query to fetch workers from the database
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result)
    ?>
<form action='editUser.php' method='post'>
                        <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                        <input type='hidden' name='name' value='<?php echo $row['username']; ?>'>
                        <input type='hidden' name='email' value='<?php echo $row['email']; ?>'>
                        <input type='hidden' name='location' value='<?php echo $row['location']; ?>'>
                        <input type='hidden' name='phone' value='<?php echo $row['phone']; ?>'>
                        <input type="submit"  name='edit' id="editButton" hidden>
                        </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $cid = $_POST['change_id'];
    $cusername = $_POST['change_username'];
    $cemail = $_POST['change_email'];
    $clocation = $_POST['change_location'];
    $cphone = $_POST['change_phone'];

    $qry = "SELECT * FROM users WHERE id='$cid'";
    $result0 = $con->query($qry);
    $row = mysqli_fetch_assoc($result0);

    if (empty($cusername) || empty($cemail) || empty($cphone) || empty($clocation)) {
        echo "<script>
        if (confirm('One or more required fields are empty. Please fill in all the fields.')) {
            document.getElementById('editButton').click(); 
        } else {
            window.location.href = 'users.php';
        }
    </script>";
    } else {
        // Validate email and phone only if they have changed
        if ($cemail != $row['email'] || $cphone != $row['phone']) {
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9.]+@(?:gmail|yahoo|outlook).(com|me)$/', $cemail)) {
                echo "<script>
                if (confirm('Invalid email format.')) {
                    document.getElementById('editButton').click(); 
                } else {
                    window.location.href = 'users.php';
                }
            </script>";
            } else if (!preg_match('/^(98|97)\d{8}$/', $cphone)) {
                echo "<script>
                if (confirm('Enter a valid phone number.')) {
                    document.getElementById('editButton').click(); 
                } else {
                    window.location.href = 'users.php';
                }
            </script>";
            } else {
                $accCheck = "SELECT * FROM users WHERE (email = '$email' OR phone='$phone')";
                $result_1 = $con->query($accCheck);
                if ($result_1->num_rows > 0) {
                    echo "<script>
                    if (confirm('User with given email or phone number already exists')) {
                        document.getElementById('editButton').click(); 
                    } else {
                        window.location.href = 'users.php';
                    }
                </script>";
                } else {
                    // Update worker details in the database
                    $query = "UPDATE users SET username='$cusername', email='$cemail', phone='$cphone', location='$clocation' WHERE id=$cid";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        echo "<script>alert('Details updated successfully.'); window.location.href = 'users.php';</script>";
                        exit;
                    } else {
                        echo "<script>
                        if (confirm('Error updating')) {
                            document.getElementById('editButton').click(); 
                        } else {
                            window.location.href = 'users.php';
                        }
                    </script>" . mysqli_error($con);
                    }
                }
            }
        } else {
            if (strlen($cusername) < 3 || strlen($cusername) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $cusername)) {
                echo "<script>
                if (confirm('Enter a valid name')) {
                    document.getElementById('editButton').click(); 
                } else {
                    window.location.href = 'users.php';
                }
            </script>";
            } else if (strlen($clocation) < 5 || strlen($clocation) > 30) {
                echo "<script>
                if (confirm('Enter a valid location.')) {
                    document.getElementById('editButton').click(); 
                } else {
                    window.location.href = 'users.php';
                }
            </script>";
            } else {
                $query = "UPDATE users SET username='$cusername', location='$clocation' WHERE id=$cid";
                $result0 = mysqli_query($con, $query);
                if ($result0) {
                    echo "<script>alert('Details updated successfully.'); window.location.href = 'users.php';</script>";
                    exit;
                } else {
                    echo "<script>
                    if (confirm('Error updating')) {
                        document.getElementById('editButton').click(); 
                    } else {
                        window.location.href = 'users.php';
                    }
                </script>" . mysqli_error($con);
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
