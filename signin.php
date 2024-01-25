<?php
// signin.php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home service";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Validate user credentials
$sql = "SELECT * FROM serviceuser WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        echo "Sign in successful. Welcome, " . $row['username'];
        // Redirect to the user's dashboard or another page
    } else {
        echo "Invalid password. Please try again.";
    }
} else {
    echo "User not found. Please check your email or password and try again.";
}

// Close connection
$conn->close();
?>
