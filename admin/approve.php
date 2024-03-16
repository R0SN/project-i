<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $id=$_POST['id'];
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $skill=$_POST['skill'];
    $photo=$_POST['photo'];
    $certificate=$_POST['certificate'];
    $query = "INSERT INTO workers (name,phone,email,skill,photo,certificate) VALUES ('$name','$phone','$email','$skill','$photo','$certificate') ";
    if ($con->query($query) === false) {
        echo "Application approve failed";
    } else{
        $del = "DELETE FROM applications WHERE id = '$id'";
        mysqli_query($con,$del);
        header("Refresh:0; url=applications.php");
    } 
}
mysqli_close($con);

