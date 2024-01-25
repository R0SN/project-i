<?php
// Database connection parameters
$servername = "localhost"; // Change if your MySQL server is on a different host
$username = "root"; // Change if you have a different MySQL username
$password = ""; // Change if you have set a password for your MySQL server
$dbname = "home service";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];

// Check if the passwords match
if ($password != $confirmPassword) {
    echo "Password and Confirm Password do not match. Please try again.";
} else {
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM serviceuser WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        echo "Email already exists. Please use a different email address.";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO serviceuser (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Account created successfully. Redirecting to sign-in page...";
            
            // Redirect to sign-in page after a short delay
            header("refresh:2;url=signin.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
