<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hash the input for the first password field
    $hashedInput = password_hash($_POST["one"], PASSWORD_DEFAULT);
    $inputTwo = $_POST["two"];

    if (isset($_POST['submit'])) {
        // Compare the hashed input with the second input
        if (password_verify($inputTwo, $hashedInput)) {
            echo "true";
        } else {
            echo "false";
        }
    } else {
        echo "Please enter a value in the second field.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Comparison</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="password" id="one" name="one">
        <input type="password" id="two" name="two">
        <input type="submit" name="submit"  value="Compare">
    </form>
</body>
</html>
