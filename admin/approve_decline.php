<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/signin.php");
    exit();
}

include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'], $_POST['id'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if (!in_array($action, ['approve', 'decline'])) {
        die("Invalid action.");
    }

    if ($action === 'approve') {
        // Fetch application data
        $query0 = $con->prepare("SELECT * FROM applications WHERE id = ?");
        $query0->bind_param("i", $id);
        $query0->execute();
        $result = $query0->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            $wname = $data['name'];
            $wemail = $data['email'];
            $wphone = $data['phone'];
            $wskill = $data['skill'];
            $warea = $data['service_area'];
            $wphoto = $data['photo'];
            $wcertificate = $data['certificate'];

            $photoSource = "../images/wphoto/" . $wphoto;
            $certiSource = "../images/wcerti/" . $wcertificate;
            $photoDesti = "../images/workers/photo/" . $wphoto;
            $certiDesti = "../images/workers/certificates/" . $wcertificate;

            // Check if worker already exists
            $checkQuery = $con->prepare("SELECT * FROM workers WHERE email = ? OR phone = ?");
            $checkQuery->bind_param("ss", $wemail, $wphone);
            $checkQuery->execute();
            $checkResult = $checkQuery->get_result();

            if ($checkResult->num_rows > 0) {
                echo "Worker with the same email or phone already exists.";
                header("Refresh:1; url=applications.php");
                exit();
            }

            // Insert into workers table
            $insertQuery = $con->prepare("INSERT INTO workers (name, phone, email, skill, service_area, photo, certificate) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("sssssss", $wname, $wphone, $wemail, $wskill, $warea, $wphoto, $wcertificate);

            if ($insertQuery->execute()) {
                // Delete application record
                $deleteQuery = $con->prepare("DELETE FROM applications WHERE id = ?");
                $deleteQuery->bind_param("i", $id);

                if ($deleteQuery->execute()) {
                    // Move files
                    if (file_exists($photoSource) && file_exists($certiSource)) {
                        rename($photoSource, $photoDesti);
                        rename($certiSource, $certiDesti);
                    }

                    header("Location: applications.php");
                    exit();
                } else {
                    echo "Error deleting application: " . $con->error;
                }
            } else {
                echo "Error inserting worker: " . $con->error;
            }
        } else {
            echo "No data found for the provided ID.";
        }
    } elseif ($action === 'decline') {
        // Decline logic: delete application
        $deleteQuery = $con->prepare("DELETE FROM applications WHERE id = ?");
        $deleteQuery->bind_param("i", $id);

        if ($deleteQuery->execute()) {
            header("Location: applications.php");
            exit();
        } else {
            echo "Application deletion failed: " . $con->error;
        }
    }
} else {
    echo "Invalid request.";
}

$con->close();
