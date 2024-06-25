<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: ../user/signin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
        include "../connect.php";

    $id = $_POST['id'];
    $username = $_POST['name'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editUser.css" />
    <title>Admin(SkillSprint) - Edit User</title>
    <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">

</head>

<body>
    <h1>Edit</h1>
    <div class="container">
        <form action="confirmUserEdit.php" method="post">
            <label for="id">ID:</label>
            <input readonly type="number" id="id" name="change_id" value="<?php echo $id ?>"><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="change_username" value="<?php echo $username ?>"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="change_email" value="<?php echo $email ?>"><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="change_location" value="<?php echo $location ?>"><br>

            <label for="phone">Phone:</label>
            <input type="number" id="phone" name="change_phone" value="<?php echo $phone ?>"><br>

            <button type="submit" name="cancel">Cancel</button>
            <button type="submit" name="confirm">Confirm</button>
        </form>
    </div>
</body>

</html>