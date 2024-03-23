<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {

    $id = $_POST['id'];
    $query0 = "SELECT * FROM workers WHERE id = '$id'";
    $result0 = mysqli_query($con, $query0);
    $data = $result0->fetch_assoc();
    $photo = $data['photo'];
    $certi = $data['certificate'];
    $photoPath ='../images/workers/photo/' . $photo;
    $certiPath = '../images/workers/certificates/' .$certi;
    unlink($photoPath);
    unlink($certiPath);

    $query1 = "DELETE FROM bookings WHERE worker_id = '$id'";
    $query = "DELETE FROM workers WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $result1 = mysqli_query($con, $query1);
    if ($con->query($query) === false) {
        echo "User deletion failed";
    } else header("Refresh:0; url=workers.php");
}
mysqli_close($con);
