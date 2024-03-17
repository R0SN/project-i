<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline'])) {

    $id = $_POST['id'];
    $query0 = "SELECT * FROM applications WHERE id = '$id'";
    $result0 = mysqli_query($con, $query0);
    $data = $result0->fetch_assoc();
    $photo = $data['photo'];
    $certi = $data['certificate'];
    $photoPath ='../images/wphoto/' . $photo;
    $certiPath = '../images/wcerti/' .$certi;
    unlink($photoPath);
    unlink($certiPath);

    $query = "DELETE FROM applications WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    if ($con->query($query) === false) {
        echo "Application deletion failed";
    } else {
        header("Refresh:0; url=applications.php");
    }
}
mysqli_close($con);
