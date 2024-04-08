<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    include "../connect.php";

    $cid = $_POST['change_id'];
    $cusername = $_POST['change_username'];
    $cemail = $_POST['change_email'];
    $cphone = $_POST['change_phone'];
    $carea = $_POST['warea'];
    $cpassword = $_POST['change_password'];

    // Validate if all required fields are filled
    if (empty($cusername) || empty($cemail) || empty($cphone) || empty($carea) || empty($cpassword)) {
        echo "One or more required fields are empty, Please fill in all the fields.";
    } else {
        // Check if the email or phone has been changed to a value that already exists
        $checkAcc = "SELECT * FROM workers WHERE (email = '$cemail' OR phone='$cphone') AND id != $cid";
        $res = $con->query($checkAcc);
        if ($res->num_rows > 0) {
            echo "<script>alert('Another user with the same email or phone already exists.');</script>";
        } else {
            // Validate email and phone
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $cemail)) {
                echo "<script>alert('Invalid email format!');</script>";
            } else if (!preg_match('/^(98|97)\d{8}/', $cphone)) {
                echo "<script>alert('Enter a valid phone number!');</script>";
            } else {
                // Hash the password before updating (if provided)
                if (!empty($cpassword)) {
                    $hcpassword = password_hash($cpassword, PASSWORD_DEFAULT);
                    $updatepw = ", password='$hcpassword'";
                } else {
                    $updatepw = "";
                }

                // Update worker details in the database
                $query = "UPDATE workers SET name='$cusername', email='$cemail', phone='$cphone', service_area='$carea' $updatepw WHERE id=$cid";
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo "<script>alert('Details updated successfully.'); window.location.href = 'workers.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Error updating details.');</script>" . mysqli_error($con);
                }
            }
        }
    }
    mysqli_close($con);
} elseif (isset($_POST['cancel'])) {
    header("Location: workers.php");
    exit;
}
?>
