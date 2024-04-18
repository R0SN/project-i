<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include "../connect.php";
    $query = "SELECT * FROM workers"; // Query to fetch workers from the database
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result)
    ?>
    <form id="editForm" action='editWorkers.php' method='post'>
        <input type='hidden' name='id' value='<?php echo $row['id']; ?>' >
        <input type='hidden' name='name' value='<?php echo $row['name'] ?>' >
        <input type='hidden' name='email' value='<?php echo $row['email'] ?>' >
        <input type='hidden' name='phone' value='<?php echo $row['phone'] ?>' >
        <input type='hidden' name='skill' value='<?php echo $row['skill'] ?>' >
        <input type='hidden' name='service_area' value='<?php echo $row['service_area'] ?>' >
        <input type='hidden' name='photo' value='<?php echo $row['photo'] ?>' >
        <input type='hidden' name='certificate' value='<?php echo $row['certificate'] ?>' >
        <input type='hidden' name='password' value='<?php echo $row['password'] ?>' >
        <input type="submit"  name='edit' id="editButton" hidden>
        
        <!-- <button type='hidden' name='edit' id="editButton">Edit</button> -->
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
        

        $cid = $_POST['change_id'];
        $cusername = $_POST['change_username'];
        $cemail = $_POST['change_email'];
        $cphone = $_POST['change_phone'];
        $carea = $_POST['warea'];
        $cpassword = $_POST['change_password'];

        // Validate if all required fields are filled
        if (empty($cusername) || empty($cemail) || empty($cphone) || empty($carea) || empty($cpassword)) {
            echo "<script>
                    if (confirm('One or more required fields are empty. Please fill in all the fields.')) {
                        document.getElementById('editButton').click(); 
                    } else {
                        window.location.href = 'workers.php';
                    }
                </script>";
        } else {
            // Check if the email or phone has been changed to a value that already exists
            $checkAcc = "SELECT * FROM workers WHERE (email = '$cemail' OR phone='$cphone') AND id != $cid";
            $res = $con->query($checkAcc);
            if ($res->num_rows > 0) {
                echo "<script>
                if (confirm('Another user with the same email or phone already exists.')) {
                    document.getElementById('editButton').click(); // Click the edit button
                } else {
                    window.location.href = 'workers.php';
                }
            </script>";
            } else {
                // Validate email and phone
                if (!preg_match('/^[a-zA-Z][a-zA-Z0-9.]+@(?:gmail|yahoo|outlook|protonmail|icloud|aol|hotmail|mail|yandex|zoho).(com|me)$/', $cemail)) {
                    echo "<script>
                if (confirm('Invalid email format!')) {
                    document.getElementById('editButton').click(); // Click the edit button
                } else {
                    window.location.href = 'workers.php';
                }
            </script>";
                } else if (!preg_match('/^(98|97)\d{8}/', $cphone)) {
                    echo "<script>
                    if (confirm('Enter a valid phone number!')) {
                        document.getElementById('editButton').click(); // Click the edit button
                    } else {
                        window.location.href = 'workers.php';
                    }
                </script>";
                } else {
                    // Hash the password before updating (if provided)
                    if (!empty($cpassword)) {
                        $hcpassword = password_hash($cpassword, PASSWORD_DEFAULT);
                        $updatepw = ", password='$hcpassword'";
                    } else {
                        $updatepw = "";
                    }
                    // Validate username and location
                    if (strlen($cusername) < 3 || strlen($cusername) > 20 || !preg_match('/^[a-zA-Z\s]+$/', $cusername)) {
                        echo "<script>
                        if (confirm('Enter a valid name!')) {
                            document.getElementById('editButton').click(); // Click the edit button
                        } else {
                            window.location.href = 'workers.php';
                        }
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
                            if (confirm('Error updating details." . mysqli_error($con)."')) {
                                document.getElementById('editButton').click(); // Click the edit button
                            } else {
                                window.location.href = 'workers.php';
                            }
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
</body>

</html>
