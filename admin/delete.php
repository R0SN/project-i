<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {

    $id = $_POST['id'];
    $query = "DELETE FROM users WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    if ($con->query($query) === false) {
        echo "User deletion failed";
    } else {
        header("Refresh:0; url=users.php");
    }
}
mysqli_close($con);
