<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline'])) {

    $id = $_POST['id'];
    $query = "DELETE FROM applications WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    if ($con->query($query) === false) {
        echo "Application deletion failed";
    } else header("Refresh:0; url=applications.php");
}
mysqli_close($con);
