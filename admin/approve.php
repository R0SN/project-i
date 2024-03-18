<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $id = $_POST['id'];

    // Fetch data from the applications table
    $query0 = "SELECT * FROM applications WHERE id='$id'";
    $result = $con->query($query0);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        $wname = $data["name"];
        $wemail = $data["email"];
        $wphone = $data["phone"];
        $wskill = $data["skill"];
        $warea = $data["service_area"];
        $wphoto = $data['photo'];
        $wcertificate = $data['certificate'];

        $photoSource = '../images/wphoto/' . $wphoto;
        $certiSource = '../images/wcerti/' . $wcertificate;

        $photoDesti = '../images/workers/photo/' . $wphoto;
        $certiDesti = '../images/workers/certificates/' . $wcertificate;

        // Check if worker with same email or phone already exists
        $checkQuery = "SELECT * FROM workers WHERE email='$wemail' OR phone='$wphone'";
        $checkResult = $con->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            echo "Worker with the same email or phone already exists.";
            header("Refresh:1; url=applications.php");

        } else {
            // Insert data into the workers table
            $query = "INSERT INTO workers (name, phone, email, skill,service_area, photo, certificate) 
                      VALUES ('$wname','$wphone','$wemail','$wskill','$warea','$wphoto','$wcertificate')";

            if ($con->query($query) === true) {
                // Delete the record from the applications table
                $del = "DELETE FROM applications WHERE id = '$id'";
                if (mysqli_query($con, $del)) {
                    // Move files to destination folders
                    rename($photoSource, $photoDesti);
                    rename($certiSource, $certiDesti);
                    // Redirect to applications.php after approval
                    header("Location: applications.php");
                    exit();
                } else {
                    echo "Error deleting record: " . mysqli_error($con);
                }
            } else {
                echo "Error inserting record: " . $con->error;
            }
        }
    } else {
        echo "No data found for the provided ID.";
    }
}

mysqli_close($con);
?>
